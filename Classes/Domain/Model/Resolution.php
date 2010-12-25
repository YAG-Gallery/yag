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
 * Class implements a Resolution domain object
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Domain
 * @subpackage Model
 */
class Tx_Yag_Domain_Model_Resolution extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * width
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $width;
	
	
	
	/**
	 * height
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $height;
	
	
	
	/**
	 * name
	 * @var string
	 */
	protected $name;
	
	
	
	/**
	 * resolutionPreset
	 * @var Tx_Yag_Domain_Model_ResolutionPreset
	 */
	protected $resolutionPreset;
	
	
	
	/**
	 * Constructor for resolution.
	 *
	 * @param Width of resolution $width
	 * @param Height of resolution $height
	 * @param Name of resolution $name
	 * @param Resolution preset to add resolution to Tx_Yag_Domain_Model_ResolutionPreset $resolutionPreset
	 */
	public function __construct($width = null, $height = null, $name = null, Tx_Yag_Domain_Model_ResolutionPreset $resolutionPreset = null) {
		parent::__construct(); 
		$this->height = $height;
		$this->width = $width;
		$this->name = $name;
		$this->resolutionPreset = $resolutionPreset;
	}
	
	
	
	/**
	 * Setter for width
	 *
	 * @param integer $width width
	 * @return void
	 */
	public function setWidth($width) {
		$this->width = $width;
	}
	
	

	/**
	 * Getter for width
	 *
	 * @return integer width
	 */
	public function getWidth() {
		return $this->width;
	}
	
	
	
	/**
	 * Setter for height
	 *
	 * @param integer $height height
	 * @return void
	 */
	public function setHeight($height) {
		$this->height = $height;
	}
	
	

	/**
	 * Getter for height
	 *
	 * @return integer height
	 */
	public function getHeight() {
		return $this->height;
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
	 * Setter for resolutionPreset
	 *
	 * @param Tx_Yag_Domain_Model_ResolutionPreset $resolutionPreset resolutionPreset
	 * @return void
	 */
	public function setResolutionPreset(Tx_Yag_Domain_Model_ResolutionPreset $resolutionPreset) {
		$this->resolutionPreset = $resolutionPreset;
	}
	
	

	/**
	 * Getter for resolutionPreset
	 *
	 * @return Tx_Yag_Domain_Model_ResolutionPreset resolutionPreset
	 */
	public function getResolutionPreset() {
		return $this->resolutionPreset;
	}
	
}
?>