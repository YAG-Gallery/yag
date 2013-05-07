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
 * Builder for Zip importer
 *
 * @package Domain
 * @subpackage Import\ZipImporter
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Import_ZipImporter_ImporterBuilder extends Tx_Yag_Domain_Import_ImporterBuilder {

	/**
	 * Holds a singleton instance of this class
	 *
	 * @var Tx_Yag_Domain_Import_ZipImporter_ImporterBuilder
	 */
	protected static $instance = NULL;


	/**
	 * Factory method for getting an instance of this class as a singleton
	 *
	 * @return Tx_Yag_Domain_Import_ZipImporter_ImporterBuilder Singleton instance of zip importer builder
	 */
	public static function getInstance() {
		if (self::$instance === NULL) {
			self::$instance = new self(Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance());
		}
		return self::$instance;
	}



	/**
	 * Returns an instance of zip impoter for a given album
	 *
	 * @param Tx_Yag_Domain_Model_Album $album
	 * @param string $filePath Path to zip file
	 * @return Tx_Yag_Domain_Import_ZipImporter_Importer Instance of lightroom importer
	 */
	public function getZipImporterInstanceForAlbumAndFilePath(Tx_Yag_Domain_Model_Album $album, $filePath) {
		$zipImporter = $this->createImporterForAlbum('Tx_Yag_Domain_Import_ZipImporter_Importer', $album);

		/* @var $zipImporter Tx_Yag_Domain_Import_ZipImporter_Importer */
		$zipImporter->setZipFilename($filePath);
		$zipImporter->setUnzipExecutable(self::checkAndReturnUnzipExecutable());

		return $zipImporter;
	}



	/**
	 * If the unzip executable is defined, available and executable it returns it
	 *
	 * @static
	 * @return bool|string
	 */
	protected static function checkAndReturnUnzipExecutable() {
		// if zipArchive is not installed try the unzip command provided by TYPO3
		$unzipPath = trim($GLOBALS['TYPO3_CONF_VARS']['BE']['unzip_path']);
		if (substr($unzipPath, -1) !== '/' && is_dir($unzipPath)) {
			// Make sure the path ends with a slash
			$unzipPath.= '/';
		}

		if(is_executable($unzipPath . 'unzip')) {
			return $unzipPath . 'unzip';
		}

		return FALSE;
	}



	/**
	 * If either the extension zip is loaded or if we have a valid unzip executable return true
	 *  and false if not.
	 *
	 * @static
	 * @return bool
	 */
	public static function checkIfImporterIsAvailable() {
		return extension_loaded('zip') || self::checkAndReturnUnzipExecutable();
	}
	
}

?>