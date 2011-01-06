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
 * Controller for the Album object
 *
 * @package Controller
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */


class Tx_Yag_Controller_GalleryController extends Tx_Yag_Controller_AbstractController {
	
	/**
	 * @var Tx_Yag_Domain_Repository_GalleryRepository
	 */
	protected $galleryRepository;
    
    

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
        $this->galleryRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository');
	}
	
	
	
	/**
	 * Show list of galleries
	 * 
	 * @return string Rendered list of galleries action 
	 */
	public function listAction() {
		$extListConfig = $this->configurationBuilder->buildExtlistConfiguration();
        $extListDataBackend = Tx_PtExtlist_Utility_ExternalPlugin::
            getDataBackendByCustomConfiguration($extListConfig->getExtlistSettingsByListId('galleryList'), 'galleryList');
		
        $pagerCollection = $extListDataBackend->getPagerCollection();
        $pagerCollection->setItemsPerPage($this->configurationBuilder->buildItemListConfiguration()->getItemsPerPage());
        
        $list = Tx_PtExtlist_Utility_ExternalPlugin::getListByDataBackend($extListDataBackend);
        
        $rendererChain = Tx_PtExtlist_Domain_Renderer_RendererChainFactory::
            getRendererChain($extListDataBackend->getConfigurationBuilder()->buildRendererChainConfiguration());
        $renderedListData = $rendererChain->renderList($list->getListData());
        
        
        $pagerCollection->setItemCount($extListDataBackend->getTotalItemsCount());
        $pagerIdentifier = (empty($this->settings['pagerIdentifier']) ? 'default' : $this->settings['pagerIdentifier']);
        $pager = $pagerCollection->getPagerByIdentifier($pagerIdentifier);
        
        
        $this->view->assign('listData', $renderedListData);
        $this->view->assign('pagerCollection', $pagerCollection);
        $this->view->assign('pager', $pager);
	}
	

	
	/**
	 * Show the albums of the gallery
	 * 
	 * @param int $galleryUid UID of gallery to be rendered
	 * @return string Rendered Index action
	 */
	public function indexAction($galleryUid = null) {
		$extListConfig = $this->configurationBuilder->buildExtlistConfiguration();
		$extListDataBackend = Tx_PtExtlist_Utility_ExternalPlugin::
		    getDataBackendByCustomConfiguration($extListConfig->getExtlistSettingsByListId('albumList'), 'albumList');
		$list = Tx_PtExtlist_Utility_ExternalPlugin::getListByDataBackend($extListDataBackend);
		
		$rendererChain = Tx_PtExtlist_Domain_Renderer_RendererChainFactory::getRendererChain($extListDataBackend->getConfigurationBuilder()->buildRendererChainConfiguration());
		$renderedListData = $rendererChain->renderList($list->getListData());
		
		$this->view->assign('listData', $renderedListData);
	}
    
    
    
    /**
     * Edit action for gallery object
     *
     * @param Tx_Yag_Domain_Model_Gallery $gallery  Gallery to be edited
     * @return string The rendered edit action
     * @dontvalidate $gallery
     */
    public function editAction(Tx_Yag_Domain_Model_Gallery $gallery) {
        
        $this->checkForAdminRights();
        
        #$albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository'); /* @var $albumRepository Tx_Yag_Domain_Repository_AlbumRepository */
        // TODO add some rights stuff, so that only albums on source page can be added
        $availableAlbums = $this->albumRepository->findAll(); 
        $selectedAlbums = $gallery->getAlbums(); 
        $this->view->assign('availableAlbums', $availableAlbums);
        $this->view->assign('selectedAlbums', $selectedAlbums);
        $this->view->assign('gallery', $gallery);
    }
    
    
    
    /**
     * Update action for gallery object
     *
     * @param Tx_Yag_Domain_Model_Gallery $gallery   Gallery to be updated
     * @return string The rendered update action
     */
    public function updateAction(Tx_Yag_Domain_Model_Gallery $gallery) {
        
        $this->checkForAdminRights();
        
        $this->galleryRepository->update($gallery);
        $this->flashMessages->add('Your gallery has been updated!');
        $this->redirect('show', NULL, NULL, array('gallery' => $gallery));
    }
    
    
    
    /**
     * Delete action for deleting a gallery
     *
     * @param Tx_Yag_Domain_Model_Gallery $gallery     Gallery to be deleted
     * @return string  The rendered delete action
     */
    public function deleteAction(Tx_Yag_Domain_Model_Gallery $gallery) {
        
        $this->checkForAdminRights();
        
        if ($this->request->hasArgument('reallyDelete')) {
            $this->galleryRepository->remove($gallery);
            $this->view->assign('deleted', 1);
        } else {
            $this->view->assign('gallery', $gallery);
        }
    }
    
    
    
    /**
     * new action
     *
     * @param Tx_Yag_Domain_Model_Gallery $newGallery
     * @return string The rendered new action
     */
    public function newAction(Tx_Yag_Domain_Model_Gallery $newGallery=NULL) {
        
        $this->checkForAdminRights();
        
        $this->view->assign('newGallery', $newGallery);
    }
    
    
    
    /**
     * Create  gallery action
     *
     * @param Tx_Yag_Domain_Model_Gallery $newGallery
     * @return string The rendered create action
     */
    public function createAction(Tx_Yag_Domain_Model_Gallery $newGallery) {
        $this->checkForAdminRights();
        
        $this->galleryRepository->add($newGallery);
        $this->flashMessages->add('Your new gallery was created.');
        $this->redirect('index');
    }	
}
?>