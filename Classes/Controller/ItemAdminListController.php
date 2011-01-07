<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>
*  			Michael Knoll <mimi@kaktusteam.de>
*  			
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
 * Controller for the itemAdminList
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Controller_ItemAdminListController extends Tx_Yag_Controller_AbstractController {
	
	
	/**
	 * @var Tx_PtExtlist_Domain_DataBackend_DataBackendInterface
	 */
	protected $extListDataBackend;
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Controller/Tx_Yag_Controller_AbstractController::initializeAction()
	 */
	public function initializeAction() {
		$extListConfig = $this->configurationBuilder->buildExtlistConfiguration();
		$this->extListDataBackend = Tx_PtExtlist_Utility_ExternalPlugin::
		    getDataBackendByCustomConfiguration($extListConfig->getExtlistSettingsByListId('itemList'), 'itemList');
	}
	
	
	
	/**
	 * Submit a filter and show the images
	 */
	public function submitFilterAction() {
		$this->extListDataBackend->getPagerCollection()->reset();
    	$this->forward('list');
	}

	
	
	/**
	 * Submit a filter and show the images
	 */
	public function resetFilterAction() {
    	$this->extListDataBackend->getFilterboxCollection()->reset();
    	$this->extListDataBackend->getPagerCollection()->reset();
    	$this->forward('list');
	}
	
	
	
	/**
	 * Show an Item List
	 *
	 * @param int $backFromItemUid sets the item if we come back from singleView
	 * @return string The rendered show action
	 */
	public function listAction($backFromItemUid = NULL) {		
	
		$pagerCollection = $this->extListDataBackend->getPagerCollection();
		$pagerCollection->setItemsPerPage($this->configurationBuilder->buildItemListConfiguration()->getItemsPerPage());
		
		if($backFromItemUid) {
			$pagerCollection->setPageByRowIndex($backFromItemUid);
		}
		
		
		$list = Tx_PtExtlist_Utility_ExternalPlugin::getListByDataBackend($this->extListDataBackend);
		
		$rendererChain = Tx_PtExtlist_Domain_Renderer_RendererChainFactory::getRendererChain($this->extListDataBackend->getConfigurationBuilder()->buildRendererChainConfiguration());
		$renderedListData = $rendererChain->renderList($list->getListData());
		
		
		$pagerCollection->setItemCount($this->extListDataBackend->getTotalItemsCount());
		$pagerIdentifier = (empty($this->settings['pagerIdentifier']) ? 'default' : $this->settings['pagerIdentifier']);
		$pager = $pagerCollection->getPagerByIdentifier($pagerIdentifier);
		
		$pageId = $_GET['id'];
		
		$this->view->assign('pageIdVar', 'var pageId = ' . $pageId . ';');
		$this->view->assign('listData', $renderedListData);
		$this->view->assign('pagerCollection', $pagerCollection);
		$this->view->assign('pager', $pager);
	}
	
}
?>