<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>
*  				  Michael Knoll <mimi@kaktusteam.de>
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
 * @subpackage Configuration\AlbumList
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Configuration_AlbumList_AlbumListConfig extends Tx_PtExtbase_Configuration_AbstractConfiguration {


	/**
	 * @var string
	 */
	protected $albumThumbPartial;


	/**
	 * @var string
	 */
	protected $pagerPartial;


	/**
	 * @var string
	 */
	protected $pagerIdentifier = 'default';

	
	/**
	 * @var int
	 */
	protected $columnCount;
	
	
	/*
	 * @var int
	 */
	protected $itemsPerPage;
	
	
	/**
	 * Initializes configuration object (Template method)
	 */
	protected function init() {
		$this->setRequiredValue('albumThumbPartial', 'No thumb partial set in typoscript config.');
		
		$this->setValueIfExists('itemsPerPage');
		$this->setValueIfExists('columnCount');
		$this->setValueIfExists('pagerIdentifier');
		$this->setValueIfExists('pagerPartial');
	}
	
	
	
	/**
	 * @return string
	 */
	public function getAlbumThumbPartial() {
		return $this->albumThumbPartial;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getColumnCount() {
		return $this->columnCount;
	}
	
	
	
	/**
	 * Get the columns relative width
	 * @return int
	 */
	public function getColumnRelativeWidth() {
		return number_format(100 / $this->columnCount,0);
	}
	
	
	
	/**
	 * @return int
	 */
	public function getItemsPerPage() {
		return $this->itemsPerPage;
	}

	/**
	 * @return string
	 */
	public function getPagerIdentifier() {
		return $this->pagerIdentifier;
	}

	/**
	 * @return string
	 */
	public function getPagerPartial() {
		return $this->pagerPartial;
	}

}
?>