<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*            
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
 * Class implements an controller for importing images from a directory
 * 
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_DirectoryImportController extends Tx_Yag_Controller_AbstractController {
	
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
	 * Shows import form for selecting directory to import images from
	 *
	 * @param string $root Directory to show initially 
	 * @return string The HTML source for import form
	 * @rbacNeedsAccess
	 * @rbacObject album
	 * @rbacAction edit
	 */
	public function showImportFormAction($directory='') {
		$GLOBALS['TSFE']->additionalHeaderData['text_css'] = '<link type="text/css" href="fileadmin/jquery/css/ui-lightness/jquery-ui-1.8.7.custom.css" rel="Stylesheet" />';
		
		$albums = $this->albumRepository->findAll();
		$this->view->assign('pageId', $_GET['id']);
		$this->view->assign('albums', $albums);
		$this->view->assign('directory', $directory);
	}
	
	
	
	/**
	 * Shows results for importing images from directory
	 *
	 * @param string $directory
	 * @param int $albumUid
	 * @return string The HTML source for import from directory action
	 * @rbacNeedsAccess
	 * @rbacObject album
	 * @rbacAction edit
	 */
	public function importFromDirectoryAction($directory, $albumUid) {
		$album = $this->albumRepository->findByUid($albumUid);
		
		// Directory must be within fileadmin
		$directory = Tx_Yag_Domain_FileSystem_Div::getT3BasePath() . 'fileadmin/' . $directory;
		
		$importer = Tx_Yag_Domain_Import_DirectoryImporter_ImporterBuilder::getInstance()->getInstanceByDirectoryAndAlbum($directory, $album);
		$importer->runImport();
		
		$this->view->assign('album', $album);
		$this->view->assign('directory', $directory);
	}
	
}

?>
