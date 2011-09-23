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
 * Repository for Tx_Yag_Domain_Model_Extern_TTContent
 *
 * @package Domain
 * @subpackage Repository
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Repository_Extern_TTContentRepository extends Tx_Extbase_Persistence_Repository {
	
	protected $yagInstanceIdentifier = 'yag_pi1';
	
	/*
	 * Create and alter the query object
	 * @return Tx_Extbase_Persistence_QueryInterface
	 */
	public function createQuery() {
		$query = parent::createQuery();
		$query->getQuerySettings()->setRespectSysLanguage(FALSE);
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		return $query;
	}
	
	
	/**
	 * @return Tx_Extbase_Persistence_QueryResult
	 */
	public function findAllYAGInstances() {
		$query = $this->createQuery();
		$result = $query->matching($query->equals('list_type', $this->yagInstanceIdentifier))
				->execute();
				
		return $result;
	}
	
	
	
	/**
	 * Count all yag instances
	 * 
	 * @return int count
	 */
	public function countAllYagInstances() {
		$query = $this->createQuery();
		return $query->matching($query->equals('list_type', $this->yagInstanceIdentifier))->count();
	}
}
?>