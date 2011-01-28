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
 * Class definition file for form object handling form parameters for
 * adding files by file form.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */



/**
 * Class implements a form object handling parameters from a form 
 * for adding images by file.
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-29
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Domain_Model_FormObject_AddImagesByFile implements Tx_Yag_Lib_AlbumPathSettingsInterface, Tx_Yag_Lib_AlbumResizeParametersInterface, Tx_Yag_Lib_AlbumQualityParametersInterface {
	
	/**
     * Base path to the directory containing the album images
     * @var Tx_Yag_Domain_Model_FormObject_AddImagesByPath
     */
    protected $albumPathObject;
    
    
	
    /**
     * Quality of single images (1..100)
     * @var int
     */
	protected $singlesQuality;
	
	
	
	/**
	 * Quality of thumbs images (1..100)
	 * @var int
	 */
	protected $thumbsQuality;
	
	
	
	/**
	 * Height of single images
	 * @var int
	 */
	protected $singlesHeight;
	
	
	
	/**
	 * Width of single images
	 * @var int
	 */
	protected $singlesWidht;
	
	
	
	/**
	 * Height of thumbnails
	 * @var int
	 */
	protected $thumbsHeight;
	
	
	
	/**
	 * Widht of thumbnails
	 * @var int
	 */
	protected $thumbsWidth;
	
	
	
	public function __construct() {
		$this->albumPathObject = new Tx_Yag_Domain_Model_FormObject_AddImagesByPath();
	}
	
	
	
	/**
	 * Returns base path
	 * @return string  Base path of album directory
	 */
	public function getBasePath() {
	   return $this->albumPathObject->getBasePath();
	}
	
	
	
	/**
	 * Returns paths of originals inside base path
	 * @return string  Path of originals inside base path
	 */
	public function getOrigsPath() {
	   return $this->albumPathObject->getOrigsPath();
	}
	
	
	
	/**
	 * Returns singles path inside base path
	 * @return string  Singles path inside base path
	 */
	public function getSinglesPath() {
	   return $this->albumPathObject->getSinglesPath();
	}
	
	
	
	/**
	 * Returns thumbnail path inside base path
	 * @return string  Thumbnail path inside base path
	 */
	public function getThumbsPath() {
	   return $this->albumPathObject->getThumbsPath();
	}
	
	
	
	/**
	 * Sets base path of album
	 * @param string   $basePath   Path to directory where album files reside
	 */
	public function setBasePath($basePath) {
	   $this->albumPathObject->setBasePath($basePath);
	}
	
	
	
	/**
	 * Sets path to original image files inside base path
	 * @param string $origsPath    Path to original images inside base path
	 */
	public function setOrigsPath($origsPath) {
	   $this->albumPathObject->setOrigsPath($origsPath);
	}
	
	
	
	/**
	 * Sets path to single files inside base path
	 * @param string $singlesPath  Path to single images inside base path
	 */
	public function setSinglesPath($singlesPath) {
	   $this->albumPathObject->setSinglesPath($singlesPath);
	}
	
	
	
	/**
	 * Sets thumbs path inside base path
	 * @param string   $thumbsPath     Path to thumbnails inside base path
	 */
	public function setThumbsPath($thumbsPath) {
	   $this->albumPathObject->setThumbsPath($thumbsPath);
	}

	
	
	/**
	 * Sets single images height
	 * @param int $singlesHeight  Height of single images
	 */
	public function setSinglesHeight($singlesHeight) {
	   $this->singlesHeight = $singlesHeight;
	}
	
	
	
	/**
	 * Sets quality of single images (1..100)
	 *
	 * @param int $singlesQuality   Quality of single images (1..100)
	 */
	public function setSinglesQuality($singlesQuality) {
	   $this->singlesQuality = $singlesQuality;
	}
	
	
	
	/**
	 * Sets width of single images
	 * @param int $singlesWidth    Width of single images
	 */
	public function setSinglesWidth($singlesWidth) {
	   $this->singlesWidht = $singlesWidth;
	}
	
	
	
	/**
	 * Set height of thumbnails
	 * @param int $thumbsHeight
	 */
	public function setThumbsHeight($thumbsHeight) {
	   $this->thumbsHeight = $thumbsHeight;
	}
	
	
	
	/**
	 * Set Quality of thumbnails (1..100)
	 * @param int $thumbsQuality
	 */
	public function setThumbsQuality($thumbsQuality) {
	   $this->thumbsQuality = $thumbsQuality;
	}
	
	
	
	/**
	 * Set width of thumbnails 
	 * @param int $thumbsWidth
	 */
	public function setThumbsWidth($thumbsWidth) {
	   $this->thumbsWidth = $thumbsWidth;
	}
	
	    
	
	/**
	 * Returns height of single images
	 * @return int
	 */
    public function getSinglesHeight() {
    	return $this->singlesHeight;
    }
    
    
    /**
     * Returns width of single images
     * @return int
     */
    public function getSinglesWidth() {
    	return $this->singlesWidht;
    }
    
    
    
    /**
     * Returns height of thumbnails
     * @return int
     */
    public function getThumbsHeight() {
    	return $this->thumbsHeight;
    }
    
    
    
    /**
     * Returns width of thumbnails
     * @return int
     */
    public function getThumbsWidth() {
    	return $this->thumbsWidth;
    }
    
    
    
    /**
     * Returns quality of single images
     * @return int
     */
    public function getSinglesQuality()  {
    	return $this->singlesQuality;
    }
    
    
    
    /**
     * Returns quality of thumbnail images
     * @return int
     */
    public function getThumbsQuality() {
    	return $this->thumbsQuality;
    }
    
}

?>
