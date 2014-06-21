<?php
namespace YAG\Yag\Scheduler\Importer;

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
class DirectoryImporterTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {


	/**
	 * @var string
	 */
	protected $importDirectoryRoot;


	/**
	 * @var integer
	 */
	protected $storageSysFolder;


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
		// TODO: Implement execute() method.
	}

	/**
	 * @param string $importDirectoryRoot
	 */
	public function setImportDirectoryRoot($importDirectoryRoot) {
		$this->importDirectoryRoot = $importDirectoryRoot;
	}

	/**
	 * @return string
	 */
	public function getImportDirectoryRoot() {
		return $this->importDirectoryRoot;
	}

	/**
	 * @param int $storageSysFolder
	 */
	public function setStorageSysFolder($storageSysFolder) {
		$this->storageSysFolder = $storageSysFolder;
	}

	/**
	 * @return int
	 */
	public function getStorageSysFolder() {
		return $this->storageSysFolder;
	}

}