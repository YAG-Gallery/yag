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
 * Class implements hook for tx_cms_layout
 *
 * @package yag
 * @subpackage Hooks
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class user_Tx_Yag_Hooks_RealUrl extends tx_realurl implements t3lib_Singleton {

	
	protected $varSetConfig;
	
	
	public function __construct() {
		$this->initVarSetConfig(7);
	}
	
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param array $params
	 * @param tx_realurl $ref
	 */
	public function  encodeSpURL_postProc(&$params, &$ref) {
		list($URLdoneByRealUrl,$URLtodo) = explode('?', $params['URL']);
		
		if($URLtodo) {
			$GETparams = explode('&', $URLtodo);
			$cHash = array_pop($GETparams);
	
			foreach ($GETparams as $paramAndValue) {
				list($param, $value) = explode('=', $paramAndValue, 2);
				$param = rawurldecode($param);
				$additionalVariables[$param] = rawurldecode($value);	
			}
			 
			$urlDoneArray[] = 'yag';
			$varSetCfg = $this->getVarSetConfigForControllerAction($additionalVariables['tx_yag_pi1[controller]'], $additionalVariables['tx_yag_pi1[action]']);
			
			if(!is_array($varSetCfg)) {
				return; 
			}
			
			$ref->encodeSpURL_setSequence($varSetCfg, &$additionalVariables, &$urlDoneArray);
			$params['URL'] = $URLdoneByRealUrl . implode('/',$urlDoneArray). '?' . $cHash;
		}
	}
	
	
	
	public function decodeSpURL_preProc(&$params, &$ref) {
		$urlTodo = $params['URL'];
		list($path, $additionalParams) = explode('?', $urlTodo);
		$pathParts = explode('/', $path);
		
		$startKey = array_search('yag', $pathParts);
		
		if($startKey) {
			$myPathParts = array_slice($pathParts, ++$startKey);
			$realUrlPathParts = array_slice($pathParts, 0, --$startKey);
		} else {
			return; //nothing to do
		}		

		$varSetCfg = $this->getVarSetConfigForControllerAction($myPathParts[0], $myPathParts[1]);
		
		$GET_string = $ref->decodeSpURL_getSequence($myPathParts, $varSetCfg);
		if ($GET_string) {
			$GET_VARS = false;
			parse_str($GET_string, $GET_VARS);
			$ref->decodeSpURL_fixBrackets($GET_VARS);
			$ref->pObj->mergingWithGetVars($GET_VARS);
		}
				
		$params['URL'] = implode('/',$realUrlPathParts) . '/?' . $additionalParams;
	}
	
	
	
	public function initVarSetConfig($indexIdentifier) {
		
		$this->varSetConfig = array(
			 'Gallery-index' => array(
				array(
					'GETvar' => 'tx_yag_pi1[controller]',
				),
				array(
					'GETvar' => 'tx_yag_pi1[action]',
				),
				array(
					'GETvar' => 'tx_yag_pi1[context' . $indexIdentifier . '][galleryUid]',
					'lookUpTable' => array(
						'table' => 'tx_yag_domain_model_gallery',
						'id_field' => 'uid',
						'alias_field' => 'name',
						'addWhereClause' => ' AND deleted !=1 AND hidden !=1',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-',
						)
					)
				),
				array(
					'GETvar' => 'tx_yag_pi1[galleryList' . $indexIdentifier . '][pagerCollection][page]',
				)
			)	
		);
		
	}
	
	
	protected function getVarSetConfigForControllerAction($controller, $action) {
		
		$urlType = $controller . '-' . $action;

		switch($urlType) {
			case 'Gallery-index':
			return $this->varSetConfig[$urlType];
		}
	}
}
?>