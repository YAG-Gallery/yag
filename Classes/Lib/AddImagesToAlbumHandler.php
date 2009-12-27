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
 * Class definition file of a class that handles adding images to an album.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


/**
 * Class for handling the addition of images to an album.
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since  2009-12-22
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Lib_AddImagesToAlbumHandler {

	/**
	 * Holds the path configuration for album
	 * @var Tx_Yag_Lib_AlbumPathConfiguration
	 */
	protected $albumPathConfiguration;
	
	
	
	/**
	 * Holds album to add images to
	 * @var Tx_Yag_Domain_Model
	 */
	protected $album;
	
	
	
	/**
	 * Returns a new instance of this class
	 *
	 * @param Tx_Yag_Domain_Model_Album $album     Album to add images to
	 * @param Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration Path configuration of album
	 * @return Tx_Yag_Lib_AddImagesToAlbumHandler  New instance of this class
	 */
	public static function getInstanceByAlbumAndPathConfiguration(
	       Tx_Yag_Domain_Model_Album $album,
	       Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration) {
	   return new Tx_Yag_Lib_AddImagesToAlbumHandler($album, $albumPathConfiguration);
	}
	
	
	
	/**
	 * Constructor for this class (protected) use getInstance() methods instead!
	 *
	 * @param Tx_Yag_Domain_Model_Album $album     Album to add images to
	 * @param Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration   Path configuration of album
	 */
	protected function __construct(Tx_Yag_Domain_Model_Album $album, Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration) {
		$this->album = $album;
		$this->albumPathConfiguration = $albumPathConfiguration;
	}
	
	
	
    /**
     * Adds images to album using path configuration
     * 
     * @return Tx_Extbase_Persistence_ObjectStorage
     */
    public function addImagesFromPathConfiguration() {
        $images = new Tx_Extbase_Persistence_ObjectStorage();
        $fileNames = $this->getImagePathsByBasePath();
        foreach ($fileNames as $fileName) {
            // path is given without fileadmin prefix so add prefix here
            $images->attach($this->addImageByPath($fileName));
        }
        return $images;
    }
    
    
    
    /**
     * Returns an array of image paths for a given base path
     *
     * @return array   Array of image paths for given base path
     */
    protected function getImagePathsByBasePath() {
    	return Tx_Yag_Div_YagDiv::getFilesByPathAndPattern(
    	   $this->albumPathConfiguration->getFullTypo3OrigsPath(),
    	   '/\.jpg$/'
    	);
    }
    
    
    
    /**
     * Adds an image to current album identified by current path
     *
     * @param string                    $fileName    File name of image
     * @return Tx_Yag_Domain_Model_Image  Image that was added to album
     */
    protected function addImageByPath($fileName) {
        $image = new Tx_Yag_Domain_Model_Image();
        $image->setTitle($fileName);
        
        $thumbImageFile = $this->createNewImageFile($this->albumPathConfiguration->getThumbsPathRelativeToTypo3Root() . $fileName, $fileName, 'thumb');
        $image->setThumb($thumbImageFile);
        
        $singleImageFile = $this->createNewImageFile($this->albumPathConfiguration->getSinglesPathRelativeToTypo3Root() . $fileName, $fileName, 'single');
        $image->setSingle($singleImageFile);
        
        $origImageFile = $this->createNewImageFile($this->albumPathConfiguration->getOrigsPathRelativeToTypo3Root() . $fileName, $fileName, 'orig');
        $image->setOrig($origImageFile);
        
        $this->album->addImage($image);
        
        return $image;
    }
    
    
    
    /**
     * Creates a new imageFile object
     *
     * @param string $imageFilePath     Path to image file including image file name
     * @param string $imageFileName     Image file name
     * @param string $imageFileType     Type of image file (thumb, single, orig etc.)
     * @return Tx_Yag_Domain_ImageFile  New image file object
     */
    protected function createNewImageFile($imageFilePath, $imageFileName, $imageFileType) {
    	$imageFile = new Tx_Yag_Domain_Model_ImageFile();
        $imageFile->setFilePath($imageFilePath);
        $imageFile->setName($imageFileName);
        $imageFile->setType($imageFileType);
        return $imageFile;
    }
	
}

?>
