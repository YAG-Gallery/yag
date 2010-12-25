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
	 * Shows import form for selecting directory to import images from
	 *
	 * @param string $root Directory to show initially 
	 * @return string The HTML source for import form
	 */
	public function showImportFormAction($root='') {
		
	}
	
	
	
	/**
	 * Shows results for importing images from directory
	 *
	 * @param string $directory
	 * @return string The HTML source for import from directory action
	 */
	public function importFromDirectoryAction($directory, Tx_Yag_Domain_Model_Album $album) {
		$importer = new Tx_Yag_Domain_Import_DirectoryImporter_Importer($directory);
		$importer->injectAlbumManager(new Tx_Yag_Domain_AlbumContentManager($album));
		$importer->injectFileCrawler(new Tx_Yag_Domain_Import_FileCrawler($this->configurationBuilder->buildCrawlerConfiguration()));
		$importer->runImport();
		$this->view->assign('directory', $directory);
	}
	
}

?>
