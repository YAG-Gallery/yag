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
 * Class implements a ResolutionItemFileRelation domain object. For each item a file is stored
 * for each resolution an item is associated with by its album. This class implements an
 * attributed association that combines an item, its resolution and the according item file for this
 * resolution.
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Domain
 * @subpackage Model
 */
class Tx_Yag_Domain_Model_ResolutionFileCache extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * item
	 * @var Tx_Yag_Domain_Model_Item
	 */
	protected $item;
	
	
	
	/**
	 * Height of cached file
	 * 
	 * @var int
	 */
	protected $height;
	
	
	
	/**
	 * Width of cached file
	 *
	 * @var int
	 */
	protected $width;
	
	
	
	/**
	 * Quality of cached file
	 *
	 * @var int
	 */
	protected $quality;
	
	
	
	/**
	 * Path to cached file
	 * 
	 * @var string
	 */
	protected $path;
	
	
	
	/**
	 * Constructor for resolution item file relation
	 *
	 * @param Tx_Yag_Domain_Model_Item $item Item for which file is cached
	 * @param string $path Path to cached file
	 * @param int $width Width of cached file
	 * @param int $height Height of cached file
	 * @param quality $quality Quality of cached file
	 */
	public function __construct(Tx_Yag_Domain_Model_Item $item = NULL, $path = '', $width = 0, $height = 0, $quality = 0) {
	    parent::__construct();
	    $this->item = $item;
	    $this->path = $path;
	    $this->height = $height;
	    $this->width = $width;
	    $this->quality = $quality;	
   }
	
	
	
	/**
	 * Setter for item
	 *
	 * @param Tx_Yag_Domain_Model_Item $item item
	 * @return void
	 */
	public function setItem(Tx_Yag_Domain_Model_Item $item) {
		$this->item = $item;
	}

	/**
	 * Getter for item
	 *
	 * @return Tx_Yag_Domain_Model_Item item
	 */
	public function getItem() {
		return $this->item;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getHeight() {
		return $this->height;
	}
	
	
	
	/**
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getQuality() {
		return $this->quality;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getWidth() {
		return $this->width;
	}
	
	
	
	/**
	 * @param int $height
	 */
	public function setHeight($height) {
		$this->height = $height;
	}
	
	
	
	/**
	 * @param string $path
	 */
	public function setPath($path) {
		$this->path = $path;
	}
	
	
	
	/**
	 * @param int $quality
	 */
	public function setQuality($quality) {
		$this->quality = $quality;
	}
	
	
	
	/**
	 * @param int $width
	 */
	public function setWidth($width) {
		$this->width = $width;
	}
	
}
?>