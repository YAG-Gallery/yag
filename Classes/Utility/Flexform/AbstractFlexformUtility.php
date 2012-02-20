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
 * Provides some abstract methods
 *
 * @package Utility
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Utility_Flexform_AbstractFlexformUtility {
	
	Const EXTENSION_NAME = 'Yag'; 

	
	Const PLUGIN_NAME = 'web_YagTxYagM1';
	
	
	
	/**
	 * @var int current pid
	 */
	protected $currentPid;
	
	
	
	/**
	 * Fluid Renderer
	 * @var Tx_Fluid_View_TemplateView
	 */
	protected $fluidRenderer = NULL;
	
	
	
	/**
	 * set the current pid from config array
	 *
	 * @param null $pid
	 * @return int|null
	 */
	protected function determineCurrentPID($pid = NULL) {
		
		$pid = (int) t3lib_div::_GP('id');

		if($pid <= 0) {
			$pid = (int) t3lib_div::_GP('PID');	
		}
		
		if($pid <= 0 && (int) $pid > 0) {
			$pid = (int) $pid;
		}
		
		if($pid <= 0) {
			// UUUUhh, i hope we never come so far :)
			$returnUrlArray = explode('id=', t3lib_div::_GP('returnUrl'));
			$pid = (int) array_pop($returnUrlArray);
		}
		 
		$this->currentPid = $pid;
		
		return $pid;
	}
	
	
	
	/**
	 * Build A Fluid Renderer
	 * @return Tx_Fluid_View_TemplateView
	 */
	protected function getFluidRenderer() {
		if(!$this->fluidRenderer) {

			/* @var $request Tx_Extbase_MVC_Request */
			$request = $this->objectManager->get('Tx_Extbase_MVC_Request');
			$request->setControllerExtensionName(self::EXTENSION_NAME);
			$request->setPluginName(self::PLUGIN_NAME);
			
			$this->fluidRenderer = $this->objectManager->get('Tx_Fluid_View_TemplateView');
			$controllerContext = $this->objectManager->get('Tx_Extbase_MVC_Controller_ControllerContext');
			$controllerContext->setRequest($request);
			$this->fluidRenderer->setControllerContext($controllerContext);
			
			$this->fluidRenderer->assign('pid', $this->currentPid);
		}
		
		return $this->fluidRenderer;
	}
	
}
?>