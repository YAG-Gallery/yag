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
 * 2.1 Yag module - We get PID from currently selected page / pid in page tree
 * 2.2 Content Element - User has selected PID in selector
 *     TODO The source selector needs to be extended by a column "PID / PAGE" on which pages are
 *     TODO displayed which contain yag gallery records and the user is allowed to see respecting
 *     TODO mount points / access rights
 *
 * Furthermore, pid detector must be able to return PIDs of pages that user is enabled to see and
 * contains yag gallery items
 *
 * @package Utility
 * @author Michael Knoll
 */
class Tx_Yag_Utility_PidDetector {

	/**
	 * Define some constants to set mode of detector
	 */
	const FE_MODE = 'fe_mode';
	const BE_YAG_MODULE_MODE = 'be_yag_module_mode';
	const BE_CONTENT_ELEMENT_MODE = 'be_content_element_mode';



	/**
	 * Holds mode for pid detector
	 *
	 * @var string
	 */
	protected $mode;



	/**
	 * Constructor for pid detector.
	 *
	 * Creates new pid detector for given mode.
	 *
	 * @throws Exception If $mode is not allowed
	 * @param string $mode Set mode of pid detector
	 */
	public function __construct($mode) {
		if (!$this->modeIsAllowed($mode)) {
			throw new Exception('$mode is not allowed: ' . $mode . ' 1321464415');
		}
		$this->mode = $mode;
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
		return in_array($mode, array(self::BE_CONTENT_ELEMENT_MODE, self::BE_YAG_MODULE_MODE, self::FE_MODE));
	}

}
?>