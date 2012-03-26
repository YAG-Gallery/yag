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
class Tx_Yag_Domain_Model_Album extends Tx_Extbase_DomainObject_AbstractEntity implements Countable, Iterator, ArrayAccess {
	
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
     * The constructor.
     *
     * @return void
     */
    public function __construct() {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
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
		if (get_class($this->gallery) === 'Tx_Extbase_Persistence_LazyLoadingProxy') {
			return $this->gallery->_loadRealInstance();
		} else {
			return $this->gallery;
		}
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
		// we need this because we check the class name in itemViewHelper
		if (get_class($this->thumb) === 'Tx_Extbase_Persistence_LazyLoadingProxy') {
			return $this->thumb->_loadRealInstance();
		} else {
			return $this->thumb;
		}
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



	/*********************************************************************************************************
	 * Methods implementing Countable, Iterator, ArrayAccess Interfaces
	 *********************************************************************************************************/

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 */
	public function current() {
		return $this->items->current();
	}



	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next() {
		$this->items->next();
	}



	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return scalar scalar on success, integer
	 * 0 on failure.
	 */
	public function key() {
		return $this->items->key();
	}



	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid() {
		return $this->items->valid();
	}



	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind() {
		$this->items->rewind();
	}



	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean Returns true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 */
	public function offsetExists($offset) {
		return $this->items->offsetExists($offset);
	}



	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 */
	public function offsetGet($offset) {
		return $this->items->offsetGet($offset);
	}



	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 */
	public function offsetSet($offset, $value) {
		$this->items->offsetSet($offset, $value);
	}



	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 */
	public function offsetUnset($offset) {
		$this->items->offsetUnset($offset);
	}



	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Count elements of an object
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 */
	public function count() {
		return $this->items->count();
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
	}



	/**
	 * @return void
	 */
	public function deleteThumb() {
		if($this->thumb && is_object($this->thumb)) {
			$this->thumb->delete();
			$this->thumb = null;
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
	 * Returns 1 if album is album thumb for gallery associated with this album
	 * 
	 * TODO we have to change this, whenever we want to use gallery:album n:m relation
	 *
	 * @return int 1 if album is gallery thumb, 0 else
	 */
	public function getIsGalleryThumb() {
        if (!is_null($this->gallery->getThumbAlbum()) && $this->gallery->getThumbAlbum()->getUid() == $this->getUid()) {
		    return 1;
        } else {
        	return 0;
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
        $itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository'); /* @var $itemRepository Tx_Yag_Domain_Repository_ItemRepository */
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
        return false;
    }

}
?>