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
 * @package Domain
 * @subpackage FileSystem
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory {
	
	/**
	 * Holds an instance of the FileRepository to access the gallery files
	 *
	 * @var Tx_Yag_Domain_FileSystem_ResolutionFileCache
	 */
	protected static $instance = NULL;
	
	
	
	/**
	 * Factory method for file repository
	 *
	 * @return Tx_Yag_Domain_FileSystem_ResolutionFileCache
	 */
	public static function getInstance() {
		
		$configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance();

		if(self::$instance === NULL) {

			$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager'); /** @var Tx_Extbase_Object_ObjectManager $objectManager  */
			self::$instance = $objectManager->get('Tx_Yag_Domain_FileSystem_ResolutionFileCache');

			$hashFileSystem = Tx_Yag_Domain_FileSystem_HashFileSystemFactory::getInstance();
			self::$instance->_injectHashFileSystem($hashFileSystem);

			$imageProcessor = Tx_Yag_Domain_ImageProcessing_ProcessorFactory::getInstance($configurationBuilder);
			self::$instance->_injectImageProcessor($imageProcessor);
			
			self::$instance->_injectConfigurationBuilder(Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance());
		}
		
		return self::$instance;
	}
	
}
 
?>