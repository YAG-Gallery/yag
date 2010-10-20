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
 * @package yag
 * @subpackage Domain\Import\DirectoryImporter
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
		$this->albumContentManager = $albumManager;
	}
	
	
	
	/**
	 * Returns directory on which importer is operating on
	 *
	 * @return string
	 */
	public function getDirectory() {
		return $this->directory;
	}
	
}
 
?>