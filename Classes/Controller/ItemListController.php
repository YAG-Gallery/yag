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
 * Controller for the itemList
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Controller_ItemListController extends Tx_Yag_Controller_AbstractController {
	

	/**
	 * Show an Item List
	 *
	 * @return string The rendered show action
	 */
	public function listAction() {		
		$extListConfig = $this->configurationBuilder->buildExtlistConfiguration();
		$extListDataBackend = Tx_PtExtlist_Utility_ExternalPlugin::getDataBackendByCustomConfiguration($extListConfig->getExtlistSettingsByListId('albumList'), 'itemList');

		$list = Tx_PtExtlist_Utility_ExternalPlugin::getListByDataBackend($extListDataBackend);
		
		$rendererChain = Tx_PtExtlist_Domain_Renderer_RendererChainFactory::getRendererChain($extListDataBackend->getConfigurationBuilder()->buildRendererChainConfiguration());
		$renderedListData = $rendererChain->renderList($list->getListData());
		
		$pagerCollection = $extListDataBackend->getPagerCollection();
		$pagerCollection->setItemCount($extListDataBackend->getTotalItemsCount());
		$pagerIdentifier = (empty($this->settings['pagerIdentifier']) ? 'default' : $this->settings['pagerIdentifier']);
		$pager = $pagerCollection->getPagerByIdentifier($pagerIdentifier);
		
		$this->view->assign('listData', $renderedListData);
		$this->view->assign('pagerCollection', $pagerCollection);
		$this->view->assign('pager', $pager);
	}
}
?>