<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <knoll@punkt.de>
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
 * Class implements an controller for importing images from a zip archive
 * 
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_ZipImportController extends Tx_Yag_Controller_AbstractController {
	
	/**
	 * Holds instance of album repository
	 *
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;
	
	
	
	/**
	 * Initializes controller
	 */
	protected function initializeAction() {
		parent::initializeAction();
		$this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
	}
	
	
	

	/**
	 * Shows import form for selecting album to import images to
	 *
	 * @return string The HTML source for import form
	 */
	public function showImportFormAction() {
		$albums = $this->albumRepository->findAll();
		$this->view->assign('albums', $albums);
	}
	
	
	
	/**
	 * Shows results for importing images from zip
	 *
	 * @param int $albumUid
	 * @return string The HTML source for import from zip action
	 */
	public function importFromZipAction($albumUid) {
		$album = $this->albumRepository->findByUid($albumUid);
		
		$importer = Tx_Yag_Domain_Import_ZipImporter_ImporterBuilder::getInstance()->getZipImporterInstanceForAlbum($album);
		$importer->runImport();
		
		$this->view->assign('album', $album);
	}
	
}

?>
