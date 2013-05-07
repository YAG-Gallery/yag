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
 * Directory based importer importing files for a given directory on the server
 *
 * @package Domain
 * @subpackage Import\DirectoryImporter
 * @author Michael Knoll <mimi@kaktsuteam.de>
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
	 * If set to true, directory will be crawled recursive. Subdirs will also be crawled for images then.
	 *
	 * @var bool
	 */
	protected $crawlRecursive = FALSE;



    /**
     * If set to true, no duplicate images will be imported to given album
     *
     * @var bool
     */
    protected $noDuplicates = FALSE;



    /**
     * Holds item sorting number for associated album
     *
     * @var int
     */
    protected $itemSorting = 0;



    /**
     * Holds number of items that were imported
     * 
     * @var int
     */
    protected $itemsImported = 0;


	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;


	/**
	 * Injector for file crawler
	 *
	 * @param Tx_Yag_Domain_Import_FileCrawler $fileCrawler
	 */
	public function _injectFileCrawler(Tx_Yag_Domain_Import_FileCrawler $fileCrawler) {
		$this->fileCrawler = $fileCrawler;
	}


	/**
	 * @param Tx_Extbase_Object_ObjectManager $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}
	
	
    /**
     * Sets directory to crawl for files
     *
     * @param string $directory Directory to be crawled
	 * @throws Exception
     */	
	public function setDirectory($directory) {
		if (!file_exists($directory)) throw new Exception('Directory ' . $directory . ' is not existing.', 1287590389);
		$this->directory = $directory;
	}
	
	
	
	/**
	 * Sets crawl recursive to true, if given value is 
	 * true respected to be interpreted as bool.
	 *
	 * @param bool $crawlRecursive
	 */
	public function setCrawlRecursive($crawlRecursive) {
		if ($crawlRecursive) {
		    $this->crawlRecursive = TRUE;
		} else {
			$this->crawlRecursive = FALSE;
		}
	}



    public function setNoDuplicates($noDuplicates) {
        if ($noDuplicates) {
            $this->noDuplicates = TRUE;
        } else {
            $this->noDuplicates = FALSE;
        }
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
		$files = $this->fileCrawler->getFilesForGivenDirectory($this->directory, $this->crawlRecursive);

        $this->initItemSorting();

		foreach ($files as $filePath) {
            // Prevent import, if noDuplicates is set to true and we already have item imported in album
            if ($this->noDuplicates && $this->album->containsItemByHash(md5_file($filePath))) {
                continue;
            }

			$item = NULL;
			if ($this->moveFilesToOrigsDirectory) {
				$item = $this->getNewPersistedItem();
				$filePath = $this->moveFileToOrigsDirectory($filePath, $item);
			} else {
                $item = $this->objectManager->get('Tx_Yag_Domain_Model_Item');
            }

			$item->setOriginalFilename(Tx_Yag_Domain_FileSystem_Div::getFilenameFromFilePath($filePath));

            // We increase item sorting with each item that has to be imported
            $item->setSorting(++$this->itemSorting);

			$this->importFileByFilename($filePath, $item);
            $this->itemsImported++;
		}
		$this->runPostImportAction();
	}



    /**
     * Getter for itemsImported
     *
     * Returns number of items that were imported during last import run
     *
     * @return int
     */
    public function getItemsImported() {
        return $this->itemsImported;
    }



    /**
     * Initializes item sorting by taking biggest sorting number so far available for items in current album
     * 
     * @return void
     */
    protected function initItemSorting() {
        $this->itemSorting = $this->album->getMaxSorting();
    }
	
}
 
?>