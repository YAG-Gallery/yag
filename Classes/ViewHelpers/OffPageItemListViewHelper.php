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

/**
 * Class provides image viewHelper
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 * @package ViewHelpers
 */
class Tx_Yag_ViewHelpers_OffPageItemListViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {




	/**
	 * Initialize arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerTagAttribute('type', 'string', 'Should either be pre or post', TRUE);
	}

	/**
	 * @return void
	 */
	public function render() {

		$listData = $this->buildListData();
		$content = '';

		foreach($listData as $listRow) {
			
			$this->templateVariableContainer->add('image', $listRow['image']->getValue());
			$content .= $this->renderChildren();
			$this->templateVariableContainer->remove('image');
		}

		return $content;

	}


	/**
	 * @throws Exception
	 * @return Tx_PtExtlist_Domain_Model_List_ListData
	 */
	protected function buildListData() {
		
		$type = strtolower($this->arguments['type']);
		if($type != 'pre' && $type != 'post') {
			throw new Exception('The Type should either be pre or post', '1320933448');
		}

		$yagContext = Tx_Yag_Domain_Context_YagContextFactory::getInstance();
		$itemList = $yagContext->getItemlistContext();

		$dataBackend = $itemList->getDataBackend();

		if($type == 'pre') {
			return $dataBackend->getPrePageListData();
		} else  {
			return $dataBackend->getPostPageListData();
		}
	}
}