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
 * Class definition file for a controller for the Album object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */



/**
 * Class implements a controller for all actions belonging to albums.
 * 
 * @package Typo3
 * @subpackage yag
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-15
 */
class Tx_Yag_Controller_AlbumController extends Tx_Yag_Controller_AbstractController {
	
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
	 * Shows all images of a album
	 *
	 * @param Tx_Yag_Domain_Model_Album    $album     Album object to show images from
	 * @param Tx_Yag_Domain_Model_Gallyer  $gallery   Gallery that holds album
	 * @return  string     The rendered index action
	 */
	public function indexAction(Tx_Yag_Domain_Model_Album $album=NULL, Tx_Yag_Domain_Model_Gallery $gallery=NULL) {
		$pager = new Tx_Yag_Lib_AlbumPager();
		
		// FIXME Change implementation of pager viewhelper so that object is set automatically from request parameters
		$pager->setRequestSettings($this->getPagerRequestSettings());
		$pager->setTotalItemCount($album->getImages()->count());
		$pager->setItemsPerPage($this->settings['album']['itemsPerPage']);
	    $images = $album->getPagedImages($pager);
	    
        $this->generateRssTag($album->getUid());	

        #http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js
        $GLOBALS['TSFE']->additionalHeaderData['colorbox'] = $this->generateColorboxHeaderScript();
        
	    $this->view->assign('pager', $pager);
	    $this->view->assign('images', $images);
		$this->view->assign('album', $album);
	    $this->view->assign('gallery', $gallery);
	}
	
	
	
	/**
	 * Shows a minimalistic rendering of album used for standalone album rendering
	 *
	 * @param Tx_Yag_Domain_Model_Album $album Album object to show images from
	 * @return string The rendered action
	 */
	public function showMinimalisticAlbumAction(Tx_Yag_Domain_Model_Album $album=NULL) {
		// TODO create flexform config for all this!
		
		// TODO make index action configurable to do the same thing?
		
		// if no album is given, try to load via settings
		if ($album == null) {
			if ($this->settings['album']['albumToDisplay'] > 0) {
				$album = $this->albumRepository->findByUid(intval($this->settings['album']['albumToDisplay']));
			} else {
				throw new Exception('No album UID was given (settings.album.albumToDisplay)');
			}
		}
		
		$pager = new Tx_Yag_Lib_AlbumPager();
		$pager->setRequestSettings($this->getPagerRequestSettings());
		$pager->setTotalItemCount($album->getImages()->count());
		$pager->setItemsPerPage($this->settings['album']['itemsPerPage']);
		$images = $album->getPagedImages($pager);
		$GLOBALS['TSFE']->additionalHeaderData['colorbox'] = $this->generateColorboxHeaderScript();
		$this->view->assign('pager', $pager);
		$this->view->assign('images', $images);
		$this->view->assign('album', $album);
	}
	
	
	
	/**
	 * Returns JS-Script to be inserted for Colorbox usage
	 *
	 * @return string JS-Snippet for Colorbox usage
	 */
	protected function generateColorboxHeaderScript() {
		return "<!-- Colorbox embedding -->".
               "<link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"/fileadmin/jquery/colorbox/colorbox.css\" />".
               "<script type=\"text/javascript\" src=\"{$this->settings['jquery']['basePath']}\"></script>".
               "<script type=\"text/javascript\" src=\"{$this->settings['jquery']['colorBoxPath']}\"></script>".
               "<script type=\"text/javascript\">".
               "            $(document).ready(function(){".
               "                $(\"a[rel='albumcolorbox']\").colorbox();".
               "            });".
               "</script>";
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
		return 'index.php?id='.$this->settings['album']['rssPid'].'&tx_yag_pi1[album]='.$albumUid.'&type=100';
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
        
		$this->checkForAdminRights();
		
		$this->checkForAdminRights($newAlbum, $gallery);
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
		
		$this->checkForAdminRights();
		
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
	 * @param Tx_Yag_Domain_Model_Album   $album     Album to be deleted
	 * @param Tx_Yag_Domain_Model_Gallery $gallery   Gallery that holds album
	 * @return string   The rendered delete action
	 */
	public function deleteAction(
	       Tx_Yag_Domain_Model_Album $album=NULL, 
	       Tx_Yag_Domain_Model_Gallery $gallery=NULL) {
	       	
	    $this->checkForAdminRights($album, $gallery);

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
     * @param Tx_Yag_Domain_Model_Album   $album     Album to be edited
     * @param Tx_Yag_Domain_Model_Gallery $gallery   Gallery that holds album
     * @return string   The rendered edit action
     * @dontvalidate $album
     */
	public function editAction(
           Tx_Yag_Domain_Model_Album $album, 
           Tx_Yag_Domain_Model_Gallery $gallery=NULL) {
           	
        $this->checkForAdminRights();
           	
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
     * Edit images action for editing all images of an album at once
     *
     * @param Tx_Yag_Domain_Model_Album   $album    The album to edit images for 
     * @param Tx_Yag_Domain_Model_Gallery $gallery  The gallery that belongs to this album
     * @return string The rendered edit images action
     */
    public function editImagesAction(
           Tx_Yag_Domain_Model_Album $album, 
           Tx_Yag_Domain_Model_Gallery $gallery=NULL) {
           	
        $this->checkForAdminRights();
    	
        $this->view->assign('album', $album);
        $this->view->assign('gallery', $gallery);
        return $this->view->render();
           	
    }
    
    
    
    /**
     * Update images action for updating all images of an album at once
     *
     * @param Tx_Yag_Domain_Model_Album $album
     * @param Tx_Yag_Domain_Model_Gallery $gallery
     * @return string The rendered update images action
     */
    public function updateImagesAction(
           Tx_Yag_Domain_Model_Album $album, 
           Tx_Yag_Domain_Model_Gallery $gallery=NULL) {
           	
        $this->checkForAdminRights();
        
        // update images
        if ($this->request->hasArgument('images')) {
	        // Delete images
	        $album->deleteImagesByRequestArray($this->request->getArgument('images'));
	        // Update image properties
	        $album->updateImagesByRequestArray($this->request->getArgument('images'));
        }
        
        // update cover
        if ($this->request->hasArgument('cover')) {
        	$album->setCoverByUid($this->request->getArgument('cover'));
        }
         
        $this->albumRepository->update($album);
        $persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
        /* @var $persistenceManager Tx_Extbase_Persistence_Manager */
        $persistenceManager->persistAll();
        
        $this->flashMessages->add('Images have been updated!');
        $this->redirect('editImages', NULL, NULL, array('album' => $album, 'gallery' => $gallery));
           	
    }
    
    
    
    /**
     * Rss Feed Action rendering a RSS Feed of media
     *
     * @param Tx_Yag_Domain_Model_Album $album Album to generate rss feed for
     * @return string   The rendered RSS Feed
     */
    public function rssAction(Tx_Yag_Domain_Model_Album $album = null) {
    	if ($album != null) {
	    	$this->view->assign('album', $album);
	    	return $this->view->render();
    	} else {
    		return "Kein Album --> kein RSS!";
    	}
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
