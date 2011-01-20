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
	 * Holds an instance of yag context
	 *
	 * @var Tx_Yag_Domain_YagContext
	 */
	protected $yagContext;
    
    

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function postInitializeAction() {
        $this->galleryRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository');
	}
	
	
	
	/**
	 * Show list of galleries
	 * 
	 * @return string Rendered list of galleries action 
	 */
	public function listAction() {
		// Reset all selections in yag context
		$this->yagContext->resetAll();

		$extlistContext = $this->yagContext->getGalleryListContext();
        $extlistContext->getPagerCollection()->setItemsPerPage($this->configurationBuilder->buildItemListConfiguration()->getItemsPerPage());
        $extlistContext->getPagerCollection()->setItemCount($extlistContext->getDataBackend()->getTotalItemsCount());
        $pagerIdentifier = (empty($this->settings['pagerIdentifier']) ? 'default' : $this->settings['pagerIdentifier']);
        
        $this->view->assign('listData', $extlistContext->getRenderedListData());
        $this->view->assign('pagerCollection', $extlistContext->getPagerCollection());
        $this->view->assign('pager', $extlistContext->getPagerCollection()->getPagerByIdentifier($pagerIdentifier));
	}
	

	
	/**
	 * Show the albums of the gallery
	 * 
	 * @param Tx_Yag_Domain_Model_Gallery $galleryUid Gallery to be rendered
	 * @return string Rendered Index action
	 */
	public function indexAction(Tx_Yag_Domain_Model_Gallery $gallery = null) {
		$extlistContext = $this->yagContext->getAlbumListContext();
		
		if ($gallery === null) {
			// If we do not get a gallery from Request, we try to get it from filter
		    $gallery = $extlistContext->getSelectedGallery();
		} else {
			// If we got a gallery from request, we set it to filter
			$filter = $extlistContext->getDataBackend()->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('galleryFilter');
            /* @var $filter Tx_Yag_Extlist_Filter_GalleryFilter */
			$filter->setGalleryUid($gallery->getUid());
		}
		
		// Set context
		$this->yagContext->resetSelectedAlbum();
		$this->yagContext->resetSelectedItem();
		if ($gallery !== null) {
			// Whatever gallery we got, we put it into context to make it accessable for other instances of plugin
		    $this->yagContext->setSelectedGallery($gallery);
		    $this->view->assign('gallery', $gallery);
		}
		
		
		$this->view->assign('pageIdVar', 'var pageId = ' . $_GET['id'] . ';');
		$this->view->assign('listData', $extlistContext->getRenderedListData());
	}
    
    
    
    /**
     * Edit action for gallery object
     *
     * @param Tx_Yag_Domain_Model_Gallery $gallery  Gallery to be edited
     * @return string The rendered edit action
     * @dontvalidate $gallery
     * @rbacNeedsAccess
     * @rbacObject Gallery
     * @rbacAction edit
     */
    public function editAction(Tx_Yag_Domain_Model_Gallery $gallery) {
        $this->view->assign('gallery', $gallery);
    }
    
    
    
    /**
     * Update action for gallery object
     *
     * @param Tx_Yag_Domain_Model_Gallery $gallery   Gallery to be updated
     * @return string The rendered update action
     * @rbacNeedsAccess
     * @rbacObject Gallery
     * @rbacAction edit
     */
    public function updateAction(Tx_Yag_Domain_Model_Gallery $gallery) {
        $this->galleryRepository->update($gallery);
        $this->flashMessages->add('Your gallery has been updated!');
        $this->redirect('index', NULL, NULL, array('gallery' => $gallery));
    }
    
    
    
    /**
     * Delete action for deleting a gallery
     *
     * @param int $galleryUid UID of gallery that should be deleted
     * @param bool $reallyDelete Set to true, if gallery should be deleted
     * @return string  The rendered delete action
     * @rbacNeedsAccess
     * @rbacObject Gallery
     * @rbacAction delete
     */
    public function deleteAction($galleryUid = null, $reallyDelete = false) {
        $gallery = $this->galleryRepository->findByUid($galleryUid);
        
        if ($reallyDelete == true || $gallery->getUid() == $galleryUid) {
        	$this->view->assign('gallery', $gallery);
        	if ($reallyDelete) {
        		$gallery->delete();
	        	$this->view->assign('deleted', 1);
        	} 
        } else {
        	$this->view->assign('noCorrectGalleryUid', 1);
        }
    	
    }
    
    
    
    /**
     * new action
     *
     * @param Tx_Yag_Domain_Model_Gallery $newGallery
     * @return string The rendered new action
     * @rbacNeedsAccess
     * @rbacObject Gallery
     * @rbacAction create
     */
    public function newAction(Tx_Yag_Domain_Model_Gallery $newGallery=NULL) {
        $this->view->assign('newGallery', $newGallery);
    }
    
    
    
    /**
     * Create  gallery action
     *
     * @param Tx_Yag_Domain_Model_Gallery $newGallery
     * @return string The rendered create action
     * @rbacNeedsAccess
     * @rbacObject Gallery
     * @rbacAction create
     */
    public function createAction(Tx_Yag_Domain_Model_Gallery $newGallery) {
        $this->galleryRepository->add($newGallery);
        $this->flashMessages->add('Your new gallery was created.');
        $this->redirect('list');
    }
    	
}

?>