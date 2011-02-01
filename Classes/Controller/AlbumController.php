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
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Controller_AlbumController extends Tx_Yag_Controller_AbstractController {
	
	/**
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;

	
	
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function postInitializeAction() {
		$this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
	}
	

	
	/**
	 * Show action for album.
	 * Set the current album to the albumFilter
	 * 
	 * @param Tx_Yag_Domain_Model_Album $album
	 */
	public function showAction(Tx_Yag_Domain_Model_Album $album = null) {
			
		if ($album === null) {
			// We try to get settings from flexform / TyposScript
			$albumUid = $this->settings['album']['selectedAlbumUid'];
			$album = $this->albumRepository->findByUid($albumUid);
		}
		$extListDataBackend = $this->yagContext->getItemlistContext()->getDataBackend(); 
		$extListDataBackend->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('albumFilter')->setAlbumUid($album->getUid());
    	$extListDataBackend->getPagerCollection()->reset();
		$this->forward('list', 'ItemList');
	}
	
	
    
    /**
     * Creates a new album
     * 
     * @param Tx_Yag_Domain_Model_Gallery $gallery     Gallery object to create album in
     * @param Tx_Yag_Domain_Model_Albumg $newAlbum     New album object in case of an error
     * @return string  The rendered new action
     * @dontvalidate $newAlbum
     * @rbacNeedsAccess
     * @rbacObject Album
     * @rbacAction create
     */
    public function newAction(Tx_Yag_Domain_Model_Gallery $gallery=NULL, Tx_Yag_Domain_Model_Album $newAlbum=NULL) {
        $this->view->assign('gallery', $gallery);
        $this->view->assign('newAlbum', $newAlbum);
    }
    
    
    
    /**
     * Adds a new album to repository
     *
     * @param Tx_Yag_Domain_Model_Album $newAlbum  New album to add
     * @return string  The rendered create action
     * @rbacNeedsAccess
     * @rbacObject Album
     * @rbacAction create
     */
    public function createAction(Tx_Yag_Domain_Model_Album $newAlbum, Tx_Yag_Domain_Model_Gallery $gallery = NULL) {
    	if ($gallery !== null) $newAlbum->addGallery($gallery);
        $this->albumRepository->add($newAlbum);
        if ($gallery != NULL) {
            $gallery->addAlbum($newAlbum);
        }
        $this->flashMessageContainer->add('Your new album was created.');
        $persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager'); /* @var $persistenceManager Tx_Extbase_Persistence_Manager */
        $persistenceManager->persistAll();
        $this->redirect('index','Gallery', NULL, array('gallery' => $gallery));
    }
    
    
    
    /**
     * Delete action for deleting an album
     *
     * @param int $albumUid UID of album that should be deleted
     * @param bool $reallyDelete True, if album should be deleted
     * @return string   The rendered delete action
     * @rbacNeedsAccess
     * @rbacObject Album
     * @rbacAction delete
     */
    public function deleteAction($albumUid = null, $reallyDelete = false) {
        $album = $this->albumRepository->findByUid($albumUid);
     
        if ($albumUid != null && $album->getUid == $albumUid) {
        	$this->view->assign('album', $album);
        	
        	if ($reallyDelete) {
        		$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_yag_controller_album.albumSuccessfullyDeleted', $this->extensionName, array($album->getName())));
        		$album->delete();
        		$this->redirect('index', 'Gallery');
        	} 
        	
        } else {
        	 $this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_yag_controller_album.albumWithUIDNotFound', $this->extensionName, array($albumUid)),'',
        										t3lib_FlashMessage::ERROR);
        	$this->redirect('index', 'Gallery');
        }
    	
    }
    
    
    
    /**
     * Action for adding new items to an existing gallery
     *
     * @param Tx_Yag_Domain_Model_Album $album Album to add items to
     * @rbacNeedsAccess
     * @rbacObject Album
     * @rbacAction edit
     */
    public function addItemsAction(Tx_Yag_Domain_Model_Album $album) {
    	$this->view->assign('album', $album);
    }
    
}

?>