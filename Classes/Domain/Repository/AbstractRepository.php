<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
*           Daniel Lienert <daniel@lienert.cc>
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
 * Abstract repository, updates pageCacheManager for automatic cache clearing
 *
 * @package Domain
 * @subpackage Repository
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Repository_AbstractRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * If set to true, pid detected by pid detector is used for storage
	 *
	 * Set this to FALSE in your repository to disable pid detector!
	 *
	 * @var bool
	 */
	protected $respectPidDetector = TRUE;



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
	 * Initialize repository
	 *
	 * (automatically called when using objectManager!)
	 */
	public function initializeObject() {
		$this->initPidDetector();
	}



	/**
	 * Initializes PID detector
	 */
	protected function initPidDetector() {

		if ($this->respectPidDetector) {
			$PIDs = $this->pidDetector->getPids();

			if(!$PIDs) {
				// throw new Exception('It was not possible to determine any page IDs to get records from. Please configure your plugin correctly.', 1331382978);
			}

			if ($this->defaultQuerySettings === NULL) {
				$this->defaultQuerySettings = $this->objectManager->get('Tx_Extbase_Persistence_Typo3QuerySettings');
			}

			$this->defaultQuerySettings->setRespectStoragePage(TRUE);
			$this->defaultQuerySettings->setStoragePageIds($PIDs);
		}
	}


	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Persistence/Tx_Extbase_Persistence_Repository::add()
	 */
	public function add($object) {
		parent::add($object);
		$this->objectManager->get('Tx_Yag_PageCache_PageCacheManager')->markObjectUpdated($object);
	}
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Persistence/Tx_Extbase_Persistence_Repository::remove()
	 */
	public function remove($object) {
		parent::remove($object);
		$this->objectManager->get('Tx_Yag_PageCache_PageCacheManager')->markObjectUpdated($object);
	}
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Persistence/Tx_Extbase_Persistence_Repository::update()
	 */
	public function update($modifiedObject) {

		parent::update($modifiedObject);
		$this->objectManager->get('Tx_Yag_PageCache_PageCacheManager')->markObjectUpdated($modifiedObject);
	}



	/**
	 * Build and return whereclause part with TYPO3 enablefields criterias
	 * for all tables which are defined in backendConfig.tables and in TCA
	 *
	 * @param array $typo3Tables
	 * @return string whereclause part with TYPO3 enablefields criterias
	 */
	protected function getTypo3SpecialFieldsWhereClause(array $typo3Tables) {
		$specialFieldsWhereClause = '';

		foreach($typo3Tables as $typo3Table) {
			if (is_array($GLOBALS['TCA'][$typo3Table])) {
				$specialFieldsWhereClause .= Tx_PtExtbase_Div::getCobj()->enableFields($typo3Table);
			}
		}

		return $specialFieldsWhereClause;
	}
	
}
?>
