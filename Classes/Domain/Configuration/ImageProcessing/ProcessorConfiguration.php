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
 * Configuration for image processor
 *
 * @package yag
 * @subpackage Domain\Configuration
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Domain_Configuration_ImageProcessing_ProcessorConfiguration {
	
	/**
	 * Holds array of settings
	 *
	 * @var array
	 */
	protected $settings = array(); 
	
	
	
	/**
	 * Holds an instance of configuration builder
	 *
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder;
	
	
	
	/**
	 * Holds path for temporary storing image files
	 *
	 * @var string
	 */
	protected $tempPath;
	
	
	
	/**
	 * Constructor for image processor configuration
	 *
	 * @param unknown_type $settings
	 */
	public function __construct(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		$this->configurationBuilder = $configurationBuilder;
		$this->init();
	}
	
	
	
	/**
	 * Initializes properties
	 */
	protected function init() {
		$this->settings = $this->configurationBuilder->getImageProcessorSettings();
		if (!array_key_exists('tempPath', $this->settings) || $this->settings['tempPath'] == '') throw new Exception('Temp path is not set in image processor settings (imageProcessor.tempPath) 1287592937');
		$this->tempPath = $this->settings['tempPath'];
	}
	
	
	
	/**
	 * Returns temp path for image processing
	 *
	 * @return string
	 */
	public function getTempPath() {
		return $this->tempPath;
	}
}
 
 
 ?>