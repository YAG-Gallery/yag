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
 * Zip Importer for YAG gallery. Enables importing images from ZIP files
 *
 * @package Domain
 * @subpackage Import\ZipImporter
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Import_ZipImporter_Importer extends Tx_Yag_Domain_Import_AbstractImporter {
	
	/**
	 * Holds path to zipFile
	 *
	 * @var string
	 */
	protected $zipFilename;
	
	
	
	/**
	 * Setter for zip filename. Sets filename (full path) of zip
	 * file to be imported.
	 *
	 * @param string $zipFilename Filname of zip file to be imported
	 */
	public function setZipFilename($zipFilename) {
		$this->zipFilename = $zipFilename;
	}
	
	
    
	/**
	 * Runs actual import. Unpacks zip file to a directory and
	 * runs directory importer to actually import the files contained
	 * in zip file.
	 */
	public function runImport() {
	    // Unpack zip file
	    $zip = new ZipArchive;
	    $tempDir = Tx_Yag_Domain_FileSystem_Div::tempdir(sys_get_temp_dir(), 'yag_zip_extraction');
        if ($zip->open($this->zipFilename) === TRUE) {
            $zip->extractTo($tempDir);
            $zip->close();
        } else {
            throw new Exception('Error when trying to extract zip archive 1294159795');
        }
        
        // Initialize directory crawler on extracted file's directory and run import
        $directoryImporter = Tx_Yag_Domain_Import_DirectoryImporter_ImporterBuilder::getInstance()->getInstanceByDirectoryAndAlbum($tempDir, $this->album);
        $directoryImporter->setMoveFilesToOrigsDirectoryToTrue(); // Files will be moved to origs directory before they are processed
        $directoryImporter->setCrawlRecursive(true);
        $directoryImporter->runImport();
	}
	
}
 
?>