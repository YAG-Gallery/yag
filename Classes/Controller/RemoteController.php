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
 * Remote controller for using yag web services
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_RemoteController extends Tx_Yag_Controller_AbstractController {

	/**
	 * Holds an instance of album repository
	 *
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;
	
	
	
	/**
	 * Initialize this controller
	 */
	protected function initializeAction() {
		$this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
	}
	
	
	
	/**
	 * Action for adding an item to an album
	 *
	 * @param int $albumUid UID of album to add image to
	 */
	public function addItemToAlbumAction($albumUid) {
    	$album = $this->albumRepository->findByUid($albumUid);
    	$albumContentManager = new Tx_Yag_Domain_AlbumContentManager($album);
    	$album->setName('Lightrooom');
    	$album->setDescription(print_r($_FILES,true));
    	$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager'); /* @var $persistenceManager Tx_Extbase_Persistence_Manager */
        $persistenceManager->persistAll();
		$importer = new Tx_Yag_Domain_Import_LightroomImporter_Importer($this->configurationBuilder, $albumContentManager);
		$importer->setAlbum($album);
		$importer->runImport();
	}
	
}

?>