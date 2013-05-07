<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
class Tx_Yag_Controller_FileUploadController extends Tx_Yag_Controller_AbstractController {
	
	/**
	 * Renders an upload form for multifile-uploading
	 * 
	 * @return string Rendered upload form action
	 */
	public function showUploadFormAction() {
		// Nothing to do so far but showing the upload form template
		// TODO make album selectable 
	}
	
	
	
	/**
	 * Handles upload via SWF uploader
	 *
	 * This action is called by SWF uploader
	 *
	 * @rbacNeedsAccess
	 * @rbacObject album
	 * @rbacAction edit
	 *
	 * @param Tx_Yag_Domain_Model_Album $album Album to add uploaded images to
	 * @return void Nothing, as we are called in AJAX mode from flash uploader
	 */
	public function uploadAction(Tx_Yag_Domain_Model_Album $album = NULL) {

		if (!is_array($_FILES) || !isset($_FILES['Filedata'])) {
			$this->handleError('No file found in upload data!');
		}

		if(!file_exists($_FILES['Filedata']['tmp_name'])) {
			$this->handleError(
				sprintf('File %s was uploaded and saved as %s, but this file is not readable!', $_FILES['Filedata']['name'], $_FILES['Filedata']['tmp_name'])
			);
		}

		try {
			#$rawFileName = $_FILES['Filedata']['name'];
			#$encoding = mb_detect_encoding($rawFileName);
			#$fileName =  mb_convert_encoding($rawFileName, 'UTF-8', $encoding);

			$fileName = $_FILES['Filedata']['name'];

			t3lib_div::devLog('Converted filename: ' . $fileName, 'yag', 0, array('$_FILES' => $_FILES));

			$fileImporter = Tx_Yag_Domain_Import_FileImporter_ImporterBuilder::getInstance()->getImporterInstanceByAlbum($album);
			
			$fileImporter->setFilePath($_FILES['Filedata']['tmp_name']);
			$fileImporter->setOriginalFileName($fileName);
			$fileImporter->setItemType($_FILES['Filedata']['type']);

			if ($this->feUser) {
				$fileImporter->setFeUser($this->feUser);
			}

			$fileImporter->runImport();
		} catch (Exception $e) {
			// We are in ajax mode, no error goes to browser --> write to dev log
			$this->handleError('An error occurred while uploading file: ' . $e->getMessage());
		}


		$this->exit_status('OK');
	}



	/**
	 * @param $status
	 */
	function exit_status($status){
    	echo json_encode(array('status'=>$status));
    	exit;
	}



	/**
	 * Handles errors
	 *
	 * @param string $message
	 */
	protected function handleError($message) {
		error_log('YAG Upload error: ' . $message);
        t3lib_div::devLog($message, 'yag', 3);
		ob_clean();
	    header("HTTP/1.1 500 Internal Server Error");
		exit(0);
    }
	
}
?>