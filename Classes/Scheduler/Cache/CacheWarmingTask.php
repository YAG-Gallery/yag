<?php

namespace YAG\Yag\Scheduler\Cache;

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
class CacheWarmingTask extends \YAG\Yag\Scheduler\AbstractTask {

	/**
	 * @var integer
	 */
	protected $typoScriptPageUid = 1;


	/**
	 * This is the main method that is called when a task is executed
	 * It MUST be implemented by all classes inheriting from this one
	 * Note that there is no error handling, errors and failures are expected
	 * to be handled and logged by the client implementations.
	 * Should return TRUE on successful execution, FALSE on error.
	 *
	 * @return boolean Returns TRUE on successful execution, FALSE on error
	 */
	public function execute() {


		return TRUE;
	}


	/**
	 *
	 * @return array
	 */
	protected function getConfiguration() {
		return array(
		);
	}


	/**
	 * @return string
	 */
	public function getAdditionalInformation() {
		return "Warm up the YAG image cache";
	}



	/**
	 * @param int $typoScriptPageUid
	 */
	public function setTypoScriptPageUid($typoScriptPageUid) {
		$this->typoScriptPageUid = $typoScriptPageUid;
	}



	/**
	 * @return int
	 */
	public function getTypoScriptPageUid() {
		return $this->typoScriptPageUid;
	}
}
?>