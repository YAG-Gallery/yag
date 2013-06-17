<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <lienert@punkt.de>, Michael Knoll <mimi@kaktsuteam.de>
*
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

/**
 * Type: Pre-list Renderer
 * 
 * Custom Renderer for calculating
 * 
 * @package Extlist
 * @subpackage Renderer\ImageRenderer
 * @author Daniel Lienert <lienert@punkt.de>
 */

class Tx_Yag_Extlist_Renderer_ImageListRenderer extends Tx_PtExtlist_Domain_Renderer_AbstractRenderer {
	
	/**
	 * Renders list data
	 *
	 * @param Tx_PtExtlist_Domain_Model_List_ListData $listData
	 * @return Tx_PtExtlist_Domain_Model_List_ListData
	 */
	public function renderList(Tx_PtExtlist_Domain_Model_List_ListData $listData) {
		$pageStartIndex = $this->getPageStartingIndex();

		foreach($listData as $rowIndex => $row) {
			$listData->getItemById($rowIndex)->addSpecialValue('absoluteRowIndex', $pageStartIndex + $rowIndex +1);
		}
		
		return $listData;
	}
	
	
	
	/**
	 * Get the starting index of the paged listData
	 * 
	 */
	protected function getPageStartingIndex() {
		$listIdentifier = $this->rendererConfiguration->getListIdentifier();
		$dataBackend = Tx_PtExtlist_Domain_DataBackend_DataBackendFactory::getInstanceByListIdentifier($listIdentifier);
		$pager = $dataBackend->getPagerCollection();
		
		$startIndex = $pager->getItemsPerPage() * ($pager->getCurrentPage()-1);
		return $startIndex;
	}
}
?>