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
	protected function initializeAction() {
		parent::initializeAction();
		$this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
	}

	
	/**
	 * Set the current album to the albumFilter
	 */
	public function showAction() {
		$albumUid = $this->configurationBuilder->buildAlbumConfiguration()->getSelectedAlbumId();
		
		$extListConfig = $this->configurationBuilder->buildExtlistConfiguration();
		$extListDataBackend = Tx_PtExtlist_Utility_ExternalPlugin::getDataBackendByCustomConfiguration($extListConfig->getExtlistSettingsByListId('itemList'), 'itemList'); 

		$extListDataBackend->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('albumFilter')->setAlbumUid($albumUid);
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
     */
    public function newAction(Tx_Yag_Domain_Model_Gallery $gallery=NULL, Tx_Yag_Domain_Model_Album $newAlbum=NULL) {
        
        #$this->checkForAdminRights();
        
        #$this->checkForAdminRights($newAlbum, $gallery);
        $this->view->assign('gallery', $gallery);
        $this->view->assign('newAlbum', $newAlbum);
    }
    
    
    
    /**
     * Adds a new album to repository
     *
     * @param Tx_Yag_Domain_Model_Album $newAlbum  New album to add
     * @return string  The rendered create action
     */
    public function createAction(Tx_Yag_Domain_Model_Album $newAlbum, Tx_Yag_Domain_Model_Gallery $gallery = NULL) {
        
        #$this->checkForAdminRights();
        
        $this->albumRepository->add($newAlbum);
        if ($gallery != NULL) {
            $gallery->addAlbum($newAlbum);
        }
        $this->flashMessages->add('Your new album was created.');
        $persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager'); /* @var $persistenceManager Tx_Extbase_Persistence_Manager */
        $persistenceManager->persistAll();
        $this->redirect('index','Album', NULL, array('album' => $newAlbum, 'gallery' => $gallery));
    }
    
    
    
    /**
     * Delete action for deleting an album
     *
     * @param int $albumUid UID of album that should be deleted
     * @param bool $reallyDelete True, if album should be deleted
     * @return string   The rendered delete action
     */
    public function deleteAction($albumUid = null, $reallyDelete = false) {
        #$this->checkForAdminRights($album, $gallery);
        $album = $this->albumRepository->findByUid($albumUid);
        if ($albumUid != null || $album->getUid == $albumUid) {
        	$this->view->assign('album', $album);
        	if ($reallyDelete) {
        		$album->delete();
        		$this->view->assign('deleted', 1);
        	} 
        } else {
        	$this->view->assign('noCorrectAlbumUid', 1);
        }
    	
    }
    
    
    
    /**
     * Edit action for editing an album
     *
     * @param Tx_Yag_Domain_Model_Album   $album     Album to be edited
     * @param Tx_Yag_Domain_Model_Gallery $gallery   Gallery that holds album
     * @return string   The rendered edit action
     * @dontvalidate $album
     */
    public function editAction(
           Tx_Yag_Domain_Model_Album $album, 
           Tx_Yag_Domain_Model_Gallery $gallery=NULL) {
            
        #$this->checkForAdminRights();
            
        $this->view->assign('gallery', $gallery);
        $this->view->assign('album', $album);
    }
    
    
    
    /**
     * Update action for updating an album object
     *
     * @param Tx_Yag_Domain_Model_Album   $album    Album to be updated
     * @param Tx_Yag_Domain_Model_Gallery $gallery  Gallery that contains album
     * @return string The rendered update action
     */
    public function updateAction(
           Tx_Yag_Domain_Model_Album $album=NULL, 
           Tx_Yag_Domain_Model_Gallery $gallery=NULL) {
            
       $this->checkForAdminRights();

       $this->albumRepository->update($album);
       $this->flashMessages->add('Your album has been updated!');
       $this->view->assign('album', $album);
       $this->view->assign('gallery', $gallery);
       $this->redirect('index', NULL, NULL, array('gallery' => $gallery, 'album' => $album));
       
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
    protected function getRssLink() {
        return 'index.php?id='.$_GET['id'].'tx_yag_pi1[action]=rss&tx_yag_pi1[controller]=Feeds&type=100';
    }
    
}

?>