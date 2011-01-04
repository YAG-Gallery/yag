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

/**
 * Class implements the album->image filter
 * 
 * @author Daniel Lienert <lienert@punkt.de>
 * @package Domain
 * @subpackage Model\Filter
 */
class Tx_Yag_Domain_Model_Filter_AlbumImageFilter extends Tx_PtExtlist_Domain_Model_Filter_AbstractSingleValueFilter {	

	
	/**
	 * Selected album
	 * @var int albumUid
	 */
	protected $selectedAlbum;
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/Model/Filter/Tx_PtExtlist_Domain_Model_Filter_AbstractOptionsFilter::initFilterByTsConfig()
	 */
	protected function initFilterByTsConfig() {
		if(!$this->filterValue) {
			$this->filterValue = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()->buildAlbumConfiguration()->getSelectedAlbumid();
		}
	}
	

	
	/**
	 * Build a criteria on the currently selected album
	 * @param Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier
	 * @return Tx_PtExtlist_Domain_QueryObject_SimpleCriteria
	 */
	protected function buildFilterCriteria(Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier) {
		$criteria = Tx_PtExtlist_Domain_QueryObject_Criteria::equals($fieldIdentifier->getTableFieldCombined(), $this->filterValue);
		return $criteria;
	}

}