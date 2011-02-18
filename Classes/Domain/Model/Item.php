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
     * Title of item
     *
     * @var string $title
     */
    protected $title;
    
    

    /**
     * filename of item
     *
     * @var string $filename
     */
    protected $filename;
    
    

    /**
     * Description of item
     *
     * @var string $description
     */
    protected $description;
    
    

    /**
     * Date of item
     *
     * @var DateTime $date
     */
    protected $date;
    
    

    /**
     * URI of item's source
     *
     * @var string $sourceuri
     */
    protected $sourceuri;
    
    

    /**
     * Type of item
     *
     * @var string $itemType
     */
    protected $itemType;
    
    

    /**
     * Width of item
     *
     * @var integer $width
     */
    protected $width;
    
    

    /**
     * Height of item
     *
     * @var integer $height
     */
    protected $height;
    
    

    /**
     * Filesize of item
     *
     * @var integer $filesize
     */
    protected $filesize;
    
    

    /**
     * UID of fe user that owns item
     *
     * @var integer $feUserUid
     */
    protected $feUserUid;
    
    

    /**
     * UID of fe group that owns item
     *
     * @var integer $feGroupUid
     */
    protected $feGroupUid;
    
    

    /**
     * Holds album to which item belongs to
     *
     * @var Tx_Yag_Domain_Model_Album $album
     */
    protected $album;
    
    

    /**
     * Holds meta data for item
     *
     * @var Tx_Yag_Domain_Model_ItemMeta $itemMeta
     */
    protected $itemMeta;
    
    
    
    /**
     * Holds an sorting id for an item within an album
     *
     * @var int
     */
    protected $sorting;
    
    
    
	/**
     * Setter for title
     *
     * @param string $title Title of item
     * @return void
     */
    public function setTitle($title) {
        $this->title = $title;
    }
    
    

    /**
     * Getter for title
     *
     * @return string Title of item
     */
    public function getTitle() {
        return $this->title;
    }

    
    
    /**
     * Setter for filename
     *
     * @param string $filename filename of item
     * @return void
     */
    public function setFilename($filename) {
        $this->filename = $filename;
    }
    
    

    /**
     * Getter for filename
     *
     * @return string filename of item
     */
    public function getFilename() {
        return $this->filename;
    }
    
    

    /**
     * Setter for description
     *
     * @param string $description Description of item
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }
    
    

    /**
     * Getter for description
     *
     * @return string Description of item
     */
    public function getDescription() {
        return $this->description;
    }
    
    

    /**
     * Setter for date
     *
     * @param DateTime $date Date of item
     * @return void
     */
    public function setDate(DateTime $date) {
        $this->date = $date;
    }
    
    

    /**
     * Getter for date
     *
     * @return DateTime Date of item
     */
    public function getDate() {
        return $this->date;
    }
    
    

    /**
     * Setter for sourceuri
     *
     * @param string $sourceuri URI of item's source
     * @return void
     */
    public function setSourceuri($sourceuri) {
        $this->sourceuri = $sourceuri;
    }
    
    

    /**
     * Getter for sourceuri
     *
     * @return string URI of item's source
     */
    public function getSourceuri() {
        return $this->sourceuri;
    }
    
    

    /**
     * Setter for itemType
     *
     * @param string $itemType Type of item
     * @return void
     */
    public function setItemType($itemType) {
        $this->itemType = $itemType;
    }
    
    

    /**
     * Getter for itemType
     *
     * @return string Type of item
     */
    public function getItemType() {
        return $this->itemType;
    }
    
    

    /**
     * Setter for width
     *
     * @param integer $width Width of item
     * @return void
     */
    public function setWidth($width) {
        $this->width = $width;
    }
    
    

    /**
     * Getter for width
     *
     * @return integer Width of item
     */
    public function getWidth() {
        return $this->width;
    }
    
    

    /**
     * Setter for height
     *
     * @param integer $height Height of item
     * @return void
     */
    public function setHeight($height) {
        $this->height = $height;
    }
    
    

    /**
     * Getter for height
     *
     * @return integer Height of item
     */
    public function getHeight() {
        return $this->height;
    }
    
    

    /**
     * Setter for filesize
     *
     * @param integer $filesize Filesize of item
     * @return void
     */
    public function setFilesize($filesize) {
        $this->filesize = $filesize;
    }
    
    

    /**
     * Getter for filesize
     *
     * @return integer Filesize of item
     */
    public function getFilesize() {
        return $this->filesize;
    }
    
    

    /**
     * Setter for feUserUid
     *
     * @param integer $feUserUid UID of fe user that owns item
     * @return void
     */
    public function setFeUserUid($feUserUid) {
        $this->feUserUid = $feUserUid;
    }
    
    

    /**
     * Getter for feUserUid
     *
     * @return integer UID of fe user that owns item
     */
    public function getFeUserUid() {
        return $this->feUserUid;
    }
    
    

    /**
     * Setter for feGroupUid
     *
     * @param integer $feGroupUid UID of fe group that owns item
     * @return void
     */
    public function setFeGroupUid($feGroupUid) {
        $this->feGroupUid = $feGroupUid;
    }
    
    

    /**
     * Getter for feGroupUid
     *
     * @return integer UID of fe group that owns item
     */
    public function getFeGroupUid() {
        return $this->feGroupUid;
    }
    
    

    /**
     * Setter for album
     *
     * @param Tx_Yag_Domain_Model_Album $album Holds album to which item belongs to
     * @return void
     */
    public function setAlbum(Tx_Yag_Domain_Model_Album $album) {
        $this->album = $album;
    }
    
    

    /**
     * Getter for album
     *
     * @return Tx_Yag_Domain_Model_Album Holds album to which item belongs to
     */
    public function getAlbum() {
        return $this->album;
    }
    
    

    /**
     * Setter for itemMeta
     *
     * @param Tx_Yag_Domain_Model_ItemMeta $itemMeta Holds meta data for item
     * @return void
     */
    public function setItemMeta(Tx_Yag_Domain_Model_ItemMeta $itemMeta) {
        $this->itemMeta = $itemMeta;
    }
    
    

    /**
     * Getter for itemMeta
     *
     * @return Tx_Yag_Domain_Model_ItemMeta Holds meta data for item
     */
    public function getItemMeta() {
        return $this->itemMeta;
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