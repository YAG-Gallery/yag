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
 * Class implements album configuration object for YAG.
 *
 * @package Domain
 * @subpackage Configuration
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Configuration_Album_AlbumConfiguration extends Tx_PtExtlist_Domain_Configuration_AbstractConfiguration {

	/**
	 * Selected album UID when run in single album mode
	 * 
	 * @var int
	 */
	protected $selectedAlbumUid;
	
	
	/**
	 * Items to show per page
	 * 
	 * @var integer
	 */
	protected $itemsPerPage;
	
	
	
	/**
	 * Initializes configuration object (Template method)
	 */
	protected function init() {
		$this->setValueIfExists('selectedAlbumUid');
		$this->setValueIfExists('itemsPerPage');
	}

	
	
	/**
	 * @return int 
	 */
	public function getSelectedAlbumUid() {
		return $this->selectedAlbumUid;
	}

	
	
	
	/**
	 * @return int 
	 */
	public function getItemsPerPage() {
		return $this->getItemsPerPage();
	}
}
?>