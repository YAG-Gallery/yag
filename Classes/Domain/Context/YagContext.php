<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
*  All rights reserved
*
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
 * Class holds settings and objects for yag gallery.
 *
 * @package Domain
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Context_YagContext implements Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface {

	/**
	 * Identifier of this instance
	 * 
	 * @var string
	 */
	protected $identifier;
	
	
	/**
	 * Session Data
	 *
	 * @var array 
	 */
	protected $sessionData;
	
	
	/**
	 * Configurationbuilder
	 * 
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder;

	
	/**
	 * Holds an instance of gallery object we are currently working upon
	 *
	 * @var Tx_Yag_Domain_Model_Gallery
	 */
	protected $selectedGallery = null;
	
	
	
	/**
	 * Holds an instance of album object we are currentyl working upon
	 *
	 * @var Tx_Yag_Domain_Model_Album
	 */
	protected $selectedAlbum = null;
	
	
	
	/**
	 * Holds instance of item object we are currently working upon
	 *
	 * @var Tx_Yag_Domain_Model_Item
	 */
	protected $selectedItem = null;
	
	
	/** 
	 * @var string $identifer
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 */
	public function __construct($identifier, Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		$this->identifier = $identifier;
		$this->configurationBuilder = $configurationBuilder;
	}
	
	
	
	public function getObjectNamespace() {
		return 'context' . $this->identifier;
	}
	
	
	public function init() {
		$this->initByConfiguration();
		$this->initBySessionData();
		$this->initByGpVars();
	}
	
	
	
	public function initByConfiguration() {
		
	}
	
	
	
	public function initBySessionData() {
		
	}
	
	
	
	public function initByGpVars() {
		
	}
	
	
	public function setGalleryUid($uid) {
		
	}
	
	
	/**
	 * @param Tx_Yag_Domain_Model_Gallery $gallery
	 */
	public function setGallery(Tx_Yag_Domain_Model_Gallery $gallery) {
		$this->selectedGallery = $gallery;
	}
	
	

	/**
	 * @param Tx_Yag_Domain_Model_Album $album
	 */
	public function setAlbum(Tx_Yag_Domain_Model_Album $album) {
		$this->selectedAlbum = $album;
	}
	
	
	
	/**
	 * @return Tx_Yag_Domain_Model_Gallery
	 */
	public function getGallery() {
		return $this->selectedGallery;
	}
	
	
	
	/**
	 * @return Tx_Yag_Domain_Model_Album
	 */
	public function getAlbum() {
		return $this->selectedAlbum;
	}
	
}
?>