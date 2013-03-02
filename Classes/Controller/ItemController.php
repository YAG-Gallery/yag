<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
*  			Daniel Lienert <daniel@lienert.cc>
*  			
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
 * Controller for the Item object
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Controller_ItemController extends Tx_Yag_Controller_AbstractController {

    /**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function postInitializeAction() {
		$this->extListContext = $this->yagContext->getItemlistContext();
		$this->itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
		$this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
		$this->persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
	}

	
	
	/**
	 * Display image
	 * 
	 * Do not change this to item, as it is the UID of the item in the list,
	 * which is not the UID of the domain object!
	 * 
	 * @param int $itemListOffset
	 */
	public function showAction($itemListOffset = NULL) {
		
		/**
		 * We use a list here, as we have multiple items which we would like to filter, page etc.
		 * 
		 * As the identifier of the list we use for a single item is the same as for the items list, 
		 * we have to overwrite pager settings so that only a single item is displayed.
		 */
	
		// Overwrite pager settings so that only one item is displayed
		$this->extListContext->getPagerCollection()->setItemsPerPage(1);
		
		// itemUid is NOT the UID of the item but the index of the item in currently filtered list - so it's a list offset!
		if($itemListOffset) {
			$this->extListContext->getPagerCollection()->setPageByRowIndex($itemListOffset-1);	
		}
		
		$renderedListData =$this->extListContext->getRenderedListData();

		$this->extListContext->getPagerCollection()->setItemCount($this->extListContext->getDataBackend()->getTotalItemsCount());
		
		$pagerIdentifier = (empty($this->settings['pagerIdentifier']) ? 'default' : $this->settings['pagerIdentifier']);
		$pager = $this->extListContext->getPagerCollection()->getPagerByIdentifier($pagerIdentifier);
		
		if ($pager->getItemCount() == $pager->getCurrentPage()) {
			$this->view->assign('lastItem', 1);
		}
		
		$this->view->assign('mainItem', $renderedListData->getFirstRow()->getItemById('image')->getValue());
		$this->view->assign('absoluteRowIndex', $renderedListData->getFirstRow()->getSpecialValue('absoluteRowIndex'));		
		$this->view->assign('pagerCollection', $this->extListContext->getPagerCollection());
		$this->view->assign('pager', $pager);
	}
	
	
	
	/**
	 * Show a single (flexform defined) image
	 * 
	 * @param Tx_Yag_Domain_Model_Item $item
	 */
	public function showSingleAction(Tx_Yag_Domain_Model_Item $item = NULL) {
		
		if($item === NULL) {
			$itemUid = $this->configurationBuilder->buildContextConfiguration()->getSelectedItemUid();
			$this->yagContext->setItemUid($itemUid);
			$item = $this->yagContext->getItem();
			
			if($item === NULL) {
				$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_yag_controller_item.noItemSelected', $this->extensionName),'',t3lib_FlashMessage::ERROR);
				$this->forward('index', 'Error');	
			}
		}
		
		$this->view->assign('item', $item);
	}



	/**
	 * Action for deleting an item
	 *
	 * @param Tx_Yag_Domain_Model_Item $item Item to be deleted
	 * @param Tx_Yag_Domain_Model_Album $album Album to forward to
	 * @return string Rendered delete action
	 * @rbacNeedsAccess
	 * @rbacObject item
	 * @rbacAction delete
	 */
	public function deleteAction(Tx_Yag_Domain_Model_Item $item, Tx_Yag_Domain_Model_Album $album = NULL) {
        $item->delete();
        if ($album) {
        	$this->yagContext->setAlbum($album);
        }
        $this->forward('list', 'ItemList');
	}
	
	
	
	/**
	 * Bulk update action for updating all items of an album at once
	 * 
	 * TODO think about better way of mapping here
	 *
	 * @rbacNeedsAccess
	 * @rbacObject item
	 * @rbacAction update
	 */
	public function bulkUpdateAction() {

        $bulkEditData = $this->request->getArguments();

		// Somehow, mapping does not seem to work here - so we do it manually
		$album = $this->albumRepository->findByUid($bulkEditData['album']['uid']); /* @var $album Tx_Yag_Domain_Model_Album */

		if ($album == NULL) {
			$this->flashMessageContainer->add(
				Tx_Extbase_Utility_Localization::translate('tx_yag_controller_album.noAlbumSelected', $this->extensionName), '', t3lib_FlashMessage::ERROR
			);

			$this->forward('list', 'ItemList');
		}


		// Do we have to change thumb for album?
		if (!$album->getThumb() instanceof Tx_Yag_Domain_Model_Item || $album->getThumb()->getUid() != $bulkEditData['album']['thumb']) {
			$thumb = $this->itemRepository->findByUid($bulkEditData['album']['thumb']);
			if($thumb !== NULL) {
				$album->setThumb($thumb);
				$this->albumRepository->update($album);
			}
		}
		
		// Delete items that are marked for deletion
		foreach($bulkEditData['itemsToBeDeleted'] as $itemUid => $value) {
			if (intval($value) === 1) {
				$item = $this->itemRepository->findByUid($itemUid); /* @var $item Tx_Yag_Domain_Model_Item */
				if($item != NULL) {
					$item->delete();
				}
			}
		}
		
		// Update each item that is associated to album
		foreach($album->getItems() as $item) { /* @var $item Tx_Yag_Domain_Model_Item */
			$itemUid = $item->getUid();
			if(array_key_exists($itemUid, $bulkEditData['album']['item'])) {
				$itemArray = $bulkEditData['album']['item'][$itemUid];
				$item->setTitle($itemArray['title']);
				$item->setDescription($itemArray['description']);

				$itemAlbum = $this->albumRepository->findByUid(intval($itemArray['album']['__identity']));
				if($itemAlbum != NULL) {
					$item->setAlbum($itemAlbum);
				}
				
				$item->setTagsFromCSV($itemArray['tags']);
				$this->itemRepository->update($item);
			}
		}
		
		$this->persistenceManager->persistAll();
		
		$this->flashMessageContainer->add(
            Tx_Extbase_Utility_Localization::translate('tx_yag_controller_item.imagesUpdated', $this->extensionName),
            '',
            t3lib_FlashMessage::OK
        );

		$this->forward('list', 'ItemList');
	}



	/**
	 * Sends an item as download. The fileHash (or at least a part of 5 characters) is used to avoid grabbing the whole
	 * database by incrementing the itemUid.
	 *
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @param string $fileHash
	 */
	public function downloadAction(Tx_Yag_Domain_Model_Item $item, $fileHash) {

		$requestedFileName = Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($item->getSourceuri());
		$hashLength = strlen($fileHash) > 5 ? 5 : strlen($fileHash);

		if($fileHash == '' || $fileHash !== substr($item->getFilehash(), 0, $hashLength) || !is_readable($requestedFileName)) {
			$this->flashMessageContainer->add('The requested file was not found.', 'File not found', t3lib_FlashMessage::ERROR);
			$this->forward('index', 'Error');
		}

		$this->response->setHeader('Cache-control', 'public', TRUE);
		$this->response->setHeader('Content-Description', 'File transfer', TRUE);
		$this->response->setHeader('Content-Disposition', 'attachment; filename=' . $item->getOriginalFilename(), TRUE);
		$this->response->setHeader('Content-Type', $item->getItemType(), TRUE);
		$this->response->setHeader('Content-Transfer-Encoding', 'binary', TRUE);
		$this->response->sendHeaders();

		@readfile($requestedFileName);

		exit();

	}
	
}
?>