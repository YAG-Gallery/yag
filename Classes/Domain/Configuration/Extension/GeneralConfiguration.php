<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <knoll@punkt.de>
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
 * Class implements general configuration object for YAG.
 *
 * @package Domain
 * @subpackage Configuration
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Domain_Configuration_Extension_GeneralConfiguration extends Tx_PtExtlist_Domain_Configuration_AbstractConfiguration {

	/**
	 * Holds root path of yag hash filesystem to where all yag item files go
	 *
	 * @var string
	 */
	protected $hashFilesystemRoot;
	
	
	
	/**
	 * Holds root path of original image files
	 *
	 * @var string
	 */
	protected $origFilesRoot;
	
	
	
	/**
	 * Initializes configuration object (Template method)
	 */
	protected function init() {
		
		$this->setRequiredValue('hashFilesystemRoot', 'No Extension Configuration setting for hashFilesystemRoot! Change this in Extension Manager! 1293418501');
		if (!file_exists($this->hashFilesystemRoot)) throw new Exception('Hash filesystem root does not exist. Make sure to create directory ' . $this->hashFilesystemRoot . ' 1293418502');
		
		$this->setRequiredValue('origFilesRoot', 'No Extension Configuration setting for origFilesRoot! Change this in Extension Manager! 1293486046');
        if (!file_exists($this->hashFilesystemRoot)) throw new Exception('Directory for original files does not exist. Make sure to create directory ' . $this->origFilesRoot . ' 1293486047');
		
	}
	
	
	
	/**
	 * Returns hash filesystem root path (relative to T3 install directory)
	 *
	 * @return string Hash filesystem root path
	 */
	public function getHashFilesystemRoot() {
		return $this->hashFilesystemRoot;
	}
	
	
	
	/**
	 * Returns hash filesystem root path (absolute path on server)
	 *
	 * @return string Hash filesystem root path
	 */
	public function getHashFilesystemRootAbsolute() {
		return self::makePathAbsolute($this->getHashFilesystemRoot());
	}
	
	
	
	/**
	 * Returns directory of original files (relative to T3 install directory)
	 *
	 * @return string Original files root path
	 */
	public function getOrigFilesRoot() {
		return $this->origFilesRoot;
	}
	
	
	
	/**
	 * Returns directory of original files (absolute path on server)
	 *
	 * @return string Original files root path
	 */
	public function getOrigFilesRootAbsolute() {
		return self::makePathAbsolute($this->getOrigFilesRoot());
	}
	
	
	
	/**
	 * Helper method for adding T3 base path to paths
	 *
	 * @param string $path Path to which base path should be added
	 * @return string Absolute path
	 */
	protected static function makePathAbsolute($path) {
		return Tx_Yag_Domain_Filehandling_Div::getT3BasePath() . '/' . $path; 
	}
	
}

?>
