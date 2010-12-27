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
	 * itemSource
	 * @var Tx_Yag_Domain_Model_ItemSource
	 */
	protected $itemSource;
	
	/**
	 * itemType
	 * @var Tx_Yag_Domain_Model_ItemType
	 */
	protected $itemType;
	
	/**
	 * itemFiles
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_ResolutionItemFileRelation>
	 */
	protected $itemFiles;
    
    /**
     * itemMeta
     * @var Tx_Yag_Domain_Model_ItemMeta
     */
    protected $itemMeta;
	
	/**
	 * Constructor. Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 */
	public function __construct() {
		$this->itemFiles = new Tx_Extbase_Persistence_ObjectStorage();
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
	 * Setter for itemSource
	 *
	 * @param Tx_Yag_Domain_Model_ItemSource $itemSource itemSource
	 * @return void
	 */
	public function setItemSource(Tx_Yag_Domain_Model_ItemSource $itemSource) {
		$this->itemSource = $itemSource;
	}

	/**
	 * Getter for itemSource
	 *
	 * @return Tx_Yag_Domain_Model_ItemSource itemSource
	 */
	public function getItemSource() {
		return $this->itemSource;
	}
	
	/**
	 * Setter for itemType
	 *
	 * @param Tx_Yag_Domain_Model_ItemType $itemType itemType
	 * @return void
	 */
	public function setItemType(Tx_Yag_Domain_Model_ItemType $itemType) {
		$this->itemType = $itemType;
	}

	/**
	 * Getter for itemType
	 *
	 * @return Tx_Yag_Domain_Model_ItemType itemType
	 */
	public function getItemType() {
		return $this->itemType;
	}
	
	/**
	 * Setter for itemFiles
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_ResolutionItemFileRelation> $itemFiles itemFiles
	 * @return void
	 */
	public function setItemFiles(Tx_Extbase_Persistence_ObjectStorage $itemFiles) {
		$this->itemFiles = $itemFiles;
	}

	/**
	 * Getter for itemFiles
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_ResolutionItemFileRelation> itemFiles
	 */
	public function getItemFiles() {
		return $this->itemFiles;
	}
	
	/**
	 * Adds a ResolutionItemFileRelation
	 *
	 * @param Tx_Yag_Domain_Model_ResolutionItemFileRelation The ResolutionItemFileRelation to be added
	 * @return void
	 */
	public function addItemFile(Tx_Yag_Domain_Model_ResolutionItemFileRelation $itemFile) {
		$this->itemFiles->attach($itemFile);
	}
	
	/**
	 * Removes a ResolutionItemFileRelation
	 *
	 * @param Tx_Yag_Domain_Model_ResolutionItemFileRelation The ResolutionItemFileRelation to be removed
	 * @return void
	 */
	public function removeItemFile(Tx_Yag_Domain_Model_ResolutionItemFileRelation $itemFile) {
		$this->itemFiles->detach($itemFile);
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
     * Getter for itemMeta
     *
     * @return Tx_Yag_Domain_Model_ItemMeta itemMeta
     */
    public function getItemMeta() {
        return $this->itemMeta;
    }
	
}
?>