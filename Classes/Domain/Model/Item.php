<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
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
class Tx_Yag_Domain_Model_Item
	extends Tx_Extbase_DomainObject_AbstractEntity
	implements Tx_Yag_Domain_Model_DomainModelInterface {
	
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
	 * @var string The original filename at import time
	 */
	protected $originalFilename;


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
     * Holds md5 hash of original image
     * 
     * @var string
     */
    protected $filehash;
    
    

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
     * @lazy
     * @var Tx_Yag_Domain_Model_Album $album
     */
    protected $album;
    
    

    /**
     * Holds meta data for item
     *
     * @lazy
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
	 * tags
	 * @lazy
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Tag> $tags
	 */
	protected $tags;



	/**
	 * @var string
	 */
	protected $link;



	/**
	 * @var float
	 */
	protected $rating;



	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;



	public function __construct() {
		$this->initStorageObjects();
	}


	/**
	 * @param Tx_Extbase_Object_ObjectManager $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}
    
	
	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->tags = new Tx_Extbase_Persistence_ObjectStorage();
	}



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
	 * Setter for source uri
	 *
	 * @param string $sourceURI URI of item's source
	 * @return void
	 */
	public function setSourceuri($sourceURI) {
		$this->sourceuri = $sourceURI;
	}



	/**
	 * Getter for sourceURI
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
	 * Setter for fileSize
	 *
	 * @param integer $fileSize FileSize of item
	 * @return void
	 */
	public function setFilesize($fileSize) {
		$this->filesize = $fileSize;
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
		return Tx_PtExtbase_Div::getLazyLoadedObject($this->album);
	}



    /**
     * Setter for md5 file hash
     *
     * @param string $filehash
     */
    public function setFilehash($filehash) {
        $this->filehash = $filehash;
    }



    /**
     * Getter for md5 file hash
     * 
     * @return string
     */
    public function getFilehash(){
        return $this->filehash;
    }



	/**
	 * Setter for itemMeta
	 *
	 * @param Tx_Yag_Domain_Model_ItemMeta $itemMeta Holds meta data for item
	 * @return void
	 */
	public function setItemMeta(Tx_Yag_Domain_Model_ItemMeta $itemMeta) {
		$this->itemMeta = $itemMeta;
		$this->setDate($itemMeta->getCaptureDate());
	}



	/**
	 * Getter for itemMeta
	 *
	 * @return Tx_Yag_Domain_Model_ItemMeta Holds meta data for item
	 */
	public function getItemMeta() {
		return Tx_PtExtbase_Div::getLazyLoadedObject($this->itemMeta);
	}



	/**
	 * @param float $rating
	 */
	public function setRating($rating) {
		$this->rating = $rating;
	}



	/**
	 * @return float
	 */
	public function getRating() {
		return $this->rating;
	}



	/**
	 * Get image path by resolution config
	 *
	 * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfig
	 * @return Tx_Yag_Domain_Model_ResolutionFileCache
	 */
	public function getResolutionByConfig($resolutionConfig) {
		if ($resolutionConfig != NULL) {
			return Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance()->getItemFileResolutionPathByConfiguration($this, $resolutionConfig);
		} else {
			return $this->getOriginalResolution();
		}
	}



	/**
	 * Return an array of all resolutions of the currently active theme
	 *
	 * @return array
	 */
	public function getResolutions() {
		$resolutionConfigs = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()
									->buildThemeConfiguration()
									->getResolutionConfigCollection();

		$resolutions = array();

		foreach($resolutionConfigs as $resolutionName => $resolutionConfig) {
			$resolutions[$resolutionName] = $this->getResolutionByConfig($resolutionConfig);
		}

		return $resolutions;
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
	public function delete($deleteCachedFiles = TRUE) {
		// If we delete an item, we have to check, whether it has been the thumb of an album
		$resetThumb = FALSE;

		if ($this->getAlbum()->getThumb() !== NULL && $this->getAlbum()->getThumb()->getUid() == $this->getUid()) $resetThumb = TRUE;

		$this->objectManager->get('Tx_Yag_Domain_FileSystem_FileManager')->removeImageFileFromAlbumDirectory($this);
		if ($deleteCachedFiles) $this->deleteCachedFiles();

		if($this->getItemMeta()) {
			$itemMetaRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemMetaRepository'); /* @var $itemMetaRepository Tx_Yag_Domain_Repository_ItemMetaRepository */
			$itemMetaRepository->remove($this->getItemMeta());
		}
		
		$this->album->removeItem($this);

		if ($resetThumb) {
		    $this->album->setThumbToTopOfItems();
		}

		$this->objectManager->get('Tx_Yag_Domain_Repository_AlbumRepository')->update($this->album);

		$itemRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository'); /* @var $itemRepository Tx_Yag_Domain_Repository_ItemRepository */
		$itemRepository->remove($this);
	}
	
	
	
	/**
	 * Deletes cached files for item
	 */
	public function deleteCachedFiles() {
		$resolutionFileCacheRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ResolutionFileCacheRepository'); /* @var $resolutionFileCacheRepository Tx_Yag_Domain_Repository_ResolutionFileCacheRepository */
		$resolutionFileCacheRepository->removeByItem($this);
	}
	
	
	
	/**
	 * Set this item as album thumb, if no thumbnail for album is existing
	 *
	 */
	public function setItemAsAlbumThumbIfNotExisting() {
		if ($this->album->getThumb() == NULL) {
			$this->album->setThumb($this);
		}
	}
	
	
	
	/**
	 * Returns TRUE if item is thumb of associated album, 0 else
	 *
	 * @return boolean TRUE if item is thumb of associated album
	 */
	public function getIsAlbumThumb() {
		if($this->getAlbum() instanceof Tx_Yag_Domain_Model_Album
			&& $this->getAlbum()->getThumb() instanceof Tx_Yag_Domain_Model_Item
			&& $this->getAlbum()->getThumb()->getUid() === $this->uid) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	
	
	/**
	 * Returns 1 if image is landscape, else returns 0
	 *
	 * @return int
	 */
	public function getIsLandscape() {
		if ($this->width > $this->height) {
			return 1;
		} else {
			return 0;
		}
	}
	


	/**
	 * @param $tagsAsCSV
	 */
	public function setTagsFromCSV($tagsAsCSV) {
		$this->tags = new Tx_Extbase_Persistence_ObjectStorage();
		$this->addTagsFromCSV($tagsAsCSV);
	}

	
	
	/**
	 * Add a list of tags separated by comma
	 * 
	 * @param string $tagsAsCSV
	 */
	public function addTagsFromCSV($tagsAsCSV) {
		$tags = array_filter(t3lib_div::trimExplode(',',$tagsAsCSV));

		foreach($tags as $tagName) {
			
			$tag = new Tx_Yag_Domain_Model_Tag();
			
			$tag->setName($tagName);
			
			$this->addTag($tag);
		}
	}
	
	
	
	/**
	 * Build a csv string of all tags
	 *
	 * @param  string $separator
	 * @return string
	 */
	public function getTagsSeparated($separator = ', ') {
		$tagNames = array();

		foreach($this->tags as $tag) {
			$tagNames[] = $tag->getName();
		}

		return implode($separator, $tagNames);
	}

	
	
	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Tag>
	 */
	public function getTags() {
		return $this->tags;
	}



	/**
	 * @param $tags
	 * @return void
	 */
	public function setTags($tags) {
		$this->tags = $tags;
	}

	
	
	/**
	 * Add Tag if it is not already existing and update counter
	 * 
	 * @param Tx_Yag_Domain_Model_Tag the Tag to be added
	 * @return void
	 */
	public function addTag(Tx_Yag_Domain_Model_Tag $tag) {
		
		$tagRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_TagRepository');
		$existingTag = $tagRepository->findOneByName($tag->getName()); /** @var Tx_Yag_Domain_Model_Tag $existingTag */
		
		if($existingTag === NULL || $tag === $existingTag) {
			$tag->setCount(1);
			$this->tags->attach($tag);	
		} else {
			$existingTag->increaseCount();
			$this->tags->attach($existingTag);
		}
		
	}

	
	
	/**
	 * @param Tx_Yag_Domain_Model_Tag the Tag to be removed
	 * @return void
	 */
	public function removeTag(Tx_Yag_Domain_Model_Tag $tagToRemove) {
		
		$tagRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_TagRepository');
		$existingTag = $tagRepository->findOneByName($tagToRemove->getName()); /** @var Tx_Yag_Domain_Model_Tag $existingTag */

		if($existingTag instanceof Tx_Yag_Domain_Model_Tag) {
			$existingTag->decreaseCount();
		}

		$this->tags->detach($tagToRemove);
	}



	/**
	 * Returns true, if this image is owned by current fe_user
	 *
	 * @return bool
	 */
	public function getIsMine() {
		if (TYPO3_MODE == 'FE' && !empty($GLOBALS['TSFE']->fe_user->user['uid'])) {
			$isMine = ($GLOBALS['TSFE']->fe_user->user['uid'] == $this->feUserUid);
			return $isMine;
		}
	}



	/**
	 * @param string $link
	 */
	public function setLink($link) {
		$this->link = $link;
	}



	/**
	 * @return string
	 */
	public function getLink() {
		return $this->link;
	}



	/**
	 * @param string $originalFilename
	 */
	public function setOriginalFilename($originalFilename) {
		$this->originalFilename = $originalFilename;
	}



	/**
	 * @return string
	 */
	public function getOriginalFilename() {
		return $this->originalFilename;
	}

}
?>