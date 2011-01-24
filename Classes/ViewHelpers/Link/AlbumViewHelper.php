<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Class implements a viewhelper for rendering a link for an album
 *
 * @package ViewHelpers
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_ViewHelpers_Link_AlbumViewHelper extends Tx_Fluid_ViewHelpers_Link_ActionViewHelper {

	/**
	 * Renders link for an album
	 *
	 * @param int $albumUid UID of album to render link for
	 * @param Tx_Yag_Domain_Model_Album $album Album object to render link for
	 * @param int pageUid (Optional) ID of page to render link for. If null, current page is used
	 * @return string Rendered link for album
	 */
    public function render($albumUid = NULL, Tx_Yag_Domain_Model_Album $album = NULL, $pageUid = NULL) {
        if ($albumUid === null && $album === null) {
        	throw new Exception('You have to set "albumUid" or "album" as parameter. Both parameters can not be empty when using albumLinkViewHelper 1295575454');
        }
        if ($albumUid === null) {
        	$albumUid = $album->getUid();
        }
        $arguments = array();
        $namespace = 'itemList.filters.internalFilters.albumFilter.albumUid';
        $arguments = Tx_PtExtlist_Utility_NameSpace::saveDataInNamespaceTree($namespace, $arguments, $albumUid);
        return $this->renderLink($arguments, $pageUid);
    }
    

    
    /**
     * Template method for rendering actual link. Can be overwritten in 
     * extending classes to change controller etc.
     *
     * @param array $arguments
     * @param int $pageUid
     * @return string
     */
    protected function renderLink($arguments, $pageUid) {
        return parent::render('submitFilter', $arguments, 'ItemList', null, $pageUid);
    }
	
}
 
?>