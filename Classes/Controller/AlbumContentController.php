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
 * Controller for Album Content 
 * 
 * This controller handles any changes applied to album contents
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */



/**
 * Class implements a controller for album content actions
 * 
 * @package Typo3
 * @subpackage yag
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-21
 */
class Tx_Yag_Controller_AlbumContentController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * Album repository 
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	private $albumRepository;
	
	
	/**
	 * Image Repository
	 * @var Tx_Yag_Domain_Repository_ImageRepository
	 */
	private $imageRepository;
	
	
	
	/**
	 * ImageFile Repository
	 * @var Tx_Yag_Domain_Repository_ImageFileRepository
	 */
	private $imageFileRepostitory;
	
	
	
    /**
     * Initialize Controller
     * 
     * @return void
     */
    public function initializeAction() {
        $this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
        $this->imageRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ImageRepository');
        $this->imageFileRepostitory = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ImageFileRepository');
    }
    
    
    
    /**
     * Renders the index page of album content controller
     *
     * @param Tx_Yag_Domain_Model_Gallery $gallery     Gallery object to which album belongs to
     * @param Tx_Yag_Domain_Model_Albumg $newAlbum     Album object to change contents of
     * @return string  The rendered index action
     */
    public function indexAction(
           Tx_Yag_Domain_Model_Gallery $gallery=NULL, 
           Tx_Yag_Domain_Model_Album $album=NULL) {
    	$this->view->assign('gallery', $gallery);
    	$this->view->assign('album', $album);
    }
    
    
	
	/**
	 * Adds new Photos to an album
	 * 
	 * @param Tx_Yag_Domain_Model_FormObject_AddImagesByPath $addImagesByPath  Form object holding form parameters
	 * @param Tx_Yag_Domain_Model_Gallery $gallery     Gallery object to create album in
	 * @param Tx_Yag_Domain_Model_Albumg $album     New album object in case of an error
	 * @return string  The rendered new action
	 */
	public function addImagesByPathAction(
	       Tx_Yag_Domain_Model_FormObject_AddImagesByPath $addImagesByPath = NULL,
	       Tx_Yag_Domain_Model_Gallery $gallery = NULL, 
	       Tx_Yag_Domain_Model_Album $album) {
	       	
        $albumPathConfiguration = Tx_Yag_Lib_AlbumPathConfiguration::getInstanceByAlbumPathObject($addImagesByPath);
            
        $addImagesToAlbumHandler = Tx_Yag_Lib_AddImagesToAlbumHandler::getInstanceByAlbumAndPathConfiguration(
            $album, $albumPathConfiguration);
        $images = $addImagesToAlbumHandler->addImagesFromPathConfiguration(); 
	    
        $this->view->assign('addImagesByPath', $addImagesByPath);
        $this->view->assign('images', $images);
		$this->view->assign('gallery', $gallery);
		$this->view->assign('album', $album);
		
		return $this->view->render();
		
	}
	
	
	
	/**
	 * Adds new photos to a album by a given file
	 *
	 * @param Tx_Yag_Domain_Model_FormObject_AddImagesByFile $addImagesByFile   Form object to handle form parameters
	 * @param Tx_Yag_Domain_Model_Album $album     Album to add images to
	 * @param Tx_Yag_Domain_Model_Gallery $gallery Gallery that contains album
	 * @return string The rendered add images by file action
	 */
	public function addImagesByFileAction(
	       Tx_Yag_Domain_Model_FormObject_AddImagesByFile $addImagesByFile,
	       Tx_Yag_Domain_Model_Album $album,
	       Tx_Yag_Domain_Model_Gallery $gallery = NULL) {

	    $fileadminPath = Tx_Yag_Div_YagDiv::getBasePath() . Tx_Yag_Div_YagDiv::getFileadminPath();
	    $parameters = $this->request->getArguments();
	    
	    // Generate path settings for this album
	    $albumPathConfiguration = Tx_Yag_Lib_AlbumPathConfiguration::getInstanceByAlbumPathObject($addImagesByFile);
	    /*$albumPathConfiguration = Tx_Yag_Lib_AlbumPathConfiguration::getInstanceByPaths(
           $addImagesByFile->getBasePath(), 
           $addImagesByFile->getThumbsPath(), 
           $addImagesByFile->getSinglesPath(),
           $addImagesByFile->getOrigsPath()
        );*/
        
        // Generate size settings for this album
        $albumSizeParameters = new Tx_Yag_Lib_AlbumSizeParameters();
        $albumSizeParameters->setSinglesHeight($addImagesByFile->getSinglesHeight());
        $albumSizeParameters->setSinglesWidth($addImagesByFile->getSinglesWidth());
        $albumSizeParameters->setSinglesQuality($addImagesByFile->getSinglesQuality());
        $albumSizeParameters->setThumbsHeight($addImagesByFile->getThumbsHeight());
        $albumSizeParameters->setThumbsWidth($addImagesByFile->getThumbsWidth());
        $albumSizeParameters->setThumbsQuality($addImagesByFile->getThumbsQuality());
        
        // Initialize crawler for given album path configuration
        $imageCrawler = Tx_Yag_Lib_ImageCrawler::getInstanceByAlbumPathConfiguration($albumPathConfiguration);
        $resizeObjects = $imageCrawler->getResizeObjectsForBasePathImages($albumSizeParameters);
	    
        Tx_Yag_Lib_ConvertImagesHandler::resizeImages($resizeObjects);
        
        $addImagesToAlbumHandler = Tx_Yag_Lib_AddImagesToAlbumHandler::getInstanceByAlbumAndPathConfiguration($album, $albumPathConfiguration);
        $images = $addImagesToAlbumHandler->addImagesFromPathConfiguration(); 

        $this->view->assign('addImagesByFile', $addImagesByFile);
	    $this->view->assign('images', $images);
	    $this->view->assign('album', $album);
	    $this->view->assign('gallery', $gallery);
	    return $this->view->render();
	       	
    }
	
	
	
	/**
	 * Returns a request parameter, if it's available.
	 * Returns NULL if it's not available
	 *
	 * @param string $parameterName
	 * @return string
	 */
	protected function getParameterSafely($parameterName) {
		if ($this->request->hasArgument($parameterName)) {
			return $this->request->getArgument($parameterName);
		}
		return NULL;
	}
	
}
?>
