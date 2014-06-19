<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Daniel Lienert <daniel@lienert.cc>
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
 * YAG Scheduler Task
 *
 * @package YAG
 * @subpackage Scheduler
 */
class Tx_Yag_Scheduler_Cache_CacheWarmingTask extends tx_scheduler_Task {

	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;



	/**
	 * @return boolean Returns TRUE on successful execution, FALSE on error
	 */
	public function execute() {
		$this->initializeExtbase();
		$this->initializeObject();



		return FALSE;
	}

	/**
	 * Initialize Extbase
	 *
	 * This is necessary to resolve the TypoScript interface definitions
	 */
	protected function initializeExtbase() {
		$configuration['extensionName'] = 'Yag';
		$configuration['pluginName'] = 'dummy';
		$extbaseBootstrap = t3lib_div::makeInstance('Tx_Extbase_Core_Bootstrap'); /** @var Tx_Extbase_Core_Bootstrap $extbaseBootstrap  */
		$extbaseBootstrap->initialize($configuration);

	}

	/**
	 * @return void
	 */
	public function initializeObject() {
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
	}

	/**
	 *
	 * @return array
	 */
	protected function getConfiguration() {
		return array(
			'liveMode' => $this->tx_ptdpppzca_mode,
			'prefix' => $this->tx_ptdpppzca_prefix
		);
	}


	/**
	 * @return string
	 */
	public function getAdditionalInformation() {
		return "Warm up the YAG image cache";
	}

}
?>