<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
	 * @var Tx_Yag_Domain_FileSystem_ResolutionFileCache
	 */
	protected $resolutionFileCache;



	/**
	 * @return void
	 */
	public function postInitializeAction() {
		$this->resolutionFileCache = Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance();
	}



	/**
	 * Render a message if no settings ar available
	 * @return string   The rendered delete action
     
     * @rbacNeedsAccess
     * @rbacObject ResolutionFileCache
     * @rbacAction delete
     */
	public function clearResolutionFileCacheAction() {
		$this->resolutionFileCache->clear();
		$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_yag_controller_resolutionFileCache.cacheSuccessfullyCleared', $this->extensionName));
		
		$this->forward('maintenanceOverview', 'Backend');
	}
	
	
	
	/**
	 * Build all resolutions for all images
	 */
	public function buildAllItemResolutionsAction() {
		$itemRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository'); /* @var $itemRepository Tx_Yag_Domain_Repository_ItemRepository */
		$items = $itemRepository->findAll();
		
		foreach($items as $item) {
			$this->resolutionFileCache->buildAllResolutionFilesForItem($item);
		}
	}



	/**
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @return void
	 */
	public function buildResolutionByConfigurationAction(Tx_Yag_Domain_Model_Item $item = NULL) {

		$selectedThemes = Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollectionFactory::getInstanceOfRegistrySelectedThemes($this->configurationBuilder);

		if($item != NULL) {

			$this->resolutionFileCache->buildResolutionFilesForItem($item,	$selectedThemes);
					
			$this->objectManager->get('Tx_Extbase_Persistence_Manager')->persistAll();
			$returnArray = $this->buildReturnArray($item);
		} else {
			$returnArray = array('nextItemUid' => 0);
		}

        t3lib_div::cleanOutputBuffers();
		echo json_encode($returnArray);
		exit();
	}



	/**
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @return void
	 */
	protected function buildReturnArray(Tx_Yag_Domain_Model_Item $item) {

		// The backend thumb
		$resolutionConfig = $this->configurationBuilder->buildThemeConfiguration()->getResolutionConfigCollection()->getResolutionConfig('icon64');
		$itemFileResolution = $this->resolutionFileCache->getItemFileResolutionPathByConfiguration($item, $resolutionConfig);

		// The next image uid
		$nextItem = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository')->getItemsAfterThisItem($item);
		$nextItemUid = 0;
		if($nextItem) $nextItemUid = $nextItem->getUid();

		$returnArray = array('thumbPath' => $itemFileResolution->getPath(),
							'thumbHeight' => $itemFileResolution->getHeight(),
							'thumbWidth' => $itemFileResolution->getWidth(),
							'nextItemUid' => $nextItemUid);

		return $returnArray;
	}

}
?>