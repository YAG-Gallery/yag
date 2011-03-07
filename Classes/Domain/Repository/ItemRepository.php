<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Michael Knoll <mimi@kaktusteam.de>
*           Daniel Lienert <daniel@lienert.cc>
*  All rights reserved
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
 * Repository for Tx_Yag_Domain_Model_Item
 *
 * @package Domain
 * @subpackage Repository
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Repository_ItemRepository extends Tx_Extbase_Persistence_Repository {
	
	
	/**
	 * Get the "image not found" default image
	 * 
	 * @param $sysImageConfigName
	 * @return Tx_Yag_Domain_Model_Item
	 */
	public function getSystemImage($sysImageConfigName) {
		
		$configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance();
		$sysImageConfigCollection = $configurationBuilder->buildSysImageConfiguration();
		
		if(!$sysImageConfigCollection->hasItem($sysImageConfigName)) {
			throw new Exception('No system image configuration with name ' . $sysImageConfigName . ' found! 1298832340');
		}
		
		$sysImageConfig = $sysImageConfigCollection->getSysImageConfig($sysImageConfigName);
		
		$sysImage = $this->findOneBySourceuri($sysImageConfig->getSourceUri());
		
		if($sysImage) {
			return $sysImage;
		} else {
			return $this->createNewSystemImage($sysImageConfig);
		}
	}
	
	

	/**
	 * Create and return a new System Image
	 * This image is persisted in the image database
	 * 
	 * @param Tx_Yag_Domain_Configuration_Image_SysImageConfig $sysImageConfig
	 * @return Tx_Yag_Domain_Model_Item
	 */
	protected function createNewSystemImage(Tx_Yag_Domain_Configuration_Image_SysImageConfig $sysImageConfig) {
		$sysImage = t3lib_div::makeInstance('Tx_Yag_Domain_Model_Item');
		$sysImage->setSourceuri($sysImageConfig->getSourceUri());
		$sysImage->setFilename(basename($sysImageConfig->getSourceUri()));
		$sysImage->setTitle($sysImageConfig->getTitle());
		$sysImage->setDescription($sysImageConfig->getDescription());
		
		list($width, $height, $type, $attr) = getimagesize(Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($sysImageConfig->getSourceUri()));
		$sysImage->setWidth($width);
		$sysImage->setHeight($height);
				
		$this->add($sysImage);
		return $sysImage;
	}
	
	
	
	/**
	 * Get the item wich is in the database after the given item
	 * 
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @return Tx_Yag_Domain_Model_Item $item
	 */
	public function getItemAfterThisItem(Tx_Yag_Domain_Model_Item $item = NULL) {
		$itemUid = $item ? $item->getUid() : 0;
		
		$query = $this->createQuery();
		$result = $query->matching($query->greaterThan('uid', $itemUid))
			  			->setLimit(1)
			  			->execute();
			  			
		
		$object = NULL;
		if ($result->current() !== FALSE) {
			$object = $result->current();
			$this->identityMap->registerObject($object, $object->getUid());
		}
		
		return $object;
	}
}
?>