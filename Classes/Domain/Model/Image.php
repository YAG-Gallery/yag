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
 * Image
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


class Tx_Yag_Domain_Model_Image extends Tx_Extbase_DomainObject_AbstractEntity {
	
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
	 * single image file object
	 * @var Tx_Yag_Domain_Model_ImageFile
	 */
	protected $single;
	
	/**
	 * thum image file object
     * @var Tx_Yag_Domain_Model_ImageFile
	 */
	protected $thumb;
	
	/**
	 * originale image file object
	 * @var Tx_Yag_Domain_Model_ImageFile
	 */
	protected $orig;
	
	/**
	 * Constructor. Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 */
	public function __construct() {
		
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
     * Getter for original image file object
     * 
     * @return Tx_Yag_Domain_Model_ImageFile
     */
    public function getOrig() {
        return $this->orig;
    }
    
    /**
     * Getter for single image file object
     * 
     * @return Tx_Yag_Domain_Model_ImageFile
     */
    public function getSingle() {
        return $this->single;
    }
    
    /**
     * Getter for thumb image file object
     * 
     * @return Tx_Yag_Domain_Model_ImageFile
     */
    public function getThumb() {
        return $this->thumb;
    }
    
    /**
     * Setter for original image file object
     * 
     * @param Tx_Yag_Domain_Model_ImageFile $orig
     */
    public function setOrig($orig) {
        $this->orig = $orig;
    }
    
    /**
     * @param Tx_Yag_Domain_Model_ImageFile $single
     */
    public function setSingle($single) {
        $this->single = $single;
    }
    
    /**
     * Setter for thumb image file object
     * 
     * @param Tx_Yag_Domain_Model_ImageFile $thumb
     */
    public function setThumb($thumb) {
        $this->thumb = $thumb;
	}
	
}
?>