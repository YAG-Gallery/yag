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
	 * Add a defined javascript library
	 * 
	 * @param unknown_type $jsLibName
	 */
	public function addDefinedLibJSFiles($libName) {
		$feLibConfig = $this->configurationBuilder->buildFrontendLibConfiguration()->getFrontendLibConfig($libName);
		if($feLibConfig->getInclude()) {
			foreach($feLibConfig->getJSFiles() as $jsFileIdentifier => $jsFilePath) {
				$this->addJSFile(t3lib_div::getFileAbsFileName($jsFilePath));
			}
		}
	}
	
	
	
	public function addDefinedLibCSS() {
		
	}
	
	
	public function addCSSFile() {
		
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
		$this->pageRenderer->addJSFile($file, $type, $compress, $forceOnTop, $allWrap);
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
}
?>