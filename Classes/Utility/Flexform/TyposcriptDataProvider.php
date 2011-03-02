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
 * Tx pt_tools div methods - used for loading TS
 * @package Utility
 */
require_once t3lib_extMgm::extPath('pt_tools').'res/staticlib/class.tx_pttools_div.php';



/**
 * Utilitty to get selectable options from typoscript
 *
 * @package Utility
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class user_Tx_Yag_Utility_Flexform_TyposcriptDataProvider {
	
	/**
	 * Current pid
	 * @var integer
	 */
	protected $currentPid;
	
	
	
	/**
	 * The YAG Typoscript part
	 * 
	 * @var array
	 */
	protected $yagTypoScript = NULL;
	
	
	
	/**
	 * Get a List of defined extList listconfigs
	 * 
	 * @param array $config
	 * @return array $config
	 */
	public function getDefinedThemes(array $config) {
		$this->initTsDataProvider($config);
		$config['items'] = array_merge($config['items'],$this->getTypoScriptKeyList('settings.themes'));
		return $config;
	}

	
	
	/**
	 * Init the DataProvider
	 * 
	 * @param array $config
	 */
	protected function initTsDataProvider($config) {
		$this->currentPid =  $this->getCurrentPID($config);
		$this->loadYagTyposcriptArray();
	}
	
	
	
	/**
	 * set the current pid from config array
	 * 
	 * @param array $config
	 */
	protected function getCurrentPID($config) {
		$pid = (int) $config['row']['pid'];
		if(!$pid) {
			$pid = t3lib_div::_GP('id');
		}
		
		return $pid;
	}
	
	
	/**
	 * Load the complete extlist part from typoscript
	 */
	protected function loadYagTyposcriptArray() {
		if(is_null($this->yagTypoScript)) {
			$extListTS = tx_pttools_div::typoscriptRegistry('plugin.tx_yag.', $this->currentPid);
			$this->yagTypoScript =  Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($extListTS);
		}
	}
	
	
	/**
	 * Return a list of typoscript keys beneath the current path
	 * 
	 * @param unknown_type $typoScriptPath
	 */
	protected function getTypoScriptKeyList($typoScriptPath) {
		
		$keyList = array();
		$tsArray = $this->getTSArrayByPath($typoScriptPath);
		
		ksort($tsArray);
		
		foreach($tsArray as $key => $valueArray) {
			$label = $key;
			$label[0] = strtoupper($label[0]);
			$keyList[] = array($label, $key);
		}

		return $keyList;
	}
	
	
	/**
	 * return a typoscript array by given typoscript path
	 * 
	 * @param string $typoScriptPath
	 * @return array 
	 */
	protected function getTSArrayByPath($typoScriptPath) {
		$pathArray = explode('.', $typoScriptPath);
		$outTSArray = Tx_Extbase_Utility_Arrays::getValueByPath($this->yagTypoScript, $pathArray);
		
		if(!is_array($outTSArray)) $outTSArray = array();
		
		return $outTSArray;
	}
	
}
?>