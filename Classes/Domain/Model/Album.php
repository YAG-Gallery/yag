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
 * Album
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
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
	 * resolutions
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Resolution>
	 */
	protected $resolutions;
	
	/**
	 * resolutionPresets
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_ResolutionPreset>
	 */
	protected $resolutionPresets;
	
	/**
	 * items
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Item>
	 */
	protected $items;
	
	/**
	 * galleries
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Gallery>
	 */
	protected $galleries;
	
	/**
	 * Constructor. Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 */
	public function __construct() {
		$this->resolutions = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->items = new Tx_Extbase_Persistence_ObjectStorage();
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
	 * Setter for resolutions
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Resolution> $resolutions resolutions
	 * @return void
	 */
	public function setResolutions(Tx_Extbase_Persistence_ObjectStorage $resolutions) {
		$this->resolutions = $resolutions;
	}

	/**
	 * Getter for resolutions
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Resolution> resolutions
	 */
	public function getResolutions() {
		return $this->resolutions;
	}
	
	/**
	 * Adds a Resolution
	 *
	 * @param Tx_Yag_Domain_Model_Resolution The Resolution to be added
	 * @return void
	 */
	public function addResolution(Tx_Yag_Domain_Model_Resolution $resolution) {
		$this->resolutions->attach($resolution);
	}
	
	/**
	 * Removes a Resolution
	 *
	 * @param Tx_Yag_Domain_Model_Resolution The Resolution to be removed
	 * @return void
	 */
	public function removeResolution(Tx_Yag_Domain_Model_Resolution $resolution) {
		$this->resolutions->detach($resolution);
	}
	
	/**
	 * Setter for resolutionPresets
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_ResolutionPreset> $resolutionPresets resolutionPresets
	 * @return void
	 */
	public function setResolutionPresets(Tx_Extbase_Persistence_ObjectStorage $resolutionPresets) {
		$this->resolutionPresets = $resolutionPresets;
	}

	/**
	 * Getter for resolutionPresets
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_ResolutionPreset> resolutionPresets
	 */
	public function getResolutionPresets() {
		return $this->resolutionPresets;
	}
	
	/**
	 * Adds a ResolutionPreset
	 *
	 * @param Tx_Yag_Domain_Model_ResolutionPreset The ResolutionPreset to be added
	 * @return void
	 */
	public function addResolutionPreset(Tx_Yag_Domain_Model_ResolutionPreset $resolutionPreset) {
		$this->resolutionPresets->attach($resolutionPreset);
	}
	
	/**
	 * Removes a ResolutionPreset
	 *
	 * @param Tx_Yag_Domain_Model_ResolutionPreset The ResolutionPreset to be removed
	 * @return void
	 */
	public function removeResolutionPreset(Tx_Yag_Domain_Model_ResolutionPreset $resolutionPreset) {
		$this->resolutionPresets->detach($resolutionPreset);
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
	
}
?>