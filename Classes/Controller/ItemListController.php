<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Daniel Lienert <daniel@lienert.cc>
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
 * Controller for the itemList
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Controller_ItemListController extends Tx_Yag_Controller_AbstractController {
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Controller/Tx_Yag_Controller_AbstractController::initializeAction()
	 */
	public function postInitializeAction() {

	}
	
	
	
	/**
	 * Submit a filter and show the images
	 */
	public function submitFilterAction() {
		$this->initExtListContext();
		$this->extListContext->resetPagerCollection();
    	$this->forward('list');
	}

	
	
	/**
	 * Reset filter and show the images
	 */
	public function resetFilterAction() {
		$this->initExtListContext();
		$this->extListContext->resetFilterCollection();
    	$this->extListContext->resetPagerCollection();
    	$this->forward('list');
	}
	
	
	
	/**
	 * Show an Item List
	 *
	 * @param int $backFromItemUid sets the item if we come back from singleView
	 * @return string The rendered show action
	 */
	public function listAction($backFromItemUid = NULL) {
		$this->initExtListContext();
		$this->extListContext->getPagerCollection()->setItemsPerPage($this->configurationBuilder->buildItemListConfiguration()->getItemsPerPage());

		if ($backFromItemUid) {
			$this->extListContext->getPagerCollection()->setPageByRowIndex($backFromItemUid);
		}

		$this->extListContext->getPagerCollection()->setItemCount($this->extListContext->getDataBackend()->getTotalItemsCount());

		$selectedAlbum = $this->yagContext->getAlbum();

		$selectableGalleries = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository')->findAll();
		$albums = $this->objectManager->get('Tx_Yag_Domain_Repository_AlbumRepository')->findAll();

		$this->view->assign('selectableGalleries', $selectableGalleries);
		$this->view->assign('albums', $albums);
		$this->view->assign('album', $selectedAlbum);

		$this->view->assign('listData', $this->extListContext->getRenderedListData());
		$this->view->assign('pagerCollection', $this->extListContext->getPagerCollection());
		$this->view->assign('pager', $this->extListContext->getPager());

		Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance()->preloadCacheForItemsAndTheme(
			$this->extListContext->getRenderedListData(),
			$this->configurationBuilder->buildThemeConfiguration()
		);
	}



	/**
	 * Show a list of random images, flexform defines from which album and from which gallery
	 *
	 * @return void
	 */
	public function randomListAction() {
		$this->yagContext->setSelectRandomItems(TRUE);
		$this->initExtListContext();

		$this->extListContext->getPagerCollection()->setItemsPerPage($this->configurationBuilder->buildItemListConfiguration()->getItemsPerPage());

		$this->view->assign('listData', $this->extListContext->getRenderedListData());

		Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance()->preloadCacheForItemsAndTheme(
			$this->extListContext->getRenderedListData(),
			$this->configurationBuilder->buildThemeConfiguration()
		);
	}


	
	/**
	 * Action to render a separate pure XML List 
	 * 
	 */
	public function xmllistAction() {
		$this->initExtListContext();
		$this->extListContext->getPagerCollection()->setItemsPerPage($this->configurationBuilder->buildItemListConfiguration()->getItemsPerPage());
		
		$selectedAlbum = $this->yagContext->getAlbum();
        
        $this->view->assign('album', $selectedAlbum);
		$this->view->assign('listData', $this->extListContext->getRenderedListData());
	}
	
	
    
    /**
     * Generate and add RSS header for Cooliris
     * 
     * @param int $albumUid  UID of album to generate RSS Feed for
     * @return void
     */
    protected function generateRssTag($albumUid) {
        $tag = '<link rel="alternate" href="';
        $tag .= $this->getRssLink($albumUid);
        $tag .= '" type="application/rss+xml" title="" id="gallery" />';
        $GLOBALS['TSFE']->additionalHeaderData['media_rss'] = $tag;
    }
    
    
    
    /**
     * Getter for RSS link for media feed
     *
     * @param int $albumUid UID of album to generate RSS Feed for
     * @return string  RSS Link for media feed
     */
    protected function getRssLink($albumUid) {
        return 'index.php?id='.$_GET['id'].'tx_yag_pi1[action]=rss&tx_yag_pi1[controller]=Feeds&tx_yag_pi1[album]='.$albumUid.'&type=100';
    }



	protected function initExtListContext() {
		if($this->extListContext === NULL) {
			$this->extListContext = $this->yagContext->getItemlistContext();
		}
	}
	
}
?>