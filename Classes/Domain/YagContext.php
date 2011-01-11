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
 */
class Tx_Yag_Domain_YagContext implements Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface {

	/**
	 * Holds constant for gallery UID field in session data
	 */
	const GALLERY_UID = 'galleryUid';
	
	
	
	/**
	 * Holds constant for album UID field in session data
	 */
	const ALBUM_UID = 'albumUid';
	
	

	/**
	 * Holds constant for item UID field in session data
	 */
	const ITEM_UID = 'itemUid';
	
	
	
	/**
	 * Holds a singleton instance of this class
	 *
	 * @var Tx_Yag_Domain_YagContext
	 */
	private static $instance = null;
	
	
	
	/**
	 * Holds an array of session data
	 *
	 * @var array
	 */
	protected $sessionData;
	
	
	
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
	 * @var Tx_Yag_Domain_Model_Album
	 */
	protected $selectedItem = null;
	
	
	
	/**
	 * Returns a singleton instance of this class
	 *
	 * @return Tx_Yag_Domain_YagContext Singleton instance of Tx_Yag_Domain_YagContext
	 */
	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new Tx_Yag_Domain_YagContext();
		}
		return self::$instance;
	}
	
	
	
	/**
	 * Returns namespace for this object used to identify its data in session
	 *
	 * @return String Namespace of this object
	 */
	public function getObjectNamespace() {
		// TODO think about better namespace, if more than one gallery instance is used per page
		return 'tx_yag';
	}
	
	
	
	/**
	 * @see Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface::injectSessionData()
	 *
	 * @param array $sessionData
	 */
	public function injectSessionData(array $sessionData) {
		$this->sessionData = $sessionData;
	}
	
	
	
	/**
	 * @see Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface::persistToSession()
	 *
	 */
	public function persistToSession() {
		$sessionData = array();
		$sessionData[self::GALLERY_UID] = $this->selectedGallery->getUid();
		$sessionData[self::ALBUM_UID] = $this->selectedAlbum->getUid();
		$sessionData[self::ITEM_UID] = $this->selectedItem->getUid();
		return $sessionData;
	}
	
	
	
	/**
	 * Initializes context by session data
	 *
	 */
	protected function initBySessionData() {
		if (array_key_exists(self::GALLERY_UID, $this->sessionData)) {
			$this->selectedGallery = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository')
			    ->findByUid($this->sessionData[self::GALLERY_UID]);
		}
		if (array_key_exists(self::ALBUM_UID, $this->sessionData)) {
		    $this->selectedAlbum = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository')
		        ->findByUid($this->sessionData[self::ALBUM_UID]);
		}
		if (array_key_exists(self::ITEM_UID, $this->sessionData)) {
			$this->selectedItem = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository')
			    ->findByUid($this->sessionData[self::ITEM_UID]);
		}
	}
	
	
	
	/**
	 * Setter for selected album
	 *
	 * @param Tx_Yag_Domain_Model_Album $selectedAlbum
	 */
	public function setSelectedAlbum(Tx_Yag_Domain_Model_Album $selectedAlbum) {
		$this->selectedAlbum = $selectedAlbum;
	}
	
	
	
	/**
	 * Setter for selected gallery
	 *
	 * @param Tx_Yag_Domain_Model_Gallery $selectedGallery
	 */
	public function setSelectedGallery(Tx_Yag_Domain_Model_Gallery $selectedGallery) {
		$this->selectedGallery = $selectedGallery;
	}
	
	
	
	/**
	 * Setter for selected item
	 *
	 * @param Tx_Yag_Domain_Model_Item $selectedItem
	 */
	public function setSelectedItem(Tx_Yag_Domain_Model_Item $selectedItem) {
		$this->selectedItem = $selectedItem;
	}
	
	
	
	/**
	 * Getter for selected album
	 *
	 * @return Tx_Yag_Domain_Model_Album
	 */
	public function getSelectedAlbum() {
		return $this->selectedAlbum;
	}
	
	
	
	/**
	 * Getter for selected gallery
	 *
	 * @return Tx_Yag_Domain_Model_Gallery
	 */
	public function getSelectedGallery() {
		return $this->selectedGallery;
	}
	
	
	
	/**
	 * Getter for selected item
	 *
	 * @return Tx_Yag_Domain_Model_Item
	 */
	public function getSelectedItem() {
		return $this->selectedItem;
	}
	
	
	
	/**
	 * Resets selected album
	 */
	public function resetSelectedAlbum() {
		$this->selectedAlbum = null;
	}
	
	
	
	/**
	 * Resets selected gallery
	 */
	public function resetSelectedGallery() {
		$this->selectedGallery = null;
	}
	
	
	
	/**
	 * Resets selected item
	 */
	public function resetSelectedItem() {
		$this->selectedItem = null;
	}
	
	
	
	/**
	 * Resets all selections in current context
	 */
	public function resetAll() {
		$this->resetSelectedAlbum();
		$this->resetSelectedGallery();
		$this->resetSelectedItem();
	}
	
}
 
?>