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
 * Factory for hash filesystem
 *
 * @package Domain
 * @subpackage FileSystem
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_FileSystem_HashFileSystemFactory {
	
	/**
	 * Holds an array of instances, one for each directory a hash filesystem is instantiated upon
	 *
	 * @var array<Tx_Yag_Domain_FileSystem_HashFileSystem>
	 */
	protected static $instancesArray = array();
	
	
	
	/**
	 * Factory method for hash filesystem. Returns singleton instance for each 
	 * directory given.
	 *
	 * @param string $directory
	 * @return Tx_Yag_Domain_FileSystem_HashFileSystem
	 */
	public static function getInstance($directory = NULL) {
		if ($directory === NULL) {
			/* Instantiate default hash filesystem as configured in em_config */
			$directory = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()->buildExtensionConfiguration()->getHashFilesystemRoot();
		}
			
		if (!array_key_exists($directory, self::$instancesArray)) {
			self::$instancesArray[$directory] = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')->get('Tx_Yag_Domain_FileSystem_HashFileSystem', $directory);
		}
		return self::$instancesArray[$directory];
	}
	
}
?>