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
 * Gallery
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Yag_Domain_Model_Gallery extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * name
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;
	
	/**
	 * description
	 * @var string
	 */
	protected $description;
	
	/**
	 * albums
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Album>
	 */
	protected $albums;
	
	
	
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
	 * Setter for description
	 *
	 * @param string $description description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Getter for description
	 *
	 * @return string description
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * Setter for albums
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Album> $albums albums
	 * @return void
	 */
	public function setAlbums(Tx_Extbase_Persistence_ObjectStorage $albums) {
		$this->albums = $albums;
	}

	/**
	 * Getter for albums
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Album> albums
	 */
	public function getAlbums() {
		return $this->albums;
	}
	
	/**
	 * Adds a Album
	 *
	 * @param Tx_Yag_Domain_Model_Album The Album to be added
	 * @return void
	 */
	public function addAlbum(Tx_Yag_Domain_Model_Album $album) {
		$this->albums->attach($album);
	}
	
	/**
	 * Removes a Album
	 *
	 * @param Tx_Yag_Domain_Model_Album The Album to be removed
	 * @return void
	 */
	public function removeAlbum(Tx_Yag_Domain_Model_Album $album) {
		$this->albums->detach($album);
	}
	
}
?>