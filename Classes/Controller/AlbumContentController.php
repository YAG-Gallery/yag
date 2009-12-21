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
	 * @param Tx_Yag_Domain_Model_Gallery $gallery     Gallery object to create album in
	 * @param Tx_Yag_Domain_Model_Albumg $album     New album object in case of an error
	 * @return string  The rendered new action
	 */
	public function addImagesAction(
	       Tx_Yag_Domain_Model_Gallery $gallery=NULL, 
	       Tx_Yag_Domain_Model_Album $album) {
	       	
	    $basePath = $thumbsPath = $singlesPath = '';
	       	
        $basePath    = $this->getParameterSafely('basePath');
        $thumbsPath  = $this->getParameterSafely('thumbsPath');
        $singlesPath = $this->getParameterSafely('singlesPath');
        $origsPath   = $this->getParameterSafely('origsPath');

        $images = $this->addImagesFromPath($album, $basePath, $thumbsPath, $singlesPath, $origsPath);
	    
        $this->view->assign('images', $images);
		$this->view->assign('gallery', $gallery);
		$this->view->assign('newAlbum', $album);
		
	}
	
	
	
	/**
	 * Adds images from a given path to album
	 * 
	 * @param Tx_Yag_Domain_Model_Albumg $album     Album to add images to
	 * @param string   $path        Path of directory to add images from
	 * @param string   $thumbsPath  Directory inside of path where thumbs are stored
	 * @param string   $singlesPath Directory inside of path where singles are stored
	 * @param string   $origsPath   Direcotry inside of path where originals are stored
	 */
	protected function addImagesFromPath($album, $path, $thumbsPath = '', $singlesPath = '', $origsPath = '') {
		if ($path !='') {
			$images = new Tx_Extbase_Persistence_ObjectStorage();
			$fileNames = $this->getImagePathsByBasePath($path, $origsPath);
			foreach ($fileNames as $fileName) {
				// path is given without fileadmin prefix so add prefix here
				$pathWithFileadmin = Tx_Yag_Div_YagDiv::getFileadminPath() . '/' . $path;
				$images->attach($this->addImageByPath($album, $fileName, $pathWithFileadmin, $thumbsPath, $singlesPath, $origsPath));
			}
		} else {
			throw new Exception("Base path must not be empty!");
		}
		return $images;
	}
	
	
	
	/**
	 * Returns an array of image paths for a given base path
	 *
	 * @param string $imagePath     Base path to search for pictures in
	 * @param string $origsPath     Path of original images inside base path
	 * @return array   Array of image paths for given base path
	 */
	protected function getImagePathsByBasePath($imagePath, $origsPath = '') {
		$imageBasePath = Tx_Yag_Div_YagDiv::getBasePath() . $imagePath;
		if ($origsPath != '') {
			$imageBasePath .= '/' . $origsPath . '/';
		}
		if (is_dir($imageBasePath)) {
		     $imageBasePathHandle = opendir($imageBasePath);
		     $imageFiles = array();
		     while (false !== ($filename = readdir($imageBasePathHandle))) {
		     	// TODO make this configurable via TS!
		     	if (preg_match('/\.jpg$/', $filename)) {
		     		$imageFiles[] = $filename;
		     	}
		     }
		     return $imageFiles;
		} else {
			throw new Exception("No directory found for given path!");
		}
	    
	}
	
	
	
	/**
	 * Adds an image to current album identified by current path
	 *
	 * @param Tx_Yag_Domain_Model_Album $album       Album to add image to
	 * @param string                    $fileName    File name of image
	 * @param string                    $basePath    Base path of album directory
	 * @param string                    $thumbsPath  Thumbnail path of album
	 * @param string                    $singlesPath Singles path of album
	 * @param string                    $origsPath   Originals path of album
	 * @return Tx_Yag_Domain_Model_Image  Image that was added to album
	 */
	protected function addImageByPath(Tx_Yag_Domain_Model_Album $album, 
	       $fileName, $basePath, $thumbsPath = '', $singlesPath = '', $origsPath = '') {
	       	
	    // TODO make default paths configurable by TS!
	    $fileName = $fileName == '' ? 'origs' : $fileName;
	    $thumbsPath = $thumbsPath == '' ? 'thumbs' : $thumbsPath;
	    $singlesPath = $singlesPath == '' ? 'singles' : $singlesPath;
	    $origsPath = $origsPath == '' ? '' : $origsPath;   // originals could be stored in root of album path!
	       	
        $image = new Tx_Yag_Domain_Model_Image();
        $image->setTitle($fileName);
        
        $thumbImageFile = new Tx_Yag_Domain_Model_ImageFile();
        $thumbImageFile->setFilePath($basePath . '/' . $thumbsPath . '/' . $fileName);
        $thumbImageFile->setName($fileName);
        $thumbImageFile->setType('thumb');
        $image->setThumb($thumbImageFile);
        
        $singleImageFile = new Tx_Yag_Domain_Model_ImageFile();
        $singleImageFile->setFilePath($basePath . '/' . $singlesPath . '/' . $fileName);
        $singleImageFile->setName($fileName);
        $singleImageFile->setType('single');
        $image->setSingle($singleImageFile);
        
        $origImageFile = new Tx_Yag_Domain_Model_ImageFile();
        $origImageFile->setFilePath($baseFilePath . '/' . $imageFileName);
        $origImageFile->setName($imageFileName);
        $origImageFile->setType('orig');
        $image->setOrig($origImageFile);
        
		$album->addImage($image);
		
		return $image;
		
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
