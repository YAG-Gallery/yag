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
 * We overwrite Persistence Backend for respecting our own PIDs when storing new objects
 *
 * Configuration for replacing original backend is given in TypoScript:
 *
 * config.tx_extbase.objects.Tx_Extbase_Persistence_Storage_BackendInterface.className = Tx_Yag_Extbase_Persistence_Backend
 *
 * @package Extbase
 * @subpackage Persistence
 * @author Michael Knoll
 */
class Tx_Yag_Extbase_Persistence_Backend extends Tx_Extbase_Persistence_Backend {

	/**
	 * Holds instance of pid detector
	 *
	 * @var Tx_Yag_Utility_PidDetector
	 */
	protected $pidDetector;



	/**
	 * Injects pid detector
	 *
	 * @param Tx_Yag_Utility_PidDetector $pidDetector
	 */
	public function injectPidDetector(Tx_Yag_Utility_PidDetector $pidDetector) {
		$this->pidDetector = $pidDetector;
	}



	/**
	 * Determine the storage page ID for a given NEW record
	 *
	 * This does the following:
	 * - If there is a TypoScript configuration "classes.CLASSNAME.newRecordStoragePid", that is used to store new records.
	 * - If there is no such TypoScript configuration, it uses the first value of The "storagePid" taken for reading records.
	 *
	 * @param Tx_Extbase_DomainObject_DomainObjectInterface $object
	 * @return int the storage Page ID where the object should be stored
	 */
	protected function determineStoragePageIdForNewRecord(Tx_Extbase_DomainObject_DomainObjectInterface $object = NULL) {
		$pids = NULL;

		/**
		 * What happens here?
		 *
		 * We globally overwrite implementation of backend class (this class).
		 * This means that all other Extbase plugins that are probably inserted on the
		 * same page would also use this backend class.
		 *
		 * So we give the yag domain models an interface which we check here and use
		 * pid detection only, if we get a new objecte that implements this interface.
		 * All other objects will be handled the default way.
		 */
		if (is_a($object, 'Tx_Yag_Domain_Model_DomainModelInterface')) {
			$pids = $this->pidDetector->getPids();
		}

		if (!empty($pids) && count($pids) > 0) {
			return $pids[0] == -1 ? 0 : $pids[0];
		} else {
			return parent::determineStoragePageIdForNewRecord($object);
		}
	}
    
}
?>