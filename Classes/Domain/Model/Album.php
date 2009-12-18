<?php

/***************************************************************
*  Copyright notice
*
*  (c) "now" could not be parsed by DateTime constructor. Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
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
 * Album containing multiple images
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


/**
 * Class implementing an album for yag gallery extension
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Domain_Model_Album extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * title
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;
	
	/**
	 * description
	 * @var string
	 */
	protected $description;
	
	/**
	 * date
	 * @var integer
	 */
	protected $date;
	
	/**
	 * images belonging to this album
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Image>
	 */
	protected $images;
	
	/**
	 * cover image file object
	 * @var Tx_Yag_Domain_Model_Image
	 */
	protected $cover;
	
	
	/**
	 * Constructor. Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 */
	public function __construct() {
		$this->images = new Tx_Extbase_Persistence_ObjectStorage();
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
	 * Setter for title
	 *
	 * @param string $title title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
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
	 * Setter for description
	 *
	 * @param string $description description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * Getter for date
	 *
	 * @return integer date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Setter for date
	 *
	 * @param integer $date date
	 * @return void
	 */
	public function setDate($date) {
		$this->date = $date;
	}
	
	/**
	 * Getter for images
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Image> images
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * Setter for images
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Image> $images images
	 * @return void
	 */
	public function setImages(Tx_Extbase_Persistence_ObjectStorage $images) {
		$this->images = $images;
	}
	
    /**
     * Getter for cover image file object
     * 
     * @return Tx_Yag_Domain_Model_Image
     */
    public function getCover() {
        return $this->cover;
    }
    
    /**
     * Setter for cover image file object
     * 
     * @param Tx_Yag_Domain_Model_Image $cover
     */
    public function setCover($cover) {
        $this->cover = $cover;
    }
	
}
?>