<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Daniel Lienert <lienert@punkt.de>, Michael Knoll <mimi@kaktusteam.de>
 *  All rights reserved
 *
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace DL\Yag\Extlist\Filter;

use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\Context\YagContextFactory;
use DL\Yag\Domain\Repository\AlbumRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class implements the gallery->album filter
 *
 * @author     Daniel Lienert <lienert@punkt.de>
 * @author     Michael Knoll <mimi@kaktusteam.de>
 * @package    Extlist
 * @subpackage Filter
 */
class GalleryFilter extends \Tx_PtExtlist_Domain_Model_Filter_AbstractFilter {
    /**
     * YAG ConfigurationBuilder
     * @var ConfigurationBuilder
     */
    protected $yagConfigurationBuilder;


    /**
     * Selected gallery
     * @var int galleryUid
     */
    protected $galleryUid;


    /**
     * @var boolean
     */
    protected $hideHidden;


    /**
     * Constructor for gallery filter
     */
    public function __construct() {
        parent::__construct();

        $this->yagConfigurationBuilder = ConfigurationBuilderFactory::getInstance();
    }


    protected function initFilterByTsConfig() {
    }

    protected function initFilterByGpVars() {
    }

    public function initFilterBySession() {
    }

    public function getValue() {
    }

    public function _persistToSession() {
    }

    public function getFilterValueForBreadCrumb() {
    }


    /**
     * @see \Tx_PtExtlist_Domain_Model_Filter_FilterInterface::reset()
     *
     */
    public function reset() {
        $this->galleryUid  = null;
        $this->filterQuery = new \Tx_PtExtlist_Domain_QueryObject_Query();
        $this->init();
    }


    public function initFilter() {
        $selectedGalleryUid = YagContextFactory::getInstance()->getGalleryUid();

        $this->hideHidden = ( TYPO3_MODE !== 'BE' );

        if ( $selectedGalleryUid ) {
            $this->galleryUid = $selectedGalleryUid;
            $this->setActiveState();
        }
    }


    /**
     * (non-PHPdoc)
     * @see Classes/Domain/Model/Filter/\Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::setActiveState()
     */
    public function setActiveState() {
        if ( $this->galleryUid > 0 || YagContextFactory::getInstance()->isInStrictFilterMode() ) {
            $this->isActive = true;
        }
    }


    /**
     * @param \Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier
     *
     * @return \Tx_PtExtlist_Domain_QueryObject_AndCriteria|\Tx_PtExtlist_Domain_QueryObject_SimpleCriteria
     */
    protected function buildFilterCriteria( \Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier ) {
        if ( $this->galleryUid ) {
            $fieldName = \Tx_PtExtlist_Utility_DbUtils::getSelectPartByFieldConfig( $fieldIdentifier );

            if ( $fieldIdentifier->getField() === 'album' ) {
                return $this->buildFilterCriteriaForAlbumField( $fieldName );
            } else {
                return $this->buildFilterCriteriaForGalleryField( $fieldName );
            }
        }
    }


    /**
     * @param $fieldName
     *
     * @return \Tx_PtExtlist_Domain_QueryObject_AndCriteria|\Tx_PtExtlist_Domain_QueryObject_SimpleCriteria
     */
    protected function buildFilterCriteriaForGalleryField( $fieldName ) {
        $criteria = \Tx_PtExtlist_Domain_QueryObject_Criteria::equals( $fieldName, $this->galleryUid );

        if ( $this->hideHidden ) {
            $criteria1 = $criteria;
            $criteria2 = \Tx_PtExtlist_Domain_QueryObject_Criteria::equals( 'hidden', '0' );
            $criteria  = \Tx_PtExtlist_Domain_QueryObject_Criteria::andOp( $criteria1, $criteria2 );
        }

        return $criteria;
    }


    /**
     * @param $fieldName
     *
     * @return \Tx_PtExtlist_Domain_QueryObject_SimpleCriteria
     */
    protected function buildFilterCriteriaForAlbumField( $fieldName ) {
        $criteria = \Tx_PtExtlist_Domain_QueryObject_Criteria::in( $fieldName, $this->getAlbumUidsOfGallery() );

        return $criteria;
    }


    /**
     * @return array
     */
    protected function getAlbumUidsOfGallery() {
        $albumRepository = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' )->get( 'DL\\Yag\\Domain\\Repository\\AlbumRepository' );
        /** @var $albumRepository AlbumRepository */

        $albums = $albumRepository->findByGallery( $this->galleryUid );

        $albumUids = array( 0 );

        foreach ( $albums as $album ) {
            $albumUids[] = $album->getUid();
        }

        return $albumUids;
    }


    /**
     * Set the gallery Uid
     *
     * @param int $galleryUid UID of gallery that filter should select
     */
    public function setGalleryUid( $galleryUid ) {
        $this->galleryUid = $galleryUid;
    }


    /**
     * Getter for gallery UID
     *
     * @return int UID of gallery filter filters albums by
     */
    public function getGalleryUid() {
        return $this->galleryUid;
    }
}
