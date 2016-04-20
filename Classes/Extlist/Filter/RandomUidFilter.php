<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Daniel Lienert <lienert@punkt.de>, Michael Knoll <mimi@kaktsuteam.de>
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
use DL\Yag\Domain\Repository\ItemRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class implements the album->image filter
 *
 * @author     Daniel Lienert <lienert@punkt.de>
 * @package    Extlist
 * @subpackage Filter
 */
class RandomUidFilter extends \Tx_PtExtlist_Domain_Model_Filter_AbstractFilter {
    /**
     * YAG ConfigurationBuilder
     * @var ConfigurationBuilder
     */
    protected $yagConfigurationBuilder;


    /**
     * @var YagContext
     */
    protected $yagContext;


    public function __construct() {
        parent::__construct();

        $this->yagContext              = YagContextFactory::getInstance();
        $this->yagConfigurationBuilder = ConfigurationBuilderFactory::getInstance();
    }


    protected function initFilterByTsConfig() {
    }

    protected function initFilterByGpVars() {
    }

    public function initFilterBySession() {
    }

    public function _persistToSession() {
    }

    public function getValue() {
    }


    /**
     * @see \Tx_PtExtlist_Domain_Model_Filter_FilterInterface::reset()
     *
     */
    public function reset() {
        $this->filterQuery = new \Tx_PtExtlist_Domain_QueryObject_Query();
        $this->init();
    }


    /**
     * (non-PHPdoc)
     * @see Classes/Domain/Model/Filter/\Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::initFilter()
     */
    public function initFilter() {
        $this->setActiveState();
    }


    public function getFilterValueForBreadCrumb() {
    }

    public function buildFilterCriteria( \Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier ) {
    }


    /**
     * (non-PHPdoc)
     * @see Classes/Domain/Model/Filter/\Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::setActiveState()
     */
    public function setActiveState() {
        $this->isActive = $this->yagConfigurationBuilder->buildItemListConfiguration()->getUseRandomFilter();
    }


    /**
     * Build the filterCriteria for filter
     *
     * @return \Tx_PtExtlist_Domain_QueryObject_Criteria
     */
    protected function buildFilterCriteriaForAllFields() {
        $uidField  = $this->fieldIdentifierCollection->getFieldConfigByIdentifier( 'uid' );
        $fieldName = \Tx_PtExtlist_Utility_DbUtils::getSelectPartByFieldConfig( $uidField );
        $criteria  = \Tx_PtExtlist_Domain_QueryObject_Criteria::in( $fieldName, $this->getRandomUIDs() );

        return $criteria;
    }


    /**
     * @return array
     */
    protected function getRandomUIDs() {
        $itemRepository = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' )->get( 'DL\\Yag\\Domain\\Repository\\ItemRepository' );
        /** @var $itemRepository ItemRepository */
        $randomItemCount = $this->yagConfigurationBuilder->buildItemListConfiguration()->getItemsPerPage();

        return $itemRepository->getRandomItemUIDs( $randomItemCount, $this->yagContext->getGalleryUid(), $this->yagContext->getAlbumUid() );
    }
}
