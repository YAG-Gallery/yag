<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Class implements a viewhelper for rendering a link for an image
 *
 * @package ViewHelpers
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_ViewHelpers_Link_ImageViewHelper extends Tx_PtExtlist_ViewHelpers_Link_ActionViewHelper {

	/**
	 * Renders link for an image
	 *
	 * @param int $itemUid UID of item to render link for
	 * @param Tx_Yag_Domain_Model_Item $item Item to render a link to
	 * @param int pageUid (Optional) ID of page to render link for. If null, current page is used
	 * @param integer $pageType type of the target page. See typolink.parameter
	 * @return string Rendered link for album
	 * @throws Exception
	 */
	public function render($itemUid = NULL, Tx_Yag_Domain_Model_Item $item = NULL, $pageUid = NULL, $pageType = 0) {
		if ($itemUid === NULL && $item === NULL) {
			throw new Exception('You have to set "imageUid" or "item" as parameter. Both parameters can not be empty when using imageLinkViewHelper', 1358059753);
		}

		if ($itemUid === NULL) {
			$itemUid = $item->getUid();
		}

		return parent::render('showSingle', array('item' => $itemUid), 'Item', NULL, NULL, $pageUid, $pageType);
	}
}
 
?>