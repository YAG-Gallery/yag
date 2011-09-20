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
 * Class implements hook for tx_realurl
 *
 * @package Hooks
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class user_Tx_Yag_Hooks_RealUrl extends tx_realurl implements t3lib_Singleton {

	
	/**
	 * @var array
	 */
	protected $varSetConfig;
	
	
	/**
	 * @var string
	 */
	protected $currentContextIdentifier;


	/**
	 * Init the hook for a every contentElement
	 */
	protected function init() {
		if(!class_exists('Tx_Yag_Domain_Context_YagContextFactory')) throw new Exception('We are not in yag context 1302280230');
		
		if($this->currentContextIdentifier != Tx_Yag_Domain_Context_YagContextFactory::getInstance()->getIdentifier()) {
			$this->currentContextIdentifier = Tx_Yag_Domain_Context_YagContextFactory::getInstance()->getIdentifier();
			$this->initVarSetConfig($this->currentContextIdentifier);
		}
	}
	
	
	
	/**
	 * Hook for realurl.
	 * Encondes everything that realurl left over
	 * 
	 * @param array $params
	 * @param tx_realurl $ref
	 */
	public function encodeSpURL_postProc(&$params, &$ref) {
		
		try {
			$this->init();
		} catch (Exception $e) {
			return;
		}
		
		list($URLdoneByRealUrl,$URLtodo) = explode('?', $params['URL']);

		if($URLtodo) {
			$GETparams = explode('&', $URLtodo);
			
			
			foreach ($GETparams as $paramAndValue) {
				list($param, $value) = explode('=', $paramAndValue, 2);
				$param = rawurldecode($param);
				$additionalVariables[$param] = rawurldecode($value);	
			}
			
			$additionalVariables['tx_yag_pi1[contextIdentifier]'] = $this->currentContextIdentifier;
			
			$urlDoneArray[] = 'yag';
			$varSetCfg = $this->getVarSetConfigForControllerAction($additionalVariables['tx_yag_pi1[controller]'], $additionalVariables['tx_yag_pi1[action]']);
			
			if(!is_array($varSetCfg)) {
				return; 
			}
			
			$ref->encodeSpURL_setSequence($varSetCfg, $additionalVariables, $urlDoneArray);
			$urlDoneArray = $ref->cleanUpPathParts($urlDoneArray);
			$params['URL'] = $this->combineEncodedURL($ref, $URLdoneByRealUrl, $urlDoneArray, $additionalVariables);
		}
	}
	
	
	
	/**
	 * Combine the url parts and handle the unencoded values
	 * 
	 * @param tx_realurl $ref
	 * @param string $URLdoneByRealUrl
	 * @param array $urlDoneArray
	 * @param array $unencodedValues
	 */
	protected function combineEncodedURL($ref, $URLdoneByRealUrl, $urlDoneArray = array(), $unencodedValues = array()) {
		
		$combinedURL = $URLdoneByRealUrl;
		
		if(count($urlDoneArray)) {
			$combinedURL .= implode('/',$urlDoneArray);
		}
		
		$ref->encodeSpURL_cHashCache($combinedURL, $unencodedValues);
		
		if (count($unencodedValues)) {
			$unencodedArray = array();
			foreach ($unencodedValues as $key => $value) {
				$unencodedArray[] = $this->rawurlencodeParam($key) . '=' . rawurlencode($value);
			}
			$combinedURL .= '?' . implode('&', $unencodedArray);
		}
		
		
		return $combinedURL;
	}
	
	
	
	
	/**
	 * Decode everything starting with 'yag' and pass the rest back to realurl 
	 * 
	 * @param array $params
	 * @param ty_realurl $ref
	 */
	public function decodeSpURL_preProc(&$params, &$ref) {
		$urlTodo = $params['URL'];
		
		$cHash = $ref->decodeSpURL_cHashCache($urlTodo);
		
		list($path, $additionalParams) = explode('?', $urlTodo);
		$pathParts = explode('/', $path);
		$startKey = array_search('yag', $pathParts);
		
		if($startKey) {
			$myPathParts = array_slice($pathParts, ++$startKey);
			$realUrlPathParts = array_slice($pathParts, 0, --$startKey);
		} else {
			return; //nothing to do
		}		

		
		/*
		 * The first 3 pathParts are standard:
		 * 0: contextIdentifier
		 * 1: controller
		 * 2: action 
		 */
		$this->initVarSetConfig($myPathParts[0]);
		$varSetCfg = $this->getVarSetConfigForControllerAction($myPathParts[1], $myPathParts[2]);
		
		$GET_string = $this->combineDecodedURL($ref->decodeSpURL_getSequence($myPathParts, $varSetCfg), $cHash, $additionalParams);
		if ($GET_string) {
			$GET_VARS = false;
			parse_str($GET_string, $GET_VARS);
			$ref->decodeSpURL_fixBrackets($GET_VARS);
			$ref->pObj->mergingWithGetVars($GET_VARS);
		}
				
		 $params['URL'] = implode('/',$realUrlPathParts) .'/';
	}
	
	
	
	/**
	 * @param string $decodedURL
	 * @param string $cHash
	 * @param string $additionalParams
	 * @return string combined url
	 */
	public function combineDecodedURL($decodedURL, $cHash, $additionalParams) {
		
		$returnURL = $decodedURL;
		
		if($cHash) $cHash = 'cHash=' . $cHash;
		$allParts = array_filter(array($decodedURL, $additionalParams, $cHash));
		$returnURL = implode('&',$allParts);
		
		return $returnURL;
	}
	
	
	
	/**
	 * Prepare the post var sets dynamically
	 * 
	 * @param string $indexIdentifier
	 */
	public function initVarSetConfig($indexIdentifier) {
		$this->varSetConfig = array(
			
			'Gallery-list' => array(
				array(
					'GETvar' => 'tx_yag_pi1[contextIdentifier]',
				),
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
				),
			),
			
		
			 'Gallery-index' => array(
				array(
					'GETvar' => 'tx_yag_pi1[contextIdentifier]',
				),
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
					'GETvar' => 'tx_yag_pi1[albumList' . $indexIdentifier . '][pagerCollection][page]',
				),
				array(
					'GETvar' => 'tx_yag_pi1[itemList' . $indexIdentifier . '][pagerCollection][page]',
					'noMatch' => 'null'
				),
				array(
					'GETvar' => 'tx_yag_pi1[context' . $indexIdentifier . '][albumUid]',
					'noMatch' => 'null'
				),
			),
			
			
			
			'ItemList-list' => array(
				array(
					'GETvar' => 'tx_yag_pi1[contextIdentifier]',
				),
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
					'GETvar' => 'tx_yag_pi1[context' . $indexIdentifier . '][albumUid]',
					'lookUpTable' => array(
						'table' => 'tx_yag_domain_model_album',
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
					'GETvar' => 'tx_yag_pi1[itemList' . $indexIdentifier . '][pagerCollection][page]',
				),
			),

			
			
			'Item-show' => array(
				array(
					'GETvar' => 'tx_yag_pi1[contextIdentifier]',
				),
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
					'GETvar' => 'tx_yag_pi1[context' . $indexIdentifier . '][albumUid]',
					'lookUpTable' => array(
						'table' => 'tx_yag_domain_model_album',
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
					'GETvar' => 'tx_yag_pi1[itemListOffset]',
				),
				array(
					'GETvar' => 'tx_yag_pi1[itemList' . $indexIdentifier . '][pagerCollection][page]',
					'noMatch' => 'null'
				),
			)
		);
		
		$this->varSetConfig['ItemList-submitFilter'] = $this->varSetConfig['ItemList-list'];
		
	}
	
	
	/**
	 * Select the correct varSetConfig by controller and action
	 * 
	 * @param string $controller
	 * @param string $action
	 */
	protected function getVarSetConfigForControllerAction($controller, $action) {
		$urlType = $controller . '-' . $action;
		return $this->varSetConfig[$urlType];
	}
}
?>