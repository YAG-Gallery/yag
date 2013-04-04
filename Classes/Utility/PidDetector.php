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
 * Pid detector class for getting storage PID informations.
 *
 * PID detector returns storage PIDs for records depending on environment.
 * Currently there are 3 different environments:
 *
 * 1. Frontend - We get PID settings from Content Element and from TypoScript / Flexform which are both merged into settings
 * 2. Backend
 * 2.1 Yag module - We get PID from currently selected page (sysfolder) / pid in page tree
 * 2.2 Content Element - User has selected PID in selector
 *
 * Furthermore, pid detector must be able to return PIDs of pages that user is enabled to see and
 * contains yag gallery items
 *
 * @package Utility
 * @author Michael Knoll
 */
class Tx_Yag_Utility_PidDetector implements t3lib_Singleton {

	/**
	 * Holds an array of pids if we are in manual mode
	 *
	 * @var array
	 */
	protected $pidsForManualMode = array();



	/**
	 * Holds instance of fe/be mode detector
	 *
	 * @var Tx_PtExtbase_Utility_FeBeModeDetector
	 */
	protected $feBeModeDetector;



	/**
	 * Define some constants to set mode of detector
	 */
	const FE_MODE 					= 'fe_mode';
	const BE_YAG_MODULE_MODE 		= 'be_yag_module_mode';
	const BE_CONTENT_ELEMENT_MODE 	= 'be_content_element_mode';
	const MANUAL_MODE 				= 'manual_mode';



	/**
	 * Holds array of allowed modes
	 *
	 * @var array
	 */
	protected static $allowedModes = array(self::FE_MODE, self::BE_CONTENT_ELEMENT_MODE, self::BE_YAG_MODULE_MODE, self::MANUAL_MODE);



	/**
	 * Holds mode for pid detector
	 *
	 * @var string
	 */
	protected $mode;



	/**
	 * Holds instance of extbase configuration manager
	 *
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 */
	protected $configurationManager;



	/**
	 * Constructor for pid detector.
	 *
	 * Creates new pid detector for given mode.
	 *
	 * @throws Exception If $mode is not allowed
	 * @param string $mode Set mode of pid detector
	 */
	public function __construct($mode = NULL) {
		if ($mode !== NULL) {
			if ($this->modeIsAllowed($mode)) {
				$this->mode = $mode;
			} else {
				throw new Exception('$mode is not allowed: ' . $mode, 1321464415);
			}
		} else {
			$this->mode = $this->getExtensionMode();
		}
	}



	/**
	 * Injects fe / be mode detector
	 *
	 * @param Tx_PtExtbase_Utility_FeBeModeDetector $feBeModeDetector
	 */
	public function injectFeBeModeDetector(Tx_PtExtbase_Utility_FeBeModeDetector $feBeModeDetector) {
		$this->feBeModeDetector = $feBeModeDetector;
	}



	/**
	 * Injects configuration manager
	 *
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
	}



	/**
	 * Initializes object if created with object manager
	 */
	public function initializeObject() {
		$this->mode = $this->getExtensionMode();
	}



	/**
	 * Returns pidDetector mode for current extension usage
	 *
	 * @return string
	 */
	public function getExtensionMode() {
		if (TYPO3_MODE === 'BE') {
			if (user_Tx_Yag_Utility_Flexform_RecordSelector::$flexFormMode) {
				// Record selector is activated => we are in flexform mode
				return Tx_Yag_Utility_PidDetector::BE_CONTENT_ELEMENT_MODE;
			} else {
				return Tx_Yag_Utility_PidDetector::BE_YAG_MODULE_MODE;
			}
		} elseif (TYPO3_MODE === 'FE') {
			return Tx_Yag_Utility_PidDetector::FE_MODE;
		}
	}



	/**
	 * Returns mode of pid detector
	 *
	 * @return string
	 */
	public function getMode() {
		return $this->mode;
	}



	/**
	 * Returns true, if mode is allowed
	 *
	 * @param bool $mode Mode to be checked
	 * @return bool True, if mode is allowed
	 */
	protected function modeIsAllowed($mode) {
		return in_array($mode, self::$allowedModes);
	}



	/**
	 * Returns array of pids that is used for storage pid.
	 *
	 * @return array
	 */
	public function getPids() {

		$pids = array();
		switch ($this->mode) {
			case self::FE_MODE :
				$pids = $this->getPidsInFeMode();
				break;

			case self::BE_CONTENT_ELEMENT_MODE :
				$pids = $this->getPidsInContentElementMode();
				break;

			case self::BE_YAG_MODULE_MODE :
				$pids = $this->getPidsInBeModuleMode();
				break;

			case self::MANUAL_MODE :
				$pids = $this->getPidsInManualMode();
				break;
		}


		return $pids;
	}



	/**
	 * Returns array of page records respecting pids
	 * that are currently accessible in mode and for user.
	 *
	 * @return array
	 */
	public function getPageRecords() {
		$allowedPIDsArray = $this->getPidsInContentElementMode();
		$allowedPIDs = is_array($allowedPIDsArray) && count($allowedPIDsArray) > 0 ? implode(',', $allowedPIDsArray) : '-1';

		$allowedPIDsWhereClauseString = 'uid IN (' . $allowedPIDs . ')';
		$pagesRows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'pages', 'module="yag" AND ' . $allowedPIDsWhereClauseString);

		return $pagesRows;
	}



	/**
	 * Setter for pids if we are in manual mode.
	 *
	 * @param $pidsArray Array of pids to be returned if we are in manual mode
	 */
	public function setPids($pidsArray) {
		$this->pidsForManualMode = $pidsArray;
	}



	/**
	 * @param string $mode
	 */
	public function setMode($mode) {
		$this->mode = $mode;
	}



	/**
	 * Returns true, if current site is yag page
	 * Only works in backend!
	 *
	 * @return boolean True, if current page is yag page
	 */
	public function getCurrentPageIsYagPage() {
		if ($this->mode != self::BE_YAG_MODULE_MODE) {
			throw new Exception(__METHOD__ . ' can only be called in BE mode! 1349310121');
		}
		$yagPageRecords = $this->getPageRecords();
		$pidsWithYagFlag = array();
		foreach ($yagPageRecords as $pageRecord) {
			$pidsWithYagFlag[] = $pageRecord['uid'];
		}
		$currentPid = t3lib_div::_GET('id');
		if (in_array($currentPid, $pidsWithYagFlag)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}



	/**
	 * Returns true, if current page is NO yag page.
	 * Only works in backend!
	 *
	 * @return bool True, if current page is NO yag page
	 */
	public function getCurrentPageIsNoYagPage() {
		return !($this->getCurrentPageIsYagPage());
	}



	/**
	 * Returns pids if we are in FE mode
	 *
	 * ATM pids in FE depend on selection in content element and
	 * hence only a single pid can be returned ATM. We still return
	 * an array of pids as this could probably change in the future,
	 * if we want to select multiple albums / galleries / images
	 * from several PIDs.
	 *
	 * @return array
	 */
	protected function getPidsInFeMode() {
        $settings = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$selectedPid = $settings['overwriteFlexForm']['context']['selectedPid'] ? $settings['overwriteFlexForm']['context']['selectedPid'] : (int) $settings['context']['selectedPid'];
		return $selectedPid ? array($selectedPid) : array(-1);
	}



	/**
	 * Returns an array of pids if we are in backend module.
	 *
	 * Although here only a single pid can be returned, we still
	 * return it in an array as we want to stay compatible with other
	 * calls of parent method where arrays of pids need to be returned.
	 *
	 * Basically we get PID of selected page in page tree if we open the
	 * yag backend module.
	 *
	 * @return array Array of page uids (pids)
	 * @throws Exception
	 */
	protected function getPidsInBeModuleMode() {

		/**
		 * Where do we get PIDs if we are in BE module mode?
		 *
		 * To enable BE module, we have to select a pid from page tree. This pid
		 * is available from GP vars. If we do not have GP var, something went wrong!
		 */
		$pageId = intval(t3lib_div::_GP('id'));
		if ($pageId > 0) {
			return array($pageId);
		} else {
			return array();

			// TODO is this useful?!?
			throw new Exception('Backend module of yag had been called without a page ID!', 1327105602);
		}

	}



	/**
	 * Returns array of pids that currently logged in BE user is allowed to see.
	 *
	 * @return array Array of uids of pages (pids)
	 */
	protected function getPidsInContentElementMode() {

		/**
		 * If we are in content element mode, we have to get all PIDs that currently logged in
		 * user is allowed to see.
		 */
		// TODO refactor me: put this method into utility class!
		// TODO no enable fields are respected here!
		$pagesRows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid', 'pages', 'module="yag" AND deleted = 0');

		$allowedPageUidsForUser = array();
		foreach ($pagesRows as $pageRow) {
			if ($GLOBALS['BE_USER']->isInWebMount($pageRow['uid'])) {
				$allowedPageUidsForUser[] = intval($pageRow['uid']);
			}
		}

		return $allowedPageUidsForUser;

	}



	/**
	 * Returns array of pids that are currently set in manual mode
	 *
	 * @return array
	 */
	protected function getPidsInManualMode() {
		return $this->pidsForManualMode;
	}

}
?>