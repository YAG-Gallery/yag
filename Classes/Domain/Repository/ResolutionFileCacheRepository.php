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
 * Repository for Tx_Yag_Domain_Model_ResolutionFileCache
 *
 * @package Domain
 * @subpackage Repository
 * @author Daniel Lienert <lienert@punkt.de>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Repository_ResolutionFileCacheRepository extends Tx_Extbase_Persistence_Repository {
	
	
	/**
	 * Get the item file resolution object
	 * 
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration
	 * @return Tx_Yag_Domain_Model_ResolutionFileCache
	 */
	public function getItemFilePathByConfiguration(Tx_Yag_Domain_Model_Item $item, Tx_Yag_Domain_Configuration_Image_ResolutionConfig	 $resolutionConfiguration) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectSysLanguage(FALSE);
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		
		$constraints = array();
		$constraints[] = $query->equals('item', $item->getUid());
		
		if($resolutionConfiguration->getWidth()) $constraints[] = $query->equals('width', $resolutionConfiguration->getWidth());
		if($resolutionConfiguration->getHeight()) $constraints[] = $query->equals('height', $resolutionConfiguration->getHeight());
		if($resolutionConfiguration->getQuality()) $constraints[] = $query->equals('quality', $resolutionConfiguration->getQuality());
		
		$result = $query->matching($query->logicalAnd($constraints))->execute();
		
		$object = NULL;
		if (count($result) > 0) {
			$object = current($result);
			$this->identityMap->registerObject($object, $uid);
		}
		
		return $object;
	}
	
}
?>