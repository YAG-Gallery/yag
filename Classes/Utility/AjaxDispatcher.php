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

class Tx_Yag_Utility_AjaxDispatcher {
	
	
	/**
	 * Extbase Object Manager
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;
	
	
	protected $extensionName;
	
	protected $pluginName;
	
	protected $controllerName;
	
	protected $actionName;
	
	protected $arguments;
	
	
	public function dispatch() {
		$this->prepareCallArguments();
		
		$configuration['extensionName'] = $this->extensionName;
		$configuration['pluginName'] = $this->pluginName;
		
		
		$bootstrap = t3lib_div::makeInstance('Tx_Extbase_Core_Bootstrap');
		$bootstrap->initialize($configuration);
		
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		
		$request = $this->objectManager->get('Tx_Extbase_MVC_Web_Request'); /* @var $request Tx_Extbase_MVC_Request */
		$request->setControllerExtensionName($this->extensionName);
		$request->setPluginName($this->actionName);
		$request->setControllerName($this->controllerName);
		$request->setControllerActionName($this->actionName);
		
		$response = $this->objectManager->create('Tx_Extbase_MVC_Web_Response');
		
		$dispatcher =  $this->objectManager->get('Tx_Extbase_MVC_Dispatcher');
		$dispatcher->dispatch($request, $response);

		echo $response->getContent();
	
		die('DONE');
	}

	
	
	protected function prepareCallArguments() {
		$this->extensionName = 'Yag';
		$this->pluginName = 'pi1';
		$this->controllerName = 'Item';
		$this->actionName = 'showSingle';
		$this->arguments = array('item' => 1);
	}
	
	
	
	protected function getTyposcriptSettings($pid) {
		$typoScript = tx_pttools_div::returnTyposcriptSetup($pid, 'plugin.tx_yag.settings.');
		return $typoScript;
	}
	
	
	protected function determineCurrentPID() {
		$pid = (int) t3lib_div::_GP('PID');
		
		return $pid;
	}
	
	

	
}
?>