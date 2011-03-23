<?php
/***************************************************************
* Copyright notice
*
*   2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
* All rights reserved
*
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* Utility to include defined frontend libraries as jQuery and related CSS
*  
*
* @package Utility
* @author Daniel Lienert <daniel@lienert.cc>
*/

class Tx_Yag_Utility_HeaderInclusion implements t3lib_Singleton {
	
	/**
	* @var t3lib_PageRenderer
	*/
	protected $pageRenderer;
	
	
	/**
	* @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	*/
	protected $configurationBuilder;
	
	
	/**
	 * Initialize the object (called by objectManager)
	 * 
	 */
	public function initializeObject() {
		
		$this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance();
		
		if (TYPO3_MODE === 'BE') {
         	$this->initializeBackend();
         } else {
         	$this->initializeFrontend();
         }
	}
	
	
	
	/**
	 * Add a defined frontend library
	 * 
	 * @param string $jsLibName
	 */
	public function addDefinedLibJSFiles($libName) {
		$feLibConfig = $this->configurationBuilder->buildFrontendLibConfiguration()->getFrontendLibConfig($libName);
		if($feLibConfig->getInclude()) {
			foreach($feLibConfig->getJSFiles() as $jsFileIdentifier => $jsFilePath) {
				$this->addJSFile($this->getFileRelFileName($jsFilePath));
			}
		}
	}
	
	
	
	/**
	 * Add the CSS of a defined library
	 * 
	 * @param string $libName
	 */
	public function addDefinedLibCSS($libName) {
		$feLibConfig = $this->configurationBuilder->buildFrontendLibConfiguration()->getFrontendLibConfig($libName);
		if($feLibConfig->getInclude()) {
			foreach($feLibConfig->getCSSFiles() as $cssFileIdentifier => $cssFilePath) {
				$this->addCSSFile($this->getFileRelFileName($cssFilePath));
			}
		}
	}
	
	
	
	/**
	 * Adds CSS file
	 *
	 * @param string $file
	 * @param string $rel
	 * @param string $media
	 * @param string $title
	 * @param boolean $compress
	 * @param boolean $forceOnTop
	 * @return void
	 */
	public function addCSSFile($file, $rel = 'stylesheet', $media = 'all', $title = '', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '') {
		$this->pageRenderer->addCSSFile($this->getFileRelFileName($file), $rel, $media, $title, $compress, $forceOnTop , $allWrap);
	}
	
	
	
	/**
	 * Add a JS File to the header
	 * 
	 * @param string $file
	 * @param string $type
	 * @param boolean $compress
	 * @param boolean $forceOnTop
	 * @param string $allWrap
	 * @return void
	 */
	public function addJSFile($file, $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '') {
		$this->pageRenderer->addJSFile($this->getFileRelFileName($file), $type, $compress, $forceOnTop, $allWrap);
	}
	
	
	
	public function addCssInlineCode() {
		
	}
	
	
	
	/**
	 * Add JS inline code
	 *
	 * @param string $name
	 * @param string $block
	 * @param boolean $compress
	 * @param boolean $forceOnTop
	 */
	public function addJSInlineCode($name, $block, $compress = TRUE, $forceOnTop = FALSE) {
		$this->pageRenderer->addJsInlineCode($name, $block, $compress, $forceOnTop);
	}
	
	
	
	/**
	 * Initialize Backend specific variables
	 */
	protected function initializeBackend() {
		
		if (!isset($GLOBALS['SOBE']->doc)) {
			 $GLOBALS['SOBE']->doc = t3lib_div::makeInstance('template');
			 $GLOBALS['SOBE']->doc->backPath = $GLOBALS['BACK_PATH'];
		}
		
		$this->pageRenderer = $GLOBALS['SOBE']->doc->getPageRenderer();
		
		$this->relExtPath = '../' . $this->relExtPath;
	}
	
	
	
	/**
	 * Initialize Frontend specific variables
	 */
	protected function initializeFrontend() {
		$GLOBALS['TSFE']->backPath = TYPO3_mainDir;
		$this->pageRenderer = $GLOBALS['TSFE']->getPageRenderer();
	}
	
	/**
	 * Expand the EXT to a relative path
	 * TODO: replace with T3 Method if dound
	 * 
	 * @param unknown_type $filename
	 */
	protected function getFileRelFileName($filename) {
		if (substr($filename, 0, 4) == 'EXT:') { // extension
			list($extKey, $local) = explode('/', substr($filename, 4), 2);
			$filename = '';
			if (strcmp($extKey, '') && t3lib_extMgm::isLoaded($extKey) && strcmp($local, '')) {
				$filename = t3lib_extMgm::extRelPath($extKey) . $local;
			}
		}
		return $filename;
	}
	
	
	/**
	 * Add theme defined CSS / JS to the header
	 */
	public function includeThemeDefinedHeader() {

		// add JS files from a defined library to the header 
		$headerJSLibs = $this->configurationBuilder->buildThemeConfiguration()->getJSLibraries();
		foreach($headerJSLibs as $library) {
			$this->addDefinedLibJSFiles($library);
		}
		
		// add CSS files from a defined library to the header
		$headerLibCSS = $this->configurationBuilder->buildThemeConfiguration()->getCSSLibraries();
		foreach($headerLibCSS as $library) {
			$this->addDefinedLibCSS($library);
		}
		
		
		// Add CSS files to the header
		$headerCSSFiles = $this->configurationBuilder->buildThemeConfiguration()->getCSSFiles(); 
		foreach($headerCSSFiles as $fileIdentifier => $filePath) {
			$this->addCSSFile($filePath);
		} 
		
		// Add JS files to the header
		$headerJSFiles = $this->configurationBuilder->buildThemeConfiguration()->getJSFiles();
		foreach($headerJSFiles as $fileIdentifier => $filePath) {
			$this->addJSFile($filePath);
		}
	}
	
}
?>