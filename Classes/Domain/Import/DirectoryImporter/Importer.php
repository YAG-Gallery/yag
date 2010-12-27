<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <lienert@punkt.de>, Michael Knoll <knoll@punkt.de>
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
 * Directory based importer importing files for a given directory on the server
 *
 * @package Domain
 * @subpackage Import\DirectoryImporter
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Domain_Import_DirectoryImporter_Importer {
	 
	/**
	 * Holds directory to import files from
	 *
	 * @var string
	 */
	protected $directory;
	
	
	
	/**
	 * Holds an instance of album content manager
	 *
	 * @var Tx_Yag_Domain_AlbumContentManager
	 */
	protected $albumContentManager;
	
	
	
	/**
	 * Holds an instance of a file crawler
	 *
	 * @var Tx_Yag_Domain_Import_FileCrawler
	 */
	protected $fileCrawler;
	
	
	
	/**
	 * Constructor for directory importer
	 *
	 * @param string $directory Directory to import files from
	 */
	public function __construct($directory) {
		if (!file_exists($directory)) throw new Exception('Directory ' . $directory . ' is not existing. 1287590389');
		$this->directory = $directory;
	}
	
	
	
	/**
	 * Injector for album content manager
	 *
	 * @param Tx_Yag_Domain_AlbumContentManager $albumContentManager
	 */
	public function injectAlbumManager(Tx_Yag_Domain_AlbumContentManager $albumContentManager) {
		$this->albumContentManager = $albumContentManager;
	}
	
	
	
	/**
	 * Injector for file crawler
	 *
	 * @param Tx_Yag_Domain_Import_FileCrawler $fileCrawler
	 */
	public function injectFileCrawler(Tx_Yag_Domain_Import_FileCrawler $fileCrawler) {
		$this->fileCrawler = $fileCrawler;
	}
	
	
	
	/**
	 * Returns directory on which importer is operating on
	 *
	 * @return string
	 */
	public function getDirectory() {
		return $this->directory;
	}
	
	
	
	/**
	 * Runs actual import
	 *
	 */
	public function runImport() {
		/**
		 * Was muss hier passieren?
		 * 
		 * 1. FileCrawler muss alle Bilddateien im Verzeichnis finden
		 * 2. Für jede Bilddatei muss ein image processor die gewünschten Auflösungen berechnen
		 * 3. Für jedes Bild und jede Auflösung muss ein itemFile angelegt werden
		 * 4. Für jedes Bild muss ein album Item angelegt werden und die dazugehörigen itemFiles angehängt werden
		 * 5. Das item mit seinen itemFiles muss dem Album hinzugefügt werden
		 */
		$itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
		$itemFileRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemFileRepository');
		$resolutionItemFileRelationRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionItemFileRelationRepository');
		$resolutionRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionRepository'); /* @var $resolutionRepository Tx_Yag_Domain_Repository_ResolutionRepository */

		$resolutionPresets = $this->albumContentManager->getAlbum()->getResolutionPresets();
		$files = $this->fileCrawler->getFilesForGivenDirectory($this->directory); /* @var $files array<Tx_Yag_Domain_Model_ItemFile> */
		
		foreach ($files as $origItemFile) { /* @var origItemFile Tx_Yag_Domain_Model_ItemFile */
			// TODO what about item type & source / source type here?
            $item = new Tx_Yag_Domain_Model_Item();	
			foreach($resolutionPresets as $resolutionPreset) {
				$query = $resolutionRepository->createQuery();
				$resolutions = $query->matching($query->equals('resolutionPreset', $resolutionPreset->getUid()))->execute();
				foreach($resolutions as $resolution) {
				    $itemFile = Tx_Yag_Domain_ImageProcessing_Processor::resizeFile($origItemFile, $resolution);
				    $itemFileRepository->add($itemFile);
				    $resolutionItemFileRelation = new Tx_Yag_Domain_Model_ResolutionItemFileRelation($item, $itemFile, $resolution);
				    $resolutionItemFileRelationRepository->add($resolutionItemFileRelation);
			    }
			}
			$this->albumContentManager->addItem($item);
			$itemRepository->add($item);
		}
		
	}
	
}
 
?>