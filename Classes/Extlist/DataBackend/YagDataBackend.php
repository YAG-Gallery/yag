<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
*  All rights reserved
*
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

class Tx_Yag_Extlist_DataBackend_YagDataBackend extends Tx_PtExtlist_Domain_DataBackend_ExtBaseDataBackend_ExtBaseDataBackend {
	
	/**
	 * @return Tx_PtExtlist_Domain_Model_List_ListData
	 */
	public function getPrePageListData() {
		$extbaseQuery = $this->buildExtBaseQuery();
		
		$originalOffset = $extbaseQuery->getOffset();

		if($originalOffset == NULL) {
			return new Tx_PtExtlist_Domain_Model_List_ListData();
		} else {
			$extbaseQuery->setOffset(0);
			$extbaseQuery->setLimit($originalOffset);

			$data = $extbaseQuery->execute();
			return $this->dataMapper->getMappedListData($data);
		}
	}


	/**
	 * @return Tx_PtExtlist_Domain_Model_List_ListData
	 */
	public function getPostPageListData() {
		$extbaseQuery = $this->buildExtBaseQuery();

		$originalOffset = $extbaseQuery->getOffset();
		$originalLimit = $extbaseQuery->getLimit();

		if($originalLimit !== NULL) { /* If itemsPerPage == 0, no post page data is necessary */
			$newOffset = $originalOffset + $originalLimit;

			$extbaseQuery->setLimit(1000000);
			//$extbaseQuery->unsetLimit();
			$extbaseQuery->setOffset($newOffset);

			$data = $extbaseQuery->execute();

			return $this->dataMapper->getMappedListData($data);

		} else {
			return array();
		}
	}
	
}

?>
