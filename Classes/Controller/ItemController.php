<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Michael Knoll <mimi@kaktusteam.de>
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
	 * @var Tx_Yag_Domain_Repository_ItemRepository
	 */
	protected $itemRepository;

	
	
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function postInitializeAction() {
		$this->extListContext = $this->yagContext->getItemlistContext();
		$this->itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
	}

	
	
	/**
	 * Display image
	 * 
	 * Do not change this to item, as it is the UID of the item in the list,
	 * which is not the UID of the domain object!
	 * 
	 * @param int $itemUid
	 */
	public function showAction($itemUid = NULL) {
		
		/**
		 * We use a list here, as we have multiple items which we would like to filter, page etc.
		 * 
		 * As the identifier of the list we use for a single item is the same as for the items list, 
		 * we have to overwrite pager settings so that only a single item is displayed.
		 */
	
		// Overwrite pager settings so that only one item is displayed
		$this->extListContext->getPagerCollection()->setItemsPerPage(1);
		
		// itemUid is NOT the UID of the item but the index of the item in currently filtered list - so it's a list offset!
		if($itemUid) {
			$this->extListContext->getPagerCollection()->setPageByRowIndex($itemUid);	
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
		
		if(!$item) {
			$itemUid = $this->configurationBuilder->buildItemConfiguration()->getSelectedItemUid();
			$this->yagContext->setItemUid($itemUid);
			$item = $this->yagContext->getSelectedItem();
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
	 * @rbacObject Item
	 * @rbacAction delete
	 */
	public function deleteAction(Tx_Yag_Domain_Model_Item $item, Tx_Yag_Domain_Model_Album $album = null) {
        $item->delete();
        if ($album) {
        	$this->yagContext->setAlbum($album);
        }
        $this->forward('list', 'ItemList');
	}
	
}
?>