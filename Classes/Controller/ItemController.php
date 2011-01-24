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
		$this->itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
	}

	
	
	/**
	 * 
	 * Enter description here ...
	 * @param int $itemUid
	 */
	public function showAction($itemUid = NULL) {
		
		/**
		 * We use a list here, as we have multiple items which we would like to filter, page etc.
		 * 
		 * As the identifier of the list we use for a single item is the same as for the items list, 
		 * we have to overwrite pager settings so that only a single item is displayed.
		 */
		
		$extListConfig = $this->configurationBuilder->buildExtlistConfiguration();
		$extListDataBackend = Tx_PtExtlist_Utility_ExternalPlugin::getDataBackendByCustomConfiguration($extListConfig->getExtlistSettingsByListId('itemList'), 'itemList');
		
		// Overwrite pager settings so that only one item is displayed
		$extListDataBackend->getPagerCollection()->setItemsPerPage(1);
		
		// itemUid is NOT the UID of the item but the index of the item in currently filtered list - so it's a list offset!
		if($itemUid) {
			$extListDataBackend->getPagerCollection()->setPageByRowIndex($itemUid);	
		}
		
		$list = Tx_PtExtlist_Utility_ExternalPlugin::getListByDataBackend($extListDataBackend);
		
		$rendererChain = Tx_PtExtlist_Domain_Renderer_RendererChainFactory::getRendererChain($extListDataBackend->getConfigurationBuilder()->buildRendererChainConfiguration());
		$renderedListData = $rendererChain->renderList($list->getListData());
		
		$pagerCollection = $extListDataBackend->getPagerCollection();
		$pagerCollection->setItemCount($extListDataBackend->getTotalItemsCount());
		$pagerIdentifier = (empty($this->settings['pagerIdentifier']) ? 'default' : $this->settings['pagerIdentifier']);
		$pager = $pagerCollection->getPagerByIdentifier($pagerIdentifier);
		
		$this->view->assign('mainItem', $renderedListData->getFirstRow()->getItemById('image')->getValue());
		$this->view->assign('absoluteRowIndex', $renderedListData->getFirstRow()->getSpecialValue('absoluteRowIndex'));		
		$this->view->assign('pagerCollection', $pagerCollection);
		$this->view->assign('pager', $pager);
	}
	
	
	
	/**
	 * Action for deleting an item
	 *
	 * @param int $itemUid UID of item that should be deleted
	 * @param bool $reallyDelete
	 * @return string Rendered delete action
	 * @rbacNeedsAccess
	 * @rbacObject Item
	 * @rbacAction delete
	 */
	public function deleteAction($itemUid = NULL, $reallyDelete = false) {
		$item = $this->itemRepository->findByUid($itemUid); /* @var $item Tx_Yag_Domain_Model_Item */
		if ($itemUid = null || !is_a($item, 'Tx_Yag_Domain_Model_Item')) {
			// No correct item UID is given
			$this->view->assign('noCorrectItemUid', 1);
			return $this->view->render();
		} else {
			// Correct item is given
			$this->view->assign('item', $item);
			if ($reallyDelete) {
				// Really delete item
		        $item->delete();
            	$this->view->assign('deleted', 1);
			}
		}
	}
	
}
?>