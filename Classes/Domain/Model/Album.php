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
 * Class implements Album domain object
 *
 * @package Domain
 * @subpackage Model
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Model_Album
	extends Tx_Extbase_DomainObject_AbstractEntity
	implements Tx_Yag_Domain_Model_DomainModelInterface {
	
	/**
     * Name for album
     *
     * @var string $name
     */
    protected $name;
    
    

    /**
     * Description for album
     *
     * @var string $description
     */
    protected $description;
    
    

    /**
     * Date for album
     *
     * @var DateTime $date
     */
    protected $date;
    
    

    /**
     * UID of fe user that owns album
     *
     * @var integer $feUserUid
     */
    protected $feUserUid;
    
    

    /**
     * UID of fe group that owns album
     *
     * @var integer $feGroupUid
     */
    protected $feGroupUid;
    
    

    /**
     * Holds gallery in which this album is kept
     * 
     * @lazy
     * @var Tx_Yag_Domain_Model_Gallery $gallery
     */
    protected $gallery;
    
    

    /**
     * Holds thumbnail for this album
     * 
     * @lazy
     * @var Tx_Yag_Domain_Model_Item $thumb
     */
    protected $thumb;
    
    

    /**
     * Holds items of this album
     * 
     * @lazy
     * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Item> $items
     */
    protected $items;
    
    
    
    /**
     * If set to 1, album will be hidden in frontend
     * 
     * ATTENTION We do not use T3's hidden field here, 
     * as this leeds to problems with everything.
     *
     * @var int
     */
    protected $hide;
    
    
    
    /**
     * Sorting of album in gallery
     *
     * @var int
     */
    protected $sorting;



	/**
	 * @var Tx_Yag_Domain_FileSystem_FileManager
	 */
	protected $fileManager;



	/**
	 * @var float
	 */
	protected $rating;



	/**
	 * Injector for file manager
	 *
	 * @param Tx_Yag_Domain_FileSystem_FileManager $fileManager
	 */
	public function injectFileManager(Tx_Yag_Domain_FileSystem_FileManager $fileManager) {
		$this->fileManager = $fileManager;
	}



	public function __construct() {
        $this->initStorageObjects();
		$this->date = new \DateTime();
    }

    
    /**
     * Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
     *
     * @return void
     */
    protected function initStorageObjects() {
        $this->items = new Tx_Extbase_Persistence_ObjectStorage();
    }
    
    

    /**
     * Setter for name
     *
     * @param string $name Name for album
     * @return void
     */
    public function setName($name) {
        $this->name = $name;
    }
    
    

    /**
     * Getter for name
     *
     * @return string Name for album
     */
    public function getName() {
        return $this->name;
    }
    
    
    
    /**
     * Setter for sorting
     *
     * @param int $sorting
     */
    public function setSorting($sorting) {
    	$this->sorting = $sorting;
    }
    
    
    
    /**
     * Getter for sorting
     *
     * @return int
     */
    public function getSorting() {
    	return $this->sorting;
    }
    
    

    /**
     * Setter for description
     *
     * @param string $description Description for album
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }
    
    

    /**
     * Getter for description
     *
     * @return string Description for album
     */
    public function getDescription() {
        return $this->description;
    }
    
    

    /**
     * Setter for date
     *
     * @param DateTime $date Date for album
     * @return void
     */
    public function setDate(DateTime $date) {
        $this->date = $date;
    }
    
    

    /**
     * Getter for date
     *
     * @return DateTime Date for album
     */
    public function getDate() {
        return $this->date;
    }
    
    

    /**
     * Setter for feUserUid
     *
     * @param integer $feUserUid UID of fe user that owns album
     * @return void
     */
    public function setFeUserUid($feUserUid) {
        $this->feUserUid = $feUserUid;
    }
    
    

    /**
     * Getter for feUserUid
     *
     * @return integer UID of fe user that owns album
     */
    public function getFeUserUid() {
        return $this->feUserUid;
    }
    
    

    /**
     * Setter for feGroupUid
     *
     * @param integer $feGroupUid UID of fe group that owns album
     * @return void
     */
    public function setFeGroupUid($feGroupUid) {
        $this->feGroupUid = $feGroupUid;
    }
    
    

    /**
     * Getter for feGroupUid
     *
     * @return integer UID of fe group that owns album
     */
    public function getFeGroupUid() {
        return $this->feGroupUid;
    }

    
    
    /**
     * Setter for gallery
     *
     * @param Tx_Yag_Domain_Model_Gallery $gallery Holds gallery in which this album is kept
     * @return void
     */
    public function setGallery(Tx_Yag_Domain_Model_Gallery $gallery) {
        $this->gallery = $gallery;
    }

    
    
    /**
     * Getter for gallery
     *
     * @return Tx_Yag_Domain_Model_Gallery Holds gallery in which this album is kept
     */
    public function getGallery() {
		return Tx_PtExtbase_Div::getLazyLoadedObject($this->gallery);
    }
    
    

    /**
     * Setter for thumb
     *
     * @param Tx_Yag_Domain_Model_Item $thumb Holds thumbnail for this album
     * @return void
     */
    public function setThumb(Tx_Yag_Domain_Model_Item $thumb) {
        $this->thumb = $thumb;
    }


	/**
	 * Getter for thumb
	 *
	 * @return Tx_Yag_Domain_Model_Item Holds thumbnail for this album
	 */
	public function getThumb() {
		return Tx_PtExtbase_Div::getLazyLoadedObject($this->thumb);
	}
    
    

    /**
     * Setter for items
     *
     * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Item> $items Holds items of this album
     * @return void
     */
    public function setItems(Tx_Extbase_Persistence_ObjectStorage $items) {
        $this->items = $items;
    }
    
    

    /**
     * Getter for items
     *
     * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Item> Holds items of this album
     */
    public function getItems() {
        return $this->items;
    }
    
    

    /**
     * Adds a Item
     *
     * @param Tx_Yag_Domain_Model_Item the Item to be added
     * @return void
     */
    public function addItem(Tx_Yag_Domain_Model_Item $item) {
        $this->items->attach($item);
    }
    
    

    /**
     * Removes a Item
     *
     * @param Tx_Yag_Domain_Model_Item the Item to be removed
     * @return void
     */
    public function removeItem(Tx_Yag_Domain_Model_Item $itemToRemove) {
        $this->items->detach($itemToRemove);
    }
    
    
    
    /**
     * Setter for hidden property. If set to 1, album won't be displayed in frontend
     *
     * @param int $hide
     */
    public function setHide($hide) {
    	$this->hide = $hide;
    }
    
    
    
    /**
     * Getter for hidden property. If set to 1, album won't be displayed in frontend.
     *
     * @return int
     */
    public function getHide() {
    	return $this->hide;
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
    


    
    /***********************************************************************
     * Here are our methods
     ***********************************************************************/
	
    /**
     * Returns item count of album
     *
     * @return int 
     */
    public function getItemCount() {
    	return $this->items->count();
    }
	
    
	
	/**
	 * Deletes album and removes all associated items if parameter set to true
	 * 
	 * @param bool $deleteItems If set to true, all items of album are removed, too
	 */
	public function delete($deleteItems = TRUE) {

		if ($deleteItems) {
			$this->deleteAllItems();
		}

		$this->deleteThumb();

		$this->gallery->setThumbAlbumToTopOfAlbums();
		$albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
		$albumRepository->remove($this);

		$this->fileManager->removeAlbumDirectory($this);
	}



	/**
	 * @return void
	 */
	public function deleteThumb() {
		if($this->thumb && is_object($this->thumb)) {
			$this->thumb->delete();
			$this->thumb = NULL;
		}
	}



	/**
	 * @return void
	 */
	public function deleteAllItems() {
		foreach ($this->items as $item) { /* @var $item Tx_Yag_Domain_Model_Item */
			$item->delete();
		}
	}


	
	/**
	 * Sets thumbnail to first item of items in this album
	 */
	public function setThumbToTopOfItems() {
		if (count($this->items) > 0) {
		    $this->thumb = $this->items->current();
		}
	}
	
	
	
	/**
	 * Returns TRUE if album is album thumb for gallery associated with this album
	 * 
	 * @return boolean TRUE if album is gallery thumb, FALSE else
	 */
	public function getIsGalleryThumb() {
    	$gallery = $this->getGallery();

		if($gallery instanceof Tx_Yag_Domain_Model_Gallery
			&& ($gallery->getThumbAlbum() instanceof Tx_Yag_Domain_Model_Album)
			&& $gallery->getThumbAlbum()->getUid() == $this->getUid()
		) {
		    return TRUE;
        } else {
        	return FALSE;
        }
	}



    /**
     * Updates sorting of items of this album.
     *
     * Sorting of items of this album is updated by given sorting field
     * and sorting direction. Sorting field must be one field of item,
     * sorting direction must be 1 = ASC or -1 = DESC.
     *
     * @param string $sortingField Field of item to be used for sorting
     * @param string $sortingDirection Sorting direction to be used for sorting.
     * @return void
     */
    public function updateSorting($sortingField, $sortingDirection) {
        $itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository'); /* @var Tx_Yag_Domain_Repository_ItemRepository $itemRepository  */
        $sortedItems = $itemRepository->getSortedItemsByAlbumFieldAndDirection($this, $sortingField, $sortingDirection);
        $this->items = new Tx_Extbase_Persistence_ObjectStorage();
        foreach($sortedItems as $item) {
            $this->items->attach($item);
        }
    }



    /**
     * Returns maximum sorting of items within this album
     * 
     * @return int
     */
    public function getMaxSorting() {
        $itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository'); /* @var $itemRepository Tx_Yag_Domain_Repository_ItemRepository */
        $maxSortingItem = $itemRepository->getItemWithMaxSortingForAlbum($this);
        if (count($maxSortingItem) > 0) {
            return $maxSortingItem[0]->getSorting();
        } else {
            return 0;
        }
    }



    /**
     * Checks, whether an image for a given filehash is included in album
     *
     * @param string $fileHash MD5 hash of item to be checked to be in this album
     * @return bool True, if image is included
     */
    public function containsItemByHash($fileHash) {
        foreach($this->items as $item) { /* @var $item Tx_Yag_Domain_Model_Item */
            if ($item->getFilehash() == $fileHash) {
                return TRUE;
            }
        }
        return FALSE;
    }

}
?>