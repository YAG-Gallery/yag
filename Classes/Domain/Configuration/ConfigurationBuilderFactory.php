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
 * Class implements factory for configuration builder
 *
 * @package Domain
 * @subpackage Configuration
 * @author Michael Knoll <mimi@kaktsuteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory {

	/**
	 * Holds instance of configuration builder as singleton
	 *
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected static $instances = array();
	
	
	/**
	 * Holds an array of all extList settings
	 * 
	 * @var array
	 */
	private static $settings = NULL;
	
	
	/**
	 * Backup of last called contextIdentifier
	 * 
	 * @var string
	 */
	private static $contextIdentifier;
	
	
	/**
	 * Inject all settings of the extension 
	 * @param array $settings The current settings for this extension.
	 */
	public static function injectSettings(array &$settings) {
		self::$settings = &$settings;
	}
	
	
	
	/**
	 * Factory method creates singleton instance of configuration builder
	 *
	 * @param string $contextIdentifier
	 * @param string $theme
	 * @param boolean $resetContext
	 * @return Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 * @throws Exception
	 */
	public static function getInstance($contextIdentifier = NULL, $theme = NULL, $resetContext = FALSE) {

		if ($contextIdentifier === NULL) {
			$contextIdentifier = self::$contextIdentifier;
		} else {
			self::$contextIdentifier = $contextIdentifier;
		}
		
		if(!$contextIdentifier) throw new Exception('No contextIdentifier given!', 1298932605);
		
		if (!array_key_exists($contextIdentifier,self::$instances) || $resetContext === TRUE) {

			if(!isset($theme) || $theme == '') throw new Exception('The theme identifier was not set. Please check your TypoScript configuration.', 1354638078);

			if(!is_array(self::$settings['themes']) || !array_key_exists($theme, self::$settings['themes'])) {
				throw new Exception('No theme with name '.$theme.' could be found in settings!', 1298920754);
			}
        
			$configurationBuilder = new Tx_Yag_Domain_Configuration_ConfigurationBuilder(self::$settings, $contextIdentifier, $theme);
            self::$instances[$contextIdentifier] = $configurationBuilder;
        }
        
        return self::$instances[$contextIdentifier];
	}
}
?>