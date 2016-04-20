<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Daniel Lienert <lienert@punkt.de>, Michael Knoll <mimi@kaktusteam.de>
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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class implements filter that show only certain gallery uids
 *
 * @author     Michael Knoll <mimi@kaktusteam.de>
 * @package    Extlist
 * @subpackage Filter
 */
class GalleryUidFilter extends \Tx_PtExtlist_Domain_Model_Filter_AbstractFilter {
    /**
     * YAG ConfigurationBuilder
     * @var ConfigurationBuilder
     */
    protected $yagConfigurationBuilder;


    /**
     * Constructor for gallery filter
     */
    public function __construct() {
        parent::__construct();
        $this->yagConfigurationBuilder = ConfigurationBuilderFactory::getInstance();
    }

    public function initFilterBySession() {
    }

    public function getValue() {
    }

    public function _persistToSession() {
    }

    public function getFilterValueForBreadCrumb() {
    }

    public function buildFilterCriteria( \Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier ) {
    }

    /**
     * @see \Tx_PtExtlist_Domain_Model_Filter_FilterInterface::reset()
     *
     */
    public function reset() {
    }

    public function initFilter() {
    }

    /**
     * (non-PHPdoc)
     * @see Classes/Domain/Model/Filter/\Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::setActiveState()
     */
    public function setActiveState() {
        $this->isActive = true;
    }

    protected function initFilterByTsConfig() {
    }

    protected function initFilterByGpVars() {
    }

    /**
     * Build the filterCriteria for filter
     *
     * @return \Tx_PtExtlist_Domain_QueryObject_Criteria
     */
    protected function buildFilterCriteriaForAllFields() {
        $onlyInUidSettings = $this->filterConfig->getSettings( 'onlyInUids' );
        if ( ! is_array( $onlyInUidSettings ) ) { // getSettings gives us array() if there are no settings with this key
            $onlyInUids = GeneralUtility::trimExplode( ',', $onlyInUidSettings, true );
            if ( is_array( $onlyInUids ) && count( $onlyInUids ) ) {
                $filterCriteriaFromSettings = \Tx_PtExtlist_Domain_QueryObject_Criteria::in( 'uid', $onlyInUids );

                return $filterCriteriaFromSettings;
            }
        }

        $notInUidSettings = $this->filterConfig->getSettings( 'notInUids' );
        if ( ! is_array( $notInUidSettings ) ) { // getSettings gives us array() if there are no settings with this key
            $notInUids = GeneralUtility::trimExplode( ',', $this->filterConfig->getSettings( 'notInUids' ), true );
            if ( is_array( $notInUids ) && count( $notInUids ) > 0 ) {
                $filterCriteriaFromSettings = \Tx_PtExtlist_Domain_QueryObject_Criteria::notOp(
                    \Tx_PtExtlist_Domain_QueryObject_Criteria::in( 'uid', $notInUids )
                );

                return $filterCriteriaFromSettings;
            }
        }

        return null;
    }
}
