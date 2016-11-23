<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>
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
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class Tx_Yag_Controller_ItemListController extends Tx_Yag_Controller_AbstractController
{
    /**
     * @var string
     */
    protected $listActionName;


    /**
     * (non-PHPdoc)
     * @see Classes/Controller/Tx_Yag_Controller_AbstractController::initializeAction()
     */
    public function postInitializeAction()
    {
        $this->extListContext = $this->yagContext->getItemlistContext();

        $this->extListContext->getPagerCollection()->setItemsPerPage($this->configurationBuilder->buildItemListConfiguration()->getItemsPerPage());

        $this->listActionName = $this->yagContext->getPluginModeIdentifier() == 'ItemList_unCachedList' ? 'unCachedList' : 'list';
    }


    protected function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view)
    {
        parent::initializeView($view);
        $this->view->assign('listAction', $this->listActionName);
    }
    
    
    /**
     * Submit a filter and show the images
     */
    public function submitFilterAction()
    {
        $this->extListContext->resetPagerCollection();
        $this->forward($this->listActionName);
    }

    
    
    /**
     * Reset filter and show the images
     */
    public function resetFilterAction()
    {
        $this->extListContext->resetFilterboxCollection();
        $this->extListContext->resetPagerCollection();
        $this->forward($this->listActionName);
    }


    /**
     * Uses the listAction to show the list
     */
    public function showAction()
    {
        $this->forward($this->listActionName);
    }



    /**
     * Show an Item List
     *
     * @param int $backFromItemUid sets the item if we come back from singleView
     * @return string The rendered show action
     */
    public function listAction($backFromItemUid = null)
    {
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

        $this->view->assign('filterBoxCollection', $this->extListContext->getFilterBoxCollection());
        $this->view->assign('listData', $this->extListContext->getRenderedListData());
        $this->view->assign('pagerCollection', $this->extListContext->getPagerCollection());
        $this->view->assign('pager', $this->extListContext->getPager($this->configurationBuilder->buildItemListConfiguration()->getPagerIdentifier()));

        Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance()->preloadCacheForItemsAndTheme(
            $this->extListContext->getRenderedListData(),
            $this->configurationBuilder->buildThemeConfiguration()
        );
    }



    /**
     * Show a an unCached itemList
     *
     * @return void
     */
    public function unCachedListAction()
    {
        $this->extListContext->getPagerCollection()->setItemCount($this->extListContext->getDataBackend()->getTotalItemsCount());

        $this->view->assign('filterBoxCollection', $this->extListContext->getFilterBoxCollection());
        $this->view->assign('listData', $this->extListContext->getRenderedListData());
        $this->view->assign('pagerCollection', $this->extListContext->getPagerCollection());
        $this->view->assign('pager', $this->extListContext->getPager($this->configurationBuilder->buildItemListConfiguration()->getPagerIdentifier()));

        Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance()->preloadCacheForItemsAndTheme(
            $this->extListContext->getRenderedListData(),
            $this->configurationBuilder->buildThemeConfiguration()
        );
    }



    /**
     * Send a zipFile containing the list data
     */
    public function downloadAsZipAction()
    {
        if (!$this->configurationBuilder->buildItemListConfiguration()->getZipDownloadActive()) {
            $this->flashMessageContainer->add('The zip download for this album is disabled.', 'Zip Download Disabled', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
            $this->forward('list');
        }

        $this->extListContext->getPagerCollection()->setItemsPerPage(0);

        $zipPackingService = $this->objectManager->get('Tx_Yag_Service_ZipPackingService'); /** @var Tx_Yag_Service_ZipPackingService $zipPackingService */
        $zipPackingService->_injectConfigurationBuilder($this->configurationBuilder);
        $zipPackingService->setItemListData($this->extListContext->getRenderedListData());
        $zipPackage = $zipPackingService->buildPackage();

        $this->response->setHeader('Cache-control', 'public', true);
        $this->response->setHeader('Content-Description', 'File transfer', true);
        $this->response->setHeader('Content-Disposition', 'attachment; filename=' . $zipPackingService->getFileName(), true);
        $this->response->setHeader('Content-Type', 'application/octet-stream', true);
        $this->response->setHeader('Content-Transfer-Encoding', 'binary', true);
        $this->response->sendHeaders();

        @readfile($zipPackage);

        exit();
    }


    
    /**
     * Action to render a separate pure XML List 
     * @deprecated use XML View instead
     */
    public function xmllistAction()
    {
        $this->extListContext->getPagerCollection()->setItemsPerPage($this->configurationBuilder->buildItemListConfiguration()->getItemsPerPage());

        $selectedAlbum = $this->yagContext->getAlbum();

        $this->view->assign('album', $selectedAlbum);
        $this->view->assign('listData', $this->extListContext->getRenderedListData());
    }
}
