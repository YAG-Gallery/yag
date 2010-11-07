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
 * Class implements abstract configuration builder 
 *
 * @package Typo3
 * @subpackage pt_extlist
 * @author Michael Knoll <knoll@punkt.de>
 */
abstract class Tx_Yag_Domain_Configuration_AbstractConfigurationBuilder {
	
	/**
	 * Holds settings for building configurations
	 *
	 * @var array
	 */
	protected $configurationSettings = array(
	    'crawlerConfiguration' => array(
	        'class' => 'Tx_Yag_Domain_Configuration_Import_CrawlerConfiguration',
	        'tsKey' => 'crawler'
	    )
	);
	
	
	
	/**
	 * Holds configuration for plugin / extension
	 *
	 * @var array
	 */
	protected $settings;
	
	
	
	/**
	 * Constructor for configuration builder. 
	 *
	 * @param array $settings Configuration settings
	 */
	public function __construct(array $settings = array()) {
		$this->settings = $settings;
	}
	
	
	
	/**
	 * Magic function 
	 *
	 * @param string $name Name of method called
	 * @param array $arguments Arguments passed to called method
	 */
	public function __call($name, $arguments) {
		if (t3lib_div::isFirstPartOfStr($name, 'build')) {
			$matches = array();
			preg_match('/build(.+)/', $name, $matches);
			return $this->buildConfigurationGeneric($matches[1]);
		}
	}
	
	
	
	/**
	 * Generic factory method for configuration objects
	 *
	 * @param string $configurationName
	 * @return mixed
	 */
	protected function buildConfigurationGeneric($configurationName) {
		// TODO use configuration object factory, if there is one
		$configurationClass = $this->configurationSettings[$configurationName]['class']; /* @var $configurationClass Tx_Yag_Domain_Configuration_AbstractConfiguration */
		$configurationObject = new $configurationClass($this);
		$configurationObject->injectSettings($this->getSettingsByTsKey($this->configurationSettings[$configurationName]['tsKey']));
		return $configurationObject;
	}
	
	
	
	/**
	 * Returns array with settings for given ts key. 
	 * Returns empty array if no settings are available for this key.
	 *
	 * @param string $tsKey Configuration key in TypoScript notation
	 * @return array 
	 */
	protected function getSettingsByTsKey($tsKey) {
		$value = Tx_Yag_Utility_Utility::getArrayContentByTsKey($this->settings, $tsKey);
		if (is_array($value)) {
			return $value;
		} else {
			return array();
		}
	}
	
}
 
?>