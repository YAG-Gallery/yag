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
 * Configuration Builder for YAG configuration
 *
 * @package Domain
 * @subpackage Configuration
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Domain_Configuration_ConfigurationBuilder extends Tx_PtExtlist_Domain_Configuration_AbstractConfigurationBuilder {
	

	/**
	 * Holds settings to build configuration objects
	 *
	 * @var array
	 */
	protected $configurationObjectSettings = array(
		'album' => 
				array('factory' => 'Tx_Yag_Domain_Configuration_Album_AlbumConfigurationFactory'),
		'crawler' =>
		    	array('factory' => 'Tx_Yag_Domain_Configuration_Import_CrawlerConfigurationFactory'),
		'imageProcessor' => 
		    	array('factory' => 'Tx_Yag_Domain_Configuration_ImageProcessing_ImageProcessorConfigurationFactory'),
		'general' =>
		    	array('factory' => 'Tx_Yag_Domain_Configuration_Extension_GeneralConfigurationFactory'),
	);
	
	
	
	/**
	 * Holds Extension Manager settings (configuration set in Extension Manager)
	 *
	 * @var array
	 */
	protected $extConfSettings;
	
	
	/**
	 * Protected constructor for configuration builder.
	 * Use factory method instead
	 *
	 * @param array $settings
	 */
	public function __construct(array $settings=array()) {
		$this->settings = $settings;
		$this->extConfSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag']);
	}
	
	
	
	/**
	 * Returns an instance of crawler configuration
	 *
	 * @return Tx_Yag_Domain_Configuration_Import_CrawlerConfiguration
	 */
	public function buildCrawlerConfiguration() {
		return $this->buildConfigurationGeneric('crawler');
	}
	
	
	
	/**
	 * Returns an instance of image processor configuration
	 *
	 * @return Tx_Yag_Domain_Configuration_ImageProcessing_ProcessorConfiguration
	 */
	public function buildImageProcessorConfiguration() {
		return $this->buildConfigurationGeneric('imageProcessor');
	}
	
	
	
	/**
	 * Returns an instance of general configuration
	 *
	 * @return Tx_Yag_Domain_Configuration_General
	 */
	public function buildGeneralConfiguration() {
		return $this->buildConfigurationGeneric('general');
	}
	
	
	
	/**
	 * Returns an instance of album configuration
	 *
	 * @return Tx_Yag_Domain_Configuration_Album_AlbumConfiguration
	 */
	public function buildAlbumConfiguration() {
		return $this->buildConfigurationGeneric('album');
	}
}
?>