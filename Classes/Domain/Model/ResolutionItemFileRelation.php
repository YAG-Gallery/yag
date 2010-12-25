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
class Tx_Yag_Domain_Model_ResolutionItemFileRelation extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * item
	 * @var Tx_Yag_Domain_Model_Item
	 */
	protected $item;
	
	/**
	 * resolution
	 * @var Tx_Yag_Domain_Model_Resolution
	 */
	protected $resolution;
	
	/**
	 * itemFile
	 * @var Tx_Yag_Domain_Model_ItemFile
	 */
	protected $itemFile;
	
	
	
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
	 * Setter for resolution
	 *
	 * @param Tx_Yag_Domain_Model_Resolution $resolution resolution
	 * @return void
	 */
	public function setResolution(Tx_Yag_Domain_Model_Resolution $resolution) {
		$this->resolution = $resolution;
	}

	/**
	 * Getter for resolution
	 *
	 * @return Tx_Yag_Domain_Model_Resolution resolution
	 */
	public function getResolution() {
		return $this->resolution;
	}
	
	/**
	 * Setter for itemFile
	 *
	 * @param Tx_Yag_Domain_Model_ItemFile $itemFile itemFile
	 * @return void
	 */
	public function setItemFile(Tx_Yag_Domain_Model_ItemFile $itemFile) {
		$this->itemFile = $itemFile;
	}

	/**
	 * Getter for itemFile
	 *
	 * @return Tx_Yag_Domain_Model_ItemFile itemFile
	 */
	public function getItemFile() {
		return $this->itemFile;
	}
	
}
?>