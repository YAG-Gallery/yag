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
 * Controller for import
 *
 * @package yag
 * @subpackage Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_ImportController extends Tx_Yag_Controller_AbstractController {

	/**
	 * Action for importing data from jm_gallery extension.
	 * 
	 * @return string Rendered jmImportAction
	 */
	public function jmImportAction() {
		$jmImporter = new Tx_Yag_Domain_Import_JmGallery_Importer();
		$jmImporter->runImport();
		
		$this->flashMessages->add('Data from jm_gallery extension has been imported');
		
		$this->forward('index', 'Gallery');
	}
	
	
	
	/**
	 * Action for generating a JSON encoded array with categories and albums of jm_gallery
	 *
	 * @return string JSON encoded array of categories and albums from jm_gallery
	 */
	public function getCategoriesAndAlbumsAction() {
		$jmImporter = new Tx_Yag_Domain_Import_JmGallery_Importer();
		$jsonArray = $jmImporter->getCategoriesWithAlbumsJsonArray();
		
		ob_clean();
        header('Content-Type: application/json;charset=UTF-8');
		echo $jsonArray;
		exit();
	}
	
	
	
	/**
	 * Imports all categories of jm_gallery without any depending albums
	 * 
	 * @return string 'OK' if everything went well
	 */
	public function importCategoriesAction() {
		$jmImporter = new Tx_Yag_Domain_Import_JmGallery_Importer();
		$jmImporter->runCategoryImport();
		
		ob_clean();
        echo 'OK';
        exit();
	}
	
	
	
	/**
	 * Imports a given jm_gallery album into yag gallery
	 *
	 * @param int $jmAlbumUid
	 */
	public function importAlbumAction($jmAlbumUid) {
		$jmImporter = new Tx_Yag_Domain_Import_JmGallery_Importer();
        $jmImporter->runAlbumImport($jmAlbumUid);
        
        ob_clean();
        echo 'OK';
        exit();
	}
	
}

?>