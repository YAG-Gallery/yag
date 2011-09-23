<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Controller for Resolution File Cache
 *
 * @package Controller
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Controller_ResolutionFileCacheController extends Tx_Yag_Controller_AbstractController {
    
	/**
	 * Render a message if no settings ar available
	 * @return string   The rendered delete action
     
     * @rbacNeedsAccess
     * @rbacObject ResolutionFileCache
     * @rbacAction delete
     */
	public function clearResolutionFileCacheAction() {
		$resolutionFileCache = Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance();
		$resolutionFileCache->clear();
		
		$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_yag_controller_resolutionFileCache.cacheSuccessfullyCleared', $this->extensionName));
		
		$this->forward('maintenanceOverview', 'Backend');
	}
	
	
	
	/**
	 * Build all resolutions for all images
	 * 
	 */
	public function buildAllItemResolutionsAction() {
		$itemRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository'); /* @var $itemRepository Tx_Yag_Domain_Repository_ItemRepository */
		$resolutionFileCache = Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance();
		
		$items = $itemRepository->findAll();
		
		foreach($items as $item) {
			$resolutionFileCache->buildAllResolutionFilesForItem($item);
		}
	}
	
	
	
	/**
	 * Build all resolution
	 * 
	 * @param Tx_Yag_Domain_Model_Item $item
	 */
	public function buildAllResolutionsForItemAction(Tx_Yag_Domain_Model_Item $item) {
		
		if($item != NULL) {
			$resolutionFileCache = Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance();
			$resolutionFileCache->buildAllResolutionFilesForItem($item);
			
			$this->objectManager->get('Tx_Extbase_Persistence_Manager')->persistAll();
			
			// return the backend thumb
			$resolutionConfig = $this->configurationBuilder->buildThemeConfiguration()->getResolutionConfigCollection()->getResolutionConfig('icon64');
			$itemFileResolution = $resolutionFileCache->getItemFileResolutionPathByConfiguration($item, $resolutionConfig);
			
			// return the next image uid
	
			$nextItem = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository')->getItemAfterThisItem($item);
			$nextItemUid = 0;
			if($nextItem) $nextItemUid = $nextItem->getUid();
			
			$returnArray = array('thumbPath' => $itemFileResolution->getPath(),
								'thumbHeight' => $itemFileResolution->getHeight(),
								'thumbWidth' => $itemFileResolution->getWidth(),
								'nextItemUid' => $nextItemUid);

			echo json_encode($returnArray);
		}	
		
		ob_flush();
		exit();
	}
	
}

?>