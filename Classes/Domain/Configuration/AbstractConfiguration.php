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
 * Class implements an abstract configuration object
 *
 * @package yag
 * @subpackage Domain\Configuration
 * @author Michael Knoll <knoll@punkt.de>
 */
abstract class Tx_Yag_Domain_Configuration_AbstractConfiguration {

	/**
	 * Holds an instance of configuration builder
	 *
	 * @var Tx_Yag_Domain_Configuration_AbstractConfigurationBuilder
	 */
	protected $configurationBuilder;
	
	
	
	/**
	 * Holds an array of settings for configuration object
	 *
	 * @var array
	 */
	protected $settings;
	
	
	
	/**
	 * Constructor for configuration object
	 *
	 * @param Tx_Yag_Domain_Configuration_AbstractConfigurationBuilder $configurationBuilder
	 */
	public function __construct(Tx_Yag_Domain_Configuration_AbstractConfigurationBuilder $configurationBuilder) {
		$this->configurationBuilder = $configurationBuilder;
		$this->init();
	}
	
	
	
	/**
	 * Injects settings array
	 *
	 * @param array $settings
	 */
	public function injectSettings(array $settings = array()) {
		$this->settings = $settings;
	}
	
	
	
	/**
	 * Returns all settings of configuration object
	 *
	 * @return array
	 */
	public function getSettings() {
		return $this->settings;
	}
	
	
	
	/**
	 * Returns setting for a given TS key.
	 * 
	 * If second parameter is true, returns null if no value is available for key.
	 * If second parameter is false, throws exception, if no value is available for key. 
	 *
	 * @param string $tsKey Typoscript key in dot '.' notation
	 * @param bool $returnNullIfEmpty Returns null, if key is empty. 
	 * @return mixed String if value is scalar, Array if not.
	 */
	public function getSettingByTsKey($tsKey, $returnNullIfEmpty = true) {
        return Tx_Yag_Utility_Utility::getArrayContentByTsKey($this->settings, $tsKey, $returnNullIfEmpty);
	}
	
	
	
	/**
	 * Template method for initializing configuration object.
	 * 
	 * Overwrite this method for implementing your own initialization
	 * functionality in concrete class.
	 */
	protected function init() { }
	
}
 
?>