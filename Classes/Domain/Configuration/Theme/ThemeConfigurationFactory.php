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
 * Factory for theme configuration
 *
 * @package Domain
 * @subpackage Configuration\Theme
 
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_Theme_ThemeConfigurationFactory {
    
	/**
	 * Holds an instance of theme configuration
	 *
	 * @var Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration
	 */
    protected static $instance = null;
    
    
    
    /**
     * Returns an instance of theme configuration
     *
     * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
     * @return Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration
     */
    public static function getInstance(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
    	if (self::$instance === null) {
    		$themeSettings = $configurationBuilder->getSettingsForConfigObject('theme');
    		self::$instance = new Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration($configurationBuilder, $themeSettings);
    	}
    	return self::$instance;
    }
} 
?>