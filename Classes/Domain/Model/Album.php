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
 * Class implements Album domain object
 *
 * @package Domain
 * @subpackage Model
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Model_Album extends Tx_Extbase_DomainObject_AbstractEntity {
	
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
     * Holds galleries in which this album is kept
     *
     * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Gallery> $galleries
     */
    protected $galleries;
    
    

    /**
     * Holds thumbnail for this album
     *
     * @var Tx_Yag_Domain_Model_Item $thumb
     */
    protected $thumb;
    
    

    /**
     * Holds items of this album
     *
     * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Item> $items
     */
    protected $items;
    
    

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
        /**
        * Do not modify this method!
        * It will be rewritten on each save in the kickstarter
        * You may modify the constructor of this class instead
        */
        $this->galleries = new Tx_Extbase_Persistence_ObjectStorage();
        
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
     * Setter for galleries
     *
     * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Gallery> $galleries Holds galleries in which this album is kept
     * @return void
     */
    public function setGalleries(Tx_Extbase_Persistence_ObjectStorage $galleries) {
        $this->galleries = $galleries;
    }

    
    
    /**
     * Getter for galleries
     *
     * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Gallery> Holds galleries in which this album is kept
     */
    public function getGalleries() {
        return $this->galleries;
    }
    
    

    /**
     * Adds a Gallery
     *
     * @param Tx_Yag_Domain_Model_Gallery the Gallery to be added
     * @return void
     */
    public function addGallery(Tx_Yag_Domain_Model_Gallery $gallery) {
        $this->galleries->attach($gallery);
    }
    
    

    /**
     * Removes a Gallery
     *
     * @param Tx_Yag_Domain_Model_Gallery the Gallery to be removed
     * @return void
     */
    public function removeGallery(Tx_Yag_Domain_Model_Gallery $galleryToRemove) {
        $this->galleries->detach($galleryToRemove);
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
        return $this->thumb;
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
	 * Deletes album and removes all associated items if parameter set to true
	 * 
	 * @param bool $deleteItems If set to true, all items of album are removed, too
	 */
	public function delete($deleteItems = true) {
		if ($deleteItems) {
			foreach ($this->items as $item) { /* @var $item Tx_Yag_Domain_Model_Item */
				$item->delete();
			}
		}
		foreach ($this->galleries as $gallery) {
			$gallery->removeAlbum($this);
			$this->removeGallery($gallery);
		}
		$albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
		$albumRepository->remove($this);
	}
	
	
	
	/**
	 * Sets thumbnail to current top item of items array associated with this album
	 */
	public function setThumbToTopOfItems() {
		$this->thumb = $this->items->current();
	}
}
?>