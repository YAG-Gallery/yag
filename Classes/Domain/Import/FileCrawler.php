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
 * Class implements File Crawler 
 *
 * @package yag
 * @subpackage Domain\Import
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Domain_Import_FileCrawler {
	
	/**
	 * Holds an instance of crawler configuration
	 *
	 * @var Tx_Yag_Domain_Configuration_Import_CrawlerConfiguration
	 */
	protected $configuration;
	
	
	
	/**
	 * Constructor for file crawler
	 *
	 * @param Tx_Yag_Domain_Configuration_Import_CrawlerConfiguration $configuration
	 */
	public function __construct(Tx_Yag_Domain_Configuration_Import_CrawlerConfiguration $configuration) {
		$this->configuration = $configuration;
	}
	
	
	
	/**
	 * Returns an array of files for given directory
	 *
	 * @param string $directory Directory to be crawled
	 * @param boolean $crawlRecursive If set to true, directories will be crawled recursive
	 * @param array &$entries Array of directory entries to add files to
	 * @return array Array of files
	 */
	public function getFilesForGivenDirectory($directory, $crawlRecursive = false, &$entries = array()) {
		self::checkForDirectoryToBeExisting($directory);
		$dirHandle = opendir($directory);
		if (!$dirHandle) throw new Exception('Directory ' . $directory . ' could not be opened 1287246092');
		while(($dirEntry = readdir($dirHandle)) != false) {
			if (!($dirEntry == '.' || $dirEntry == '..')) {
				if (!is_dir($dirEntry)) {
					$pattern = '/' . $this->configuration->getFileTypes() . '/';
					if (preg_match($pattern, $dirEntry)) {
					    $entries[] = $dirEntry;
					}	
				} elseif ($crawlRecursive) {
					$this->getFilesForGivenDirectory($dirEntry, true, $entries);
				}
			}
		}
		closedir($dirHandle);
		return $entries;
	}
	
	
	
	/**
	 * Checks for given directory to be existing.
	 *
	 * @throws Exception on non existing directory
	 * @param string $directory Directory to be checked for existence
	 */
	protected static function checkForDirectoryToBeExisting($directory) {
		if (!file_exists($directory)) {
			throw new Exception($directory . ' is not existing! 1287234117');
		}
	}
	
}
 
?>