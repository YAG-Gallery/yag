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
 * Class for crawler configuration
 *
 * @package yag
 * @subpackage Domain\Configuration\Import
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Domain_Configuration_Import_CrawlerConfiguration {
	
	/**
	 * Holds an instance of configuration builder
	 *
	 * @var Tx_Yag_Domain_Configuration_Import_CrawlerConfiguration
	 */
	protected $configurationBuilder;
	
	
	
	/**
	 * Holds TS settings for file crawler configuration
	 *
	 * @var array
	 */
	protected $settings;
	
	
	
	/**
	 * Holds array of file types to be crawled by crawler
	 *
	 * @var array
	 */
	protected $fileTypes;
	
	
	

    /**
	 * Holds an array of file endings to be crawled
	 *
	 * @var array
	 */
	protected $fileFormatsToBeCrawled = array();
	
	
	
	/**
	 * Constructor for crawler configuration
	 *
	 * @param Tx_Yag_Domain_Configuration_Import_CrawlerConfiguration $configurationBuilder
	 */
	public function __construct(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		$this->configurationBuilder = $configurationBuilder; 
		$this->init();
	}
	
	
	
	/**
	 * Inits object
	 */
	protected function init() {
		$settings = $this->configurationBuilder->getCrawlerSettings();
		if (!array_key_exists('fileTypes',$settings)) throw new Exception('No fileTypes set in crawler configuration (Missing key "fileTypes") 1287241128');
		$this->fileTypes = $settings['fileTypes'];
	}
	
	
	
	/**
	 * Returns file types to be crawled for as regex pattern
	 *
	 * @return string
	 */
	public function getFileTypes() {
		return $this->fileTypes;
	}
	
}
 
?>