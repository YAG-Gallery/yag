<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
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
 * Controller for the Album object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


class Tx_Yag_Controller_AlbumController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * Album repository 
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	private $albumRepository;
	
    /**
     * Initialize Controller
     * 
     * @return void
     */
    public function initializeAction() {
        $this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
    }
	
	/**
	 * list action
	 *
	 * @return string The rendered list action
	 */
	public function listAction() {
		
	}
	
	
	/**
	 * Shows all images of a album
	 *
	 * @param Tx_Yag_Domain_Model_Album    $album     Album object to show images from
	 * @param Tx_Yag_Domain_Model_Gallyer  $gallery   Gallery that holds album
	 * @return  string     The rendered index action
	 */
	public function indexAction(Tx_Yag_Domain_Model_Album $album=NULL, Tx_Yag_Domain_Model_Gallery $gallery=NULL) {
	    // TODO waiting for response from Mailinglist
		$pager = new Tx_Yag_Lib_AlbumPager();
		$pager->setRequestSettings($this->getPagerRequestSettings());
		// TODO put this into TS
		$pager->setTotalItemCount($album->getImages()->count());
		$pager->setItemsPerPage(10);
	    $images = $album->getPagedImages($pager);
	    
	    $this->view->assign('pager', $pager);
	    $this->view->assign('images', $images);
		$this->view->assign('album', $album);
	    $this->view->assign('gallery', $gallery);
	}
	
	/**
	 * Creates a new album
	 * 
	 * @param Tx_Yag_Domain_Model_Gallery $gallery     Gallery object to create album in
	 * @param Tx_Yag_Domain_Model_Albumg $newAlbum     New album object in case of an error
	 * @return string  The rendered new action
	 */
	public function newAction(Tx_Yag_Domain_Model_Gallery $gallery=NULL, Tx_Yag_Domain_Model_Album $newAlbum=NULL) {
		//print_r($this->arguments);
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
		$this->albumRepository->add($newAlbum);
		if ($gallery != NULL) {
			$gallery->addAlbum($newAlbum);
		}
		$this->flashMessages->add('Your new album was created.');
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		/* @var $persistenceManager Tx_Extbase_Persistence_Manager */
		$persistenceManager->persistAll();
		$this->redirect('index','Album', NULL, array('album' => $newAlbum, 'gallery' => $gallery));
	}
	
	
	
	/**
	 * Delete action for deleting an album
	 *
	 * @param Tx_Yag_Domain_Model_Album $album     Album to be deleted
	 * @param Tx_Yag_Domain_Model_Gallery $gallery Gallery that holds album
	 * @return string   The rendered delete action
	 */
	public function deleteAction(
	       Tx_Yag_Domain_Model_Album $album=NULL, 
	       Tx_Yag_Domain_Model_Gallery $gallery=NULL) {

	    if ($this->request->hasArgument('reallyDelete')) {
	        $this->albumRepository->remove($album);
	        $this->view->assign('deleted', 1);
	    } else {
	    	$this->view->assign('album', $album);
	    }
	    $this->view->assign('gallery', $gallery);
	    
	}
	
	
	
	/**
     * Edit action for editing an album
     *
     * @param Tx_Yag_Domain_Model_Album $album     Album to be edited
     * @param Tx_Yag_Domain_Model_Gallery $gallery Gallery that holds album
     * @return string   The rendered edit action
     */
	public function editAction(
           Tx_Yag_Domain_Model_Album $album, 
           Tx_Yag_Domain_Model_Gallery $gallery=NULL) {
           	
        $this->view->assign('gallery', $gallery);
        $this->view->assign('album', $album);
           	
    }
    
    
    
    /**
     * Update action for updating an album object
     *
     * @param Tx_Yag_Domain_Model_Album $album  Album to be updated
     * @param Tx_Yag_Domain_Model_Gallery $gallery  Gallery that contains album
     * @return string The rendered update action
     */
    public function updateAction(
           Tx_Yag_Domain_Model_Album $album, 
           Tx_Yag_Domain_Model_Gallery $gallery=NULL) {

       $this->albumRepository->update($album);
       $this->flashMessages->add('Your album has been updated!');
       $this->redirect('index', NULL, NULL, array('gallery' => $gallery, 'album' => $album));
       
    }
    
    
    
    /**
     * Generates a pager request settings object for given request parameters
     *
     * @return Tx_Yag_Lib_PagerRequestSettings
     */
    protected function getPagerRequestSettings() {
    	$pagerRequestSettings = new Tx_Yag_Lib_PagerRequestSettings();
    	$pagerRequestSettings->currentPageNumber = 1;
    	if ($this->request->hasArgument('pager_currentPageNumber')) {
    		$pagerRequestSettings->currentPageNumber = $this->request->getArgument('pager_currentPageNumber');
    	}
    	return $pagerRequestSettings;
    }
	
}
?>
