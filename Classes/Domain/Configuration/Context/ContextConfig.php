<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>
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
class Tx_Yag_Domain_Configuration_Context_ContextConfig extends Tx_PtExtlist_Domain_Configuration_AbstractConfiguration {

	/**
	 * Selected Item
	 * 
	 * @var integer
	 */
	protected $selectedItem;
	
	
	
	/**
	 * Selected Album
	 * 
	 * @var integer
	 */
	protected $selectedAlbum;

	
	
	/**
	 * Selected Gallery
	 * 
	 * @var integer
	 */
	protected $selectedGallery;
	
	
	
	/**
	 * Initializes configuration object (Template method)
	 */
	protected function init() {
		$this->setValueIfExistsAndNotNothing('selectedItem');
		$this->setValueIfExistsAndNotNothing('selectedAlbum');
		$this->setValueIfExistsAndNotNothing('selectedGallery');
	}
	
	
	
	/**
	 * @return int
	 */
	public function getSelectedItem() {
		return $this->selectedItem;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getSelectedAlbum() {
		return $this->selectedAlbum;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getSelectedGallery() {
		return $this->selectedGallery;
	}
}
?>