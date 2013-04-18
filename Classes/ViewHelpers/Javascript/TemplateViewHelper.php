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
 * 
 * Aviable generic markers:
 
 * extPath: relative path to the extension
 * extKey: Extension Key
 * pluginNamespace: Plugin Namespace for GET/POST parameters
 */
class Tx_Yag_ViewHelpers_Javascript_TemplateViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Relative extpath to the extension (eg typo3conf/ext/yag/)
	 * 
	 * @var string
	 */
	protected $relExtPath;
	
	
	/**
	 * Asbolute ExtPath
	 * 
	 * @var String
	 */
	protected $extPath;
	
	
	/**
	 * 
	 * @var string extKey
	 */
	protected $extKey;




	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('type', 'string', 'Specifies the content type', FALSE, 'text/javascript');
	}


	/**
	 * 
	 * Initialize ViewHelper
	 */
	public function initialize() {

		$this->extKey = $this->controllerContext->getRequest()->getControllerExtensionKey();
		$this->extPath = t3lib_extMgm::extPath($this->extKey);
		$this->relExtPath = t3lib_extMgm::siteRelPath($this->extKey);
		
		
		if (TYPO3_MODE === 'BE') {
         	$this->initializeBackend();
         } else {
         	$this->initializeFrontend();
         }
        
	}
	
	
	
	/**
	 * Initialize Backend specific variables
	 */
	protected function initializeBackend() {
		$this->relExtPath = '../' . $this->relExtPath;
	}
	
	
	/**
	 * Initialize Frontend specific variables
	 */
	protected function initializeFrontend() {
	}	
	
	
	
	/**
	 * View helper for showing debug information for a given object
	 *
	 * @param string templatePath
	 * @param array $arguments
	 * @param string $position Set the position. Possible are current, header, footer
	 *
	 * @return string
	 * @throws Exception
	 */
	public function render($templatePath, $arguments = array(), $position = 'current' ) {
		
		$absoluteFileName = t3lib_div::getFileAbsFileName($templatePath);
		$this->addGenericArguments($arguments);

		if(!file_exists($absoluteFileName)) throw new Exception('No JSTemplate found with path ' . $absoluteFileName, 1296554335);
		
		if($position === 'current') {
			$jsOutput = '<script type="'.$this->arguments['type']."\">\n";
			$jsOutput .= $this->substituteMarkers($this->loadJsCodeFromFile($absoluteFileName), $arguments);
			$jsOutput .= "\n</script>\n";

			return $jsOutput;

		} else {
			t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')
				->get('Tx_Yag_Utility_HeaderInclusion')
				->addJsInlineCode(basename($templatePath), $this->substituteMarkers($this->loadJsCodeFromFile($absoluteFileName), $arguments), TRUE, FALSE, $position);
		}
	}
	
	
	
	/**
	 * Add some generic arguments that might be usefull
	 * 
	 * @param array $arguments
	 */
	protected function addGenericArguments(&$arguments) {
		$arguments['veriCode'] = $this->generateVeriCode();
		$arguments['extPath'] = $this->relExtPath;
		$arguments['extKey'] = $this->extKey;

		$extensionService = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')->get('Tx_Extbase_Service_ExtensionService'); /** @var $extensionService Tx_Extbase_Service_ExtensionService */

		$arguments['pluginNamespace'] = $extensionService->getPluginNamespace($this->controllerContext->getRequest()->getControllerExtensionName(),
																						$this->controllerContext->getRequest()->getPluginName());
	}
	
	
	
	/**
	 * Generates a veri code for session (see t3lib_userauth)
	 *
	 * @return string
	 */
	protected function generateVeriCode() {
	   $sessionId = NULL;
       if (TYPO3_MODE === 'BE') {
            global $BE_USER;
            $sessionId = $BE_USER->id;
        } else {
            $sessionId = $GLOBALS['TSFE']->fe_user->id;
        }
        return substr(md5($sessionId . $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']), 0, 10);
	}
	
	
	
	/**
	 * @param string $absoluteFileName
	 * @return string JsCodeTemplate
	 * @throws Exception
	 */
	protected function loadJsCodeFromFile($absoluteFileName) {
		$data = file_get_contents($absoluteFileName);
		
		if($data === FALSE) {
			throw new Exception('Could not read the file content of file ' . $absoluteFileName . '!', 1300865874);
		}
		
		return $data;
	}


	/**
	 * Substitute Markers in Code
	 *
	 * @param $jsCode
	 * @param $arguments
	 * @return mixed
	 */
	protected function substituteMarkers(&$jsCode, $arguments) {
		$markers = $this->prepareMarkers($arguments);
		$this->addTranslationMarkers($jsCode, $markers);
		return str_replace(array_keys($markers), array_values($markers), $jsCode);
	}


	/**
	 * Find LLL markers in the jsCode and arguments for them
	 *
	 * @param $jsCode
	 * @param $markers
	 */
	protected function addTranslationMarkers(&$jsCode, &$markers) {
		$matches = array();
		$pattern = '/\#\#\#LLL:.*\#\#\#/';
		preg_match_all($pattern, $jsCode ,$matches);
		foreach($matches[0] as $match) {
			$translateKey = substr($match,7,-3);
			$translation = Tx_Extbase_Utility_Localization::translate($translateKey, $this->extKey);
			$translation = $translation ? $translation : $translateKey;
			$markers[$match] = $translation;
		}
	}
	
	
	
	/**
	 * Prepare the markers
	 * 
	 * @param array $arguments
	 * @return array
	 */
	protected function prepareMarkers($arguments) {
		
		$markers = array();
		
		foreach($arguments as $key => $value) {
			$markers['###' . $key . '###'] = $value;
		}
		
		return $markers;
	}
	
}
?>