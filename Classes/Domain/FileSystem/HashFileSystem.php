<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Class implements hash-file system for storing files in an hierarchical 
 * directory. Each Directory contains at most MAX_FILES files and MAX_FILES
 * directories, before it starts to use subdirectories.
 *
 * Examples:
 * 
 * 1       => 00/1
 * 100     => 00/01/100
 * 10999   => 01/09/10999
 *
 * @package Domain
 * @subpackage FileSystem
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class Tx_Yag_Domain_FileSystem_HashFileSystem {

	/**
	 * Defines number of files to be stored in a directory before 
	 * new subdirectory will be created.
	 */
	const MAX_FILES = 100;
	
	
	
	/**
	 * Holds path to root directory to set up hash filesystem
	 *
	 * @var string
	 */
	protected $rootDirectory;
	
	
	
	/**
	 * Constructor for file system class
	 *
	 * @param string $rootDirectory Path to root directory for filesystem
	 */
	public function __construct($rootDirectory) {
		$absolutRootDirectory = Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($rootDirectory);
		if (!file_exists($absolutRootDirectory)) throw new Exception('Directory ' . $absolutRootDirectory . ' does not exist! 1287524902');
		$this->rootDirectory = $rootDirectory;
	}
	
	
	
	/**
	 * Returns a path for a file for a given ID relative to root directory of file system.
	 *
	 * @param int $fileId
	 * @return string Relative path for given ID
	 */
	public function getRelativePathById($fileId) {
		$reversePathArray = array();
		$remainingHashValue = $fileId;
	    for ($remainingHashValue; $remainingHashValue = (int) ($remainingHashValue / self::MAX_FILES); ) {
            $reversePathArray[] = sprintf('%02d',$remainingHashValue % self::MAX_FILES);
        }
        if (!$reversePathArray) $reversePathArray[] = '00';
		return implode('/', array_reverse($reversePathArray));
	}
	
	
	
	/**
	 * Returns an absolute path for a file for a given ID.  
	 *
	 * @param int $fileId
	 * @return string Absolute path for given File ID
	 */
	public function getAbsolutePathById($fileId) {
		if (substr($this->rootDirectory,-1,1) == '/') {
		    return $this->rootDirectory . $this->getRelativePathById($fileId);
		} else {
			return $this->rootDirectory . '/' . $this->getRelativePathById($fileId);
		}
	}
 	
	
	
	/**
	 * Creates a path for a given ID and returns path
	 *
	 * @param int $fileId
	 * @return string Absolute path for given File ID
	 */
	public function createAndGetAbsolutePathById($fileId) {
		$path = $this->getAbsolutePathById($fileId);
		Tx_Yag_Domain_FileSystem_Div::checkDir($path);
		return $path;
	}	
}
?>