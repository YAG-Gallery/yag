<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Class implements a manager that handles album content
 *
 * TODO check whether this class is really necessary
 *
 * @package Domain
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class Tx_Yag_Domain_AlbumContentManager {

	/**
	 * Holds instance of an album to operate on
	 *
	 * @var Tx_Yag_Domain_Model_Album
	 */
	protected $album;
	
	
	
	/**
	 * Constructor for album manager.
	 *
	 * @param Tx_Yag_Domain_Model_Album $album Album to operate on
	 */
	public function __construct(Tx_Yag_Domain_Model_Album $album) {
		$this->album = $album;
	}
	
	
	
	/**
	 * Returns album on which content manager operates on
	 *
	 * @return Tx_Yag_Domain_Model_Album
	 */
	public function getAlbum() {
		return $this->album;
	}
	
	
	
	/**
	 * Adds an image to album
	 *
	 * @param Tx_Yag_Domain_Model_Item $item Item to be added to album
	 */
	public function addItem(Tx_Yag_Domain_Model_Item $item) {
		$this->album->addItem($item);
		
		if($this->album->getThumb() == NULL) {
			$this->album->setThumb($item);
		}
		
	}
	
	
	
	/**
	 * Sets gallery thumb album to current album if no thumb album is existing
	 */
	public function setAlbumAsGalleryThumbIfNotExisting() {
		$gallery = $this->getAlbum()->getGallery();
		if ($gallery->getThumbAlbum() == NULL) {
			$gallery->setThumbAlbum($this->album);
		}
	}
	
}
 
?>