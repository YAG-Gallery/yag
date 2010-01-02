<?php

/***************************************************************
*  Copyright notice
*
*  (c) "now" could not be parsed by DateTime constructor. Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
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
 * Controller for the Gallery object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */



/**
 * Class implements a controller for all actions on galleries
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-22
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Controller_GalleryController extends Tx_Yag_Controller_AbstractController {
	
	/**
	 * Holds a reference to a gallery repository
	 *
	 * @var Tx_Yag_Domain_Repository_GalleryRepository
	 */
	protected $galleryRepository;
	
	
	
	/**
	 * Initialize Controller
	 * 
	 * @return void
	 */
	public function initializeAction() {
		$this->galleryRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository');
	}
	
	
	
	/**
	 * Action that is run, whenever a list of galleries should be displayed
	 * 
	 * @return string  The rendered index action
	 */
	public function indexAction() {
		// TODO take Flexform source here!
		$this->view->assign('galleries', $this->galleryRepository->findByPageId(6));
	}
	
	
	
	/**
	 * Action that is run, whenever a single galery should be displayed
	 *
	 * @param  Tx_Yag_Domain_Model_Gallery $gallery  Gallery to be shown
	 * @return string The rendered show action
	 */
	public function showAction(Tx_Yag_Domain_Model_Gallery  $gallery) {
		$this->view->assign('gallery', $gallery);
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
		
		$albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository'); /* @var $albumRepository Tx_Yag_Domain_Repository_AlbumRepository */
		// TODO add some rights stuff, so that only albums on source page can be added
		$availableAlbums = $albumRepository->findAll(); 
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
		return $this->view->render();
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
	
	
	
	/**
	 * Remove album action 
	 *
	 * @param Tx_Yag_Domain_Model_Gallery $gallery     Gallery object from which album should be removed
	 * @param Tx_Yag_Domain_Model_Album $album         Album to remove from gallery
	 * @return string The rendered remove album action
	 */
	public function removeAlbumAction(Tx_Yag_Domain_Model_Gallery $gallery, Tx_Yag_Domain_Model_Album $album) {
		
		$this->checkForAdminRights();
		
		if ($this->request->hasArgument('reallyDelete')) {
			$gallery->removeAlbum($album);
			$this->redirect('edit', NULL, NULL, array('gallery' => $gallery));
		} else {
			$this->view->assign('gallery', $gallery);
			$this->view->assign('album', $album);
		}
		
	}
	
	
	
	/**
	 * Adds a list of albums to gallery
	 *
	 * @param Tx_Yag_Domain_Model_Gallery $gallery Gallery to add albums to
	 * @return string  The rendered add action
	 */
	public function addAlbumAction(Tx_Yag_Domain_Model_Gallery $gallery) {
		
		$this->checkForAdminRights();
		
		if ($this->request->hasArgument('albums')) {
			$albumsToBeAdded = explode(',',$this->request->getArgument('albums'));
			$gallery->setAlbumsByAlbumUids($albumsToBeAdded);
		}
		$this->redirect('edit', NULL, NULL, array('gallery' => $gallery));
	}
	
}
?>
