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
	 * name
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;
	
	
	
	/**
	 * description
	 * @var string
	 */
	protected $description;
	
	

    /**
	 * items
	 * 
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Item>
	 */
	protected $items;
	
	
	
	/**
	 * galleries
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Gallery>
	 */
	protected $galleries;
	
	
	
	/**
	 * Thumbnail for this album
	 * 
	 * @var Tx_Yag_Domain_Model_Item
	 */
	protected $thumb;
	
	
	
	/**
	 * Constructor. Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 */
	public function __construct() {
		$this->items = new Tx_Extbase_Persistence_ObjectStorage();
		$this->galleries = new Tx_Extbase_Persistence_ObjectStorage();
	}
	
	
	
	/**
	 * Setter for name
	 *
	 * @param string $name name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	
	
	/**
	 * Getter for name
	 *
	 * @return string name
	 */
	public function getName() {
		return $this->name;
	}
	
	
	
	/**
	 * 
	 * @return string
	 */
	public function getTitle() {
		return $this->name;
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
	 * Setter for items
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Item> $items items
	 * @return void
	 */
	public function setItems(Tx_Extbase_Persistence_ObjectStorage $items) {
		$this->items = $items;
	}

	
	
	/**
	 * Getter for items
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Item> items
	 */
	public function getItems() {
		return $this->items;
	}
	
	
	
	/**
	 * Return the defined album thumb
	 * 
	 * @return Tx_Yag_Domain_Model_Item 
	 */
	public function getThumb() {
		return $this->thumb;
	}
	
	
	
	/**
	 * Sets thumb for this album
	 *
	 * @param Tx_Yag_Domain_Model_Item $thumb Item to be set as thumb for album
	 */
	public function setThumb(Tx_Yag_Domain_Model_Item $thumb) {
		$this->thumb = $thumb;
	}
	
	

	/**
	 * @return int items count
	 */
	public function getItemCount() {
		return $this->items->count();
	}
	
	
	
	/**
	 * Adds a Item
	 *
	 * @param Tx_Yag_Domain_Model_Item The Item to be added
	 * @return void
	 */
	public function addItem(Tx_Yag_Domain_Model_Item $item) {
		$this->items->attach($item);
	}
	
	
	
	/**
	 * Removes a Item
	 *
	 * @param Tx_Yag_Domain_Model_Item The Item to be removed
	 * @return void
	 */
	public function removeItem(Tx_Yag_Domain_Model_Item $item) {
		$this->items->detach($item);
	}
	
	
	
	/**
	 * Setter for galleries
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Gallery> $galleries galleries
	 * @return void
	 */
	public function setGalleries(Tx_Extbase_Persistence_ObjectStorage $galleries) {
		$this->galleries = $galleries;
	}

	
	
	/**
	 * Getter for galleries
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Gallery> galleries
	 */
	public function getGalleries() {
		return $this->galleries;
	}
	
	
	
	/**
	 * Adds a Gallery
	 *
	 * @param Tx_Yag_Domain_Model_Gallery The Gallery to be added
	 * @return void
	 */
	public function addGallery(Tx_Yag_Domain_Model_Gallery $gallery) {
		$this->galleries->attach($gallery);
	}
	
	
	
	/**
	 * Removes a Gallery
	 *
	 * @param Tx_Yag_Domain_Model_Gallery The Gallery to be removed
	 * @return void
	 */
	public function removeGallery(Tx_Yag_Domain_Model_Gallery $gallery) {
		$this->galleries->detach($gallery);
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
}
?>