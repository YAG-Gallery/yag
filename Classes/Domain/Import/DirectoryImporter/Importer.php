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
 * Directory based importer importing files for a given directory on the server
 *
 * @package Domain
 * @subpackage Import\DirectoryImporter
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Domain_Import_DirectoryImporter_Importer extends Tx_Yag_Domain_Import_AbstractImporter {
	 
	/**
	 * Holds directory to import files from
	 *
	 * @var string
	 */
	protected $directory;
	
	
	
	/**
	 * Holds an instance of a file crawler
	 *
	 * @var Tx_Yag_Domain_Import_FileCrawler
	 */
	protected $fileCrawler;
	
	
	
	/**
	 * If set to true, files found in the directory 
	 * are moved to the directory of original files for
	 * the album before they are processed
	 *
	 * @var bool
	 */
	protected $moveFilesToOrigsDirectory = false;
	
	
	
    /**
     * Sets directory to crawl for files
     *
     * @param string $directory Directory to be crawled
     */	
	public function setDirectory($directory) {
		if (!file_exists($directory)) throw new Exception('Directory ' . $directory . ' is not existing. 1287590389');
		$this->directory = $directory;
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
	 * Runs actual import.
	 * 
	 * Crawls given directory for images using file crawler. 
	 * Each image found in this directory is added to the given album.
	 */
	public function runImport() {
		$files = $this->fileCrawler->getFilesForGivenDirectory($this->directory);
		foreach ($files as $filepath) { 
			$item = null;
			if ($this->moveFilesToOrigsDirectory) {
				$item = $this->getNewPersistedItem();
				$filepath = $this->moveFileToOrigsDirectory($filepath, $item);
			}
            $this->importFileByFilename($filepath, $item);
		}
	}
	
	
	
	/**
	 * Moves a file from given filepath to directory for original images for album 
	 * 
	 * If an item is given, UID of item is used as filename for item in original items directory
	 *
	 * @param string $filepath Full qualified filepath of file to move
	 * @param Tx_Yag_Domain_Model_Item $item Item that should hold file (not modified, make sure to set sourceuri manually!)
	 */
	protected function moveFileToOrigsDirectory($filepath, Tx_Yag_Domain_Model_Item $item = null) {
		// Create path to move file to
		$origsFilePath = $this->getOrigFileDirectoryPathForAlbum();
		$origsFilePath .= $item !== null ? 
		    $item->getUid() . '.jpg' :    // if we get an item, we use UID of item as filename
		    Tx_Yag_Domain_FileSystem_Div::getFilenameFromFilePath($filepath);  // if we do not get one, we use filename of given filepath
		    
		if (!rename($filepath, $origsFilePath)) {
		    throw new Exception('Could not move file ' . $filepath . ' to ' . $origsFileDirectory . ' 1294176900');
		}

		return $origsFilePath;
	}
	
	
	
	/**
	 * Files will be moved to a directory containing original files
	 * for album before they are processed
	 */
	public function setMoveFilesToOrigsDirectoryToTrue() {
		$this->moveFilesToOrigsDirectory = true;
	}
	
	
	
	/**
	 * Files won't be moved to a directory containing original files
	 * for album before they are processed
	 */
	public function setMoveFilesToOrigsDirectoryToFalse() {
		$this->moveFilesToOrigsDirectory = false;
	}
	
}
 
?>