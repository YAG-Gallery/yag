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
 * Class implements a controller for multifile-upload using flash uploader
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_MultifileUploadController extends Tx_Yag_Controller_AbstractController {
	
	/**
	 * Holds an instance of album repository
	 *
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;
	
	
	
	/**
	 * Initialize controller
	 */
	protected function postInitializeAction() {
		$this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
	}
	
	/**
	 * Renders an upload form for multifile-uploading
	 * 
	 * @param Tx_Yag_Domain_Model_Album $album Album to upload images to
	 * @return string Rendered upload form action
	 */
	public function showUploadFormAction(Tx_Yag_Domain_Model_Album $album = null) {
		if ($album !== null) {
		    $this->view->assign('album', $album);
		} else {
			$albums = $this->albumRepository->findAll();
			$this->view->assign('albums', $albums);
		}
	}
	
	
	
	/**
	 * Handles upload via SWF uploader
	 *
	 * This action is called by SWF uploader
	 * @param Tx_Yag_Domain_Model_Album $album Album to add uploaded images to
	 * @return void Nothing, as we are called in AJAX mode from flash uploader
	 */
	public function uploadAction(Tx_Yag_Domain_Model_Album $album = null) {
		error_log(print_r($_GET, true));
		error_log(print_r($_POST, true));
		if ($album === null) {
			$this->handleError('No album was set for image upload!');
			exit(0);
		}
		if (!file_exists($_FILES['Filedata']['tmp_name'])) {
			$this->handleError('No file found in upload data!');
			exit(0);
		} 
		try {
			// TODO Respect selected album / parameter
			#$query = $this->albumRepository->createQuery();
			#$query->getQuerySettings()->setRespectStoragePage(FALSE);
			#$albums = $query->execute();
			#$album = $albums[0];
			$fileToImport = $_FILES['Filedata']['tmp_name'];
			$fileImporter = Tx_Yag_Domain_Import_FileImporter_ImporterBuilder::getInstance()->getImporterInstanceByFilePathAndAlbum($fileToImport, $album);
			#error_log('hier bin ich noch');
			$fileImporter->runImport();
		} catch (Exception $e) {
			// We are in ajax mode, no error goes to browser --> write to error log
			error_log($e->getMessage());
			error_log($e->getTraceAsString());
			$this->handleError('An error occured while uploading file: ' . $e->getMessage());
			exit(0);
		}
	}
	
	
	
	/**
	 * Handles errors
	 *
	 * @param string $message
	 */
	protected function handleError($message) {
		ob_clean();
	    header("HTTP/1.1 500 Internal Server Error");
	    error_log($message);
	    echo $message;
    }
	
	
}
 
?>