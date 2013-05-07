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

/**
 * Class implements the album->image filter
 * 
 * @author Daniel Lienert <lienert@punkt.de>
 * @package Extlist
 * @subpackage Filter
 */
class Tx_Yag_Extlist_Filter_AlbumFilter extends Tx_PtExtlist_Domain_Model_Filter_AbstractFilter {	

	/**
	 * YAG ConfigurationBuilder
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $yagConfigurationBuilder;

	
	/**
	 * Selected album
	 * 
	 * @var integer
	 */
	protected $albumUid;
	
	
	public function __construct() {
		parent::__construct();
		
		$this->yagConfigurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance();
	}
	

	protected function initFilterByTsConfig() {}
	protected function initFilterByGpVars() {}	
	public function initFilterBySession() {}
	public function persistToSession() {}
	public function getValue() {}
	
	
	/**
	 * @see Tx_PtExtlist_Domain_Model_Filter_FilterInterface::reset()
	 *
	 */
	public function reset() {
		$this->albumUid = 0;
		$this->filterQuery = new Tx_PtExtlist_Domain_QueryObject_Query();
		$this->init();
	}
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/Model/Filter/Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::initFilter()
	 */
	public function initFilter() {
		$selectedAlbum = Tx_Yag_Domain_Context_YagContextFactory::getInstance()->getAlbum();
		
		if($selectedAlbum) {
			$this->albumUid = $selectedAlbum->getUid();
			$this->setActiveState();	
		}
	}	
	
	
	public function getFilterValueForBreadCrumb() {}
	public function buildFilterCriteria(Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier) {}
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/Model/Filter/Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::setActiveState()
	 */
	public function setActiveState() {
		$this->isActive = TRUE;
	}
	
	
	
	/**
	 * Build the filterCriteria for filter 
	 * 
	 * @return Tx_PtExtlist_Domain_QueryObject_Criteria
	 */
	protected function buildFilterCriteriaForAllFields() {
		$albumField = $this->fieldIdentifierCollection->getFieldConfigByIdentifier('albumUid');
		$fieldName = Tx_PtExtlist_Utility_DbUtils::getSelectPartByFieldConfig($albumField);

		if($this->albumUid) {
			$criteria = Tx_PtExtlist_Domain_QueryObject_Criteria::equals($fieldName, $this->albumUid);
		} else {
			$criteria = Tx_PtExtlist_Domain_QueryObject_Criteria::greaterThan($fieldName, 0);
		}
		
		return $criteria;
	}
}