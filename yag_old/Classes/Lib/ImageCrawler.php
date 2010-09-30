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
 * Class definition file of a class crawls for images
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


/**
 * Class for crawling for images
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since  2009-12-26
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Lib_ImageCrawler {
	
	/**
	 * Holds a reference to a album path configuration object
	 * @var Tx_Yag_Lib_AlbumPathConfiguration
	 */
	protected $albumPathConfiguration;
	
	
	
	/**
	 * Pattern to match files against
	 * @var string
	 */
	protected $imageFilePattern  = '/\.jpg$/';
	
	
	
	/**
	 * Factory method for this class
	 *
	 * @param Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration   Path configuration of album
	 * @param string $imageFilePattern         Pattern to match files against
	 * @return Tx_Yag_Lib_ImageCrawler    Instance of this class
	 */
	public static function getInstanceByAlbumPathConfiguration(
	       Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration, 
	       $imageFilePattern = '') {
		return new Tx_Yag_Lib_ImageCrawler($albumPathConfiguration, $imageFilePattern);
	}
	
	
	
	/**
	 * Constructor (protected), use getInstance methods to get an instance
	 *
	 * @param Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration
	 * @param string $imageFilePattern         Pattern to match files against
	 */
	protected function __construct(Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration, $imageFilePattern) {
		if ($imageFilePattern != '') {
			$this->imageFilePattern = $imageFilePattern;
		}
		$this->albumPathConfiguration = $albumPathConfiguration;
	}
	
	
	
	/**
	 * Returns images for given base path
	 * 
	 * @return array Array of file paths found in given directory
	 */
	public function getBasePathImages() {
		return Tx_Yag_Div_YagDiv::getFilesByPathAndPattern(
		  $this->albumPathConfiguration->getFullTypo3BasePath(),
		  $this->imageFilePattern);
	}
	
	
	
	/**
	 * Returns images for given thumbs path
	 *
	 * @return array Array of file paths found in given directory
	 */
	public function getThumbsPathImages() {
		return Tx_Yag_Div_YagDiv::getFilesByPathAndPattern(
		  $this->albumPathConfiguration->getFullTypo3BasePath() . $this->albumPathConfiguration->getThumbsPath(),
		  $this->imageFilePattern);
	}
	
	
	
	/**
	 * Returns images for given singles path
	 *
	 * @return array Array of file paths found in given directory
	 */
	public function getSinglesPathImages() {
		 return Tx_Yag_Div_YagDiv::getFilesByPathAndPattern(
          $this->albumPathConfiguration->getFullTypo3BasePath() . $this->albumPathConfiguration->getSinglesPath(),
          $this->imageFilePattern);
	}
	
	
	
	/**
	 * Returns images for given origs path
	 *
	 * @return array Array of file paths found in given directory
	 */
	public function getOrigsPathImages() {
		return Tx_Yag_Div_YagDiv::getFilesByPathAndPattern(
          $this->albumPathConfiguration->getFullTypo3BasePath() . $this->albumPathConfiguration->getOrigsPath(),
          $this->imageFilePattern);
	}
	
	
	
	/**
	 * Returns an array of objects that handles resizing for crawled images
	 *
	 * @param int $width       Wid
	 * @param int $height
	 * @param int $quality
	 * @return array Array of resize objects 
	 */
	public function getResizeObjectsForBasePathImages(Tx_Yag_Lib_AlbumSizeParameters $albumSizes) {
		$imagesInBasePath = $this->getBasePathImages();
		$imageResizeObjects = array();
		foreach($imagesInBasePath as $image) {
			$imageResizeObjects[] = $this->getThumbResizeObject($image, $albumSizes);
			$imageResizeObjects[] = $this->getSinglesResizeObject($image, $albumSizes);
		}
		return $imageResizeObjects;
	}
	
	
	
	/**
	 * Returns a resizing object for a thumb file
	 *
	 * @param stinrg $image  Path to original image to create thumb for
	 * @param Tx_Yag_Lib_AlbumSizeParameters $albumSizes   Parameter object for album sizes
	 * @return Tx_Yag_Lib_ResizingParameter   Resizing parameter for thumb file
	 */
	protected function getThumbResizeObject($image, Tx_Yag_Lib_AlbumSizeParameters $albumSizes) {
		$resizingObject = new Tx_Yag_Lib_ResizingParameter();
		$resizingObject->setWidth($albumSizes->getThumbsWidth());
		$resizingObject->setHeight($albumSizes->getThumbsHeight());
		$resizingObject->setSource($this->albumPathConfiguration->getFullTypo3BasePath() . $image);
		$resizingObject->setTarget($this->albumPathConfiguration->getFullTypo3BasePath() . $this->albumPathConfiguration->getThumbsPath() . $image);
		$resizingObject->setQuality($albumSizes->getThumbsQuality());
		print_r('thumb');
        print_r($resizingObject);
		return $resizingObject;
	}
	
	
	
	/**
	 * Returns a resizing object for a singles file
	 *
	 * @param string $image  Path to original image to create single for
	 * @param Tx_Yag_Lib_AlbumSizeParameters $albumSizes   Parameter for album sizes
	 * @return Tx_Yag_Lib_ResizingParameter    Resizing parameter for single file
	 */
	protected function getSinglesResizeObject($image, Tx_Yag_Lib_AlbumSizeParameters $albumSizes) {
		$resizingObject = new Tx_Yag_Lib_ResizingParameter();
        $resizingObject->setWidth($albumSizes->getSinglesWidth());
        $resizingObject->setHeight($albumSizes->getSinglesHeight());
        $resizingObject->setSource($this->albumPathConfiguration->getFullTypo3BasePath() . $image);
        $resizingObject->setTarget($this->albumPathConfiguration->getFullTypo3BasePath() . $this->albumPathConfiguration->getSinglesPath() . $image);
        $resizingObject->setQuality($albumSizes->getSinglesQuality());
        print_r('single');
        print_r($resizingObject);
        return $resizingObject;
	}

}

?>
