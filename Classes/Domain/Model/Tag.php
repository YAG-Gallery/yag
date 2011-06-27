<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
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
 * Tag
 */
class Tx_Yag_Domain_Model_Tag extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * item
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_YagHelper_Domain_Model_Item>
	 */
	protected $item;


	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		* Do not modify this method!
		* It will be rewritten on each save in the extension builder
		* You may modify the constructor of this class instead
		*/
		$this->item = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_YagHelper_Domain_Model_Item> $item
	 * @return void
	 */
	public function setItem(Tx_Extbase_Persistence_ObjectStorage $item) {
		$this->item = $item;
	}

	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_YagHelper_Domain_Model_Item>
	 */
	public function getItem() {
		return $this->item;
	}

	/**
	 * @param Tx_YagHelper_Domain_Model_Item the Item to be added
	 * @return void
	 */
	public function addItem(Tx_YagHelper_Domain_Model_Item $item) {
		$this->item->attach($item);
	}

	/**
	 * @param Tx_YagHelper_Domain_Model_Item the Item to be removed
	 * @return void
	 */
	public function removeItem(Tx_YagHelper_Domain_Model_Item $itemToRemove) {
		$this->item->detach($itemToRemove);
	}

}
?>