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
 * collection of resolution configs
 *
 * @package Domain
 * @subpackage Configuration\Image
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection extends Tx_PtExtbase_Collection_ObjectCollection {

	/**
	 * @var string
	 */
	protected $restrictedClassName = 'Tx_Yag_Domain_Configuration_Image_ResolutionConfig';
	
	
	
	/**
	 * Add a resolution config to the colection
	 * 
	 * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfig
	 * @param string $resolutionName
	 */
	public function addResolutionConfig(Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfig, $resolutionName) {
		$this->addItem($resolutionConfig, $resolutionName);
	}
	
	
	
	/** 
	 * @param string $resolutionName
	 * @return Tx_Yag_Domain_Configuration_Image_ResolutionConfig
	 */
	public function getResolutionConfig($resolutionName) {
		if($this->hasItem($resolutionName)) {
			return $this->getItemById($resolutionName);
		} else {
			throw new Exception('The resolution row with name ' . $resolutionName . ' is not defined! 1293862423');
		}
	}



	/**
	 * get part of the collection with entrys selected by the array
	 *
	 * @param array $themeIdentifierList
	 * @return Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection;
	 */
	public function extractCollectionByThemeList(array $themeIdentifierList) {

		if(current($themeIdentifierList) == '*') return $this;

		$collection = new Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection();

		foreach($themeIdentifierList as $themeIdentifier) {
			foreach($this->itemsArr as $itemName => $item) {
				if(substr($itemName, 0, strlen($themeIdentifier)) == $themeIdentifier) {
					$collection->addResolutionConfig($item, $itemName);
				}
			}
		}

		return $collection;
	}
}
?>