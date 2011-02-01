<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*            
*           
*  All rights reserved
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
 * Class implements a viewhelper for inline javascript 
 *
 * @author Daniel Lienert <daniel@lienert.cc>
 * @package ViewHelpers
 * @subpackage Javascript
 */
class Tx_Yag_ViewHelpers_Javascript_TemplateViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	* @var t3lib_PageRenderer
	*/
	protected $pageRenderer;
	
	
	public function initialize() {
         if (TYPO3_MODE === 'BE') {
         	$this->initializeBackendRenderer();
         } else {
         	$this->initializeFrontendRenderer();
         }
	}
	
	
	
	protected function initializeBackendRenderer() {
		
		if (!isset($GLOBALS['SOBE']->doc)) {
			 $GLOBALS['SOBE']->doc = t3lib_div::makeInstance('template');
			 $GLOBALS['SOBE']->doc->backPath = $GLOBALS['BACK_PATH'];
		}
		
		$this->pageRenderer = $GLOBALS['SOBE']->doc->getPageRenderer();
	}
	
	

	protected function initializeFrontendRenderer() {
		$GLOBALS['TSFE']->backPath = TYPO3_mainDir;
		$this->pageRenderer = $GLOBALS['TSFE']->getPageRenderer();
	}	
	
	
	
	/**
	 * View helper for showing debug information for a given object
	 *
	 * @param string templatePath
	 * @param array $arguments 
	 * 
	 * @return string
	 */
	public function render($templatePath, $arguments = '') {
		$absoluteFileName = $this->makeTemplatePathAbsolute($templatePath);
		
		if(!file_exists($absoluteFileName)) throw new Exception('No JSTemplate found with path ' . $absoluteFileName . '. 1296554335');
		
		$this->pageRenderer->addJsInlineCode($templatePath, $this->substituteMarkers($this->loadJsCodeFromFile($absoluteFileName), $arguments));
	}
	
	
	
	protected function makeTemplatePathAbsolute($templatePath) {
		$extKey = $this->controllerContext->getRequest()->getControllerExtensionKey();
		$extPath = t3lib_extMgm::extPath($extKey);
        $filePath = $extPath . $templatePath;
		return $filePath;
	}
	
	
	
	protected function loadJsCodeFromFile($absoluteFileName) {
		return file_get_contents($absoluteFileName);
	}
	
	
	
	protected function substituteMarkers(&$jsCode, $arguments) {
		$markers = $this->prepareMarkers($arguments);
		return str_replace(array_keys($markers), array_values($markers), $jsCode);
	}
	
	
	
	protected function prepareMarkers($arguments) {
		
		$markers = array();
		
		foreach($arguments as $key => $value) {
			$markers['###' . $key . '###'] = $value;
		}
		
		return $markers;
	}
	
}
?>