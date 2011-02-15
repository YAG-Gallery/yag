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
 * Gallery implements Item domain object. An item is anything that can be 
 * attached to an album as content.
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Domain
 * @subpackage Model
 */
class Tx_Yag_Domain_Model_Item extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * title
	 * @var string
	 */
	protected $title;
	
	
	
	/**
	 * description
	 * @var string
	 */
	protected $description;
	
	
    
    /**
     * itemMeta
     * @var Tx_Yag_Domain_Model_ItemMeta
     */
    protected $itemMeta;
    
    
    
    /**
     * URI for item source
     * @var string
     */
    protected $sourceuri;
    
    
    /**
     * Filename without path
     * 
     * @var string
     */
    protected $filename;
    
    
    /**
     * Type of item
     * 
     * @var string
     */
    protected $itemType;
    
    
    
     /**
     * The album this items belongs to
     * 
     * @lazy
     * @var Tx_Yag_Domain_Model_Album
     */
    protected $album;
    
    
    
    /**
     * Width of item
     *
     * @var int
     */
    protected $width;
    
    
    
    /**
     * Height of item
     *
     * @var int
     */
    protected $height;
    
    
    
    /**
     * Size of file
     *
     * @var int
     */
    protected $filesize;
    
    
    
    /**
     * Holds an sorting id for an item within an album
     *
     * @var int
     */
    protected $sorting;
    
    
    
	/**
	 * Setter for filename
	 *
	 * @param string $filename filename
	 * @return void
	 */
	public function setFilename($filename) {
		$this->filename = $filename;
	}
	
	

	/**
	 * Getter for filename
	 *
	 * @return string filename
	 */
	public function getFilename() {
		return $this->filename;
	}
    
	
	
	/**
	 * Setter for title
	 *
	 * @param string $title title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}
	
	

	/**
	 * Getter for title
	 *
	 * @return string title
	 */
	public function getTitle() {
		return $this->title;
	}
	
	
	
	/**
	 * Setter for album
	 *
	 * @param Tx_Yag_Domain_Model_Album $album album
	 * @return void
	 */
	public function setAlbum($album) {
		$this->album = $album;
	}
	
	

	/**
	 * Getter for album
	 *
	 * @return Tx_Yag_Domain_Model_Album album
	 */
	public function getAlbum() {
		return $this->album;
	}
	
	
	
	/**
	 * Setter for description
	 *
	 * @param string $description description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	

	/**
	 * Getter for description
	 *
	 * @return string description
	 */
	public function getDescription() {
		return $this->description;
	}
	
	
	
	/**
	 * Setter for itemType
	 *
	 * @param string $itemType itemType
	 * @return void
	 */
	public function setItemType($itemType) {
		$this->itemType = $itemType;
	}
	
	

	/**
	 * Getter for itemType
	 *
	 * @return string itemType
	 */
	public function getItemType() {
		return $this->itemType;
	}
	
	
    
    /**
     * Setter for itemMeta
     *
     * @param Tx_Yag_Domain_Model_ItemMeta $itemMeta itemMeta
     * @return void
     */
    public function setItemMeta(Tx_Yag_Domain_Model_ItemMeta $itemMeta) {
        $this->itemMeta = $itemMeta;
    }
    
    
    
    /**
     * Get image path by resolution config
     * 
     * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfig
     * @return Tx_Yag_Domain_Model_ResolutionFileCache
     */
    public function getResolutionByConfig($resolutionConfig) {
    	if($resolutionConfig != NULL) {
    		return  Tx_Yag_Domain_FileSystem_FileRepositoryFactory::getInstance()->getItemFileResolutionPathByConfiguration($this, $resolutionConfig);
    	} else {
    		return $this->getOriginalResolution();
    	}
    }
  
    
    
    /**
     * Get a resolutionFile that points to the original file path
     * 
     * @return Tx_Yag_Domain_Model_ResolutionFileCache
     */
    public function getOriginalResolution() {
    	
    	$resolutionFile = new Tx_Yag_Domain_Model_ResolutionFileCache(
    		$this,
    		$this->sourceuri,
    		$this->width,
    		$this->height,
    		100
    	);
    	
    	return $resolutionFile;
    }
    

    /**
     * Getter for itemMeta
     *
     * @return Tx_Yag_Domain_Model_ItemMeta itemMeta
     */
    public function getItemMeta() {
        return $this->itemMeta;
    }
    
    
    
	/**
	 * Getter for source URI of this item
	 * 
	 * @return string Source URI of this item
	 */
	public function getSourceuri() {
		return $this->sourceuri;
	}
	
	
	
	/**
	 * Setter for source URI of this item
	 * 
	 * @param string $sourceUri Source URI of this item
	 */
	public function setSourceuri($sourceuri) {
		$this->sourceuri = $sourceuri;
	}
	
	
	
	/**
	 * Getter for width of item
	 *
	 * @return int
	 */
	public function getWidth() {
		return $this->width;
	}
	
	
	
	/**
	 * Getter for height of item
	 *
	 * @return int
	 */
	public function getHeight() {
		return $this->height;
	}
	
	
	
	/**
	 * Setter for width
	 *
	 * @param int $width
	 */
	public function setWidth($width) {
		$this->width = $width;
	}
	
	
	
	/**
	 * Setter for height
	 *
	 * @param int $height
	 */
	public function setHeight($height) {
		$this->height = $height;
	}
	
	
	
	/**
	 * Getter for filesize
	 *
	 * @return int Size of file attached to item
	 */
	public function getFilesize() {
		return $this->filesize;
	}
	
	
	
	/**
	 * Setter for filesize
	 *
	 * @param int $filesize Size of file attached to item
	 */
	public function setFilesize($filesize) {
		$this->filesize = $filesize;
	}
	
	
	
	/**
	 * Getter for sorting
	 *
	 * @return int Sorting of item within an album
	 */
	public function getSorting() {
		return $this->sorting;
	}
	
	
	
	/**
	 * Setter for sorting. Sets position of item within an album
	 *
	 * @param int $sorting
	 */
	public function setSorting($sorting) {
		$this->sorting = $sorting;
	}
	
	

	/**
	 * Deletes item and its cached files from.
	 *
	 * @param bool $deleteCachedFiles If set to true, file cache for item is also deleted
	 */
	public function delete($deleteCachedFiles = true) {
		#$resetThumb = false;
		#print_r(get_class($this->getAlbum()));
		#if ($this->getAlbum()->getThumb()->getUid() == $this->getUid()) $resetThumb = true;
		if ($deleteCachedFiles) $this->deleteCachedFiles();
		
		$itemMetaRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemMetaRepository'); /* @var $itemMetaRepository Tx_Yag_Domain_Repository_ItemMetaRepository */
		$itemMetaRepository->remove($this->getItemMeta());
		
		$itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository'); /* @var $itemRepository Tx_Yag_Domain_Repository_ItemRepository */
		$itemRepository->remove($this);
		#if ($resetThumb) { 
		#    $this->album->setThumbToTopOfItems();
		#    t3lib_div::makeInstance(Tx_Yag_Domain_Repository_AlbumRepository)->update($this->album);
		#}
	}
	
	
	
	/**
	 * Deletes cached files for item
	 */
	public function deleteCachedFiles() {
		$resolutionFileCacheRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionFileCacheRepository'); /* @var $resolutionFileCacheRepository Tx_Yag_Domain_Repository_ResolutionFileCacheRepository */
		$resolutionFileCacheRepository->removeByItem($this);
	}
	
}
?>