<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>
*  			Michael Knoll <mimi@kaktusteam.de>
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
 * Class implements context configuration object for YAG.
 *
 * @package Domain
 * @subpackage Configuration\Context
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Configuration_Context_ContextConfig extends Tx_PtExtbase_Configuration_AbstractConfiguration {

	/**
	 * Selected Item
	 * 
	 * @var int
	 */
	protected $selectedItemUid;
	
	
	
	/**
	 * Selected Album
	 * 
	 * @var int
	 */
	protected $selectedAlbumUid;

	
	
	/**
	 * Selected Gallery
	 * 
	 * @var int
	 */
	protected $selectedGalleryUid;



	/**
	 * Pid selected in flexform source widget
	 *
	 * @var int
	 */
	protected $selectedPid;
	
	
	
	/**
	 * Initializes configuration object (Template method)
	 */
	protected function init() {
		$this->setValueIfExistsAndNotNothing('selectedItemUid');
		$this->setValueIfExistsAndNotNothing('selectedAlbumUid');
		$this->setValueIfExistsAndNotNothing('selectedGalleryUid');
		$this->setValueIfExistsAndNotNothing('selectedPid');
	}


	
	/**
	 * @param int $itemUid
	 */
	public function setSelectedItemUid($itemUid) {
		$this->selectedItemUid = $itemUid;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getSelectedItemUid() {
		return $this->selectedItemUid;
	}
	
	
	
	/**
	 * @param int $albumUid
	 */
	public function setSelectedalbumUid($albumUid) {
		$this->selectedAlbumUid = $albumUid;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getSelectedAlbumUid() {
		return $this->selectedAlbumUid;
	}
	
	
	
	/**
	 * @param int $galleryUid
	 */
	public function setSelectedGalleryUid($galleryUid) {
		$this->selectedGalleryUid = $galleryUid;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getSelectedGalleryUid() {
		return $this->selectedGalleryUid;
	}



	/**
	 * Returns pid selected in flexform source widget
	 *
	 * @return int
	 */
	public function getSelectedPid() {
		return $this->selectedPid;
	}

}
?>