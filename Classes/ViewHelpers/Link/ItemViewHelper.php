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
 * Class implements a viewhelper for rendering a link for an album
 *
 * @package ViewHelpers
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_ViewHelpers_Link_ItemViewHelper extends Tx_PtExtlist_ViewHelpers_Link_ActionViewHelper {


	public function initializeArguments() {
		$this->registerArgument('gallery', 'Tx_Yag_Domain_Model_Gallery', 'Set a gallery for filtering the item list', FALSE, NULL);
		$this->registerArgument('album', 'Tx_Yag_Domain_Model_Album', 'Set an album for filtering the item list', FALSE, NULL);
		//  $this->registerArgument('item', 'Tx_Yag_Domain_Model_Item', 'Set an item for filtering the item list', FALSE, NULL); // TODO: Calculate the offset to the given item in the resulting list
		$this->registerArgument('itemListOffset', 'integer', 'Choose an item via offset from the resulting item list', FALSE, NULL);
	}


	/**
	 * Renders the link to an image
	 *
	 * @param array $arguments Arguments
	 * @param integer $pageUid target page. See TypoLink destination
	 * @param integer $pageType type of the target page. See typolink.parameter
	 * @param boolean $noCache set this to disable caching for the target page. You should not need this.
	 * @param boolean $noCacheHash set this to supress the cHash query parameter created by TypoLink. You should not need this.
	 * @param string $section the anchor to be added to the URI
	 * @param string $format The requested format, e.g. ".html"
	 * @param boolean $linkAccessRestrictedPages If set, links pointing to access restricted pages will still link to the page even though the page cannot be accessed.
	 * @param array $additionalParams additional query parameters that won't be prefixed like $arguments (overrule $arguments)
	 * @param boolean $absolute If set, the URI of the rendered link is absolute
	 * @param boolean $addQueryString If set, the current query parameters will be kept in the URI
	 * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = TRUE
	 * @return string Rendered link
	 */
	public function render($pageUid = NULL, $pageType = 0, array $arguments = array(), $noCache = FALSE, $noCacheHash = FALSE, $section = '', $format = '', $linkAccessRestrictedPages = FALSE, array $additionalParams = array(), $absolute = FALSE, $addQueryString = FALSE, array $argumentsToBeExcludedFromQueryString = array()) {

		$objectNameSpace = $namespace = Tx_Yag_Domain_Context_YagContextFactory::getInstance()->getObjectNamespace();
		$arguments = array();

		if(isset($this->arguments['album'])) {
			$albumUid = $this->arguments['album']->getUid();
			$arguments = Tx_PtExtbase_Utility_NameSpace::saveDataInNamespaceTree($objectNameSpace. '.albumUid', $arguments, $albumUid);
		}

		if(isset($this->arguments['gallery'])) {
			$galleryUid = $this->arguments['gallery']->getUid();
			$arguments = Tx_PtExtbase_Utility_NameSpace::saveDataInNamespaceTree($objectNameSpace. '.galleryUid', $arguments, $galleryUid);
		}


		Tx_PtExtbase_State_Session_SessionPersistenceManagerFactory::getInstance()->addSessionRelatedArguments($arguments);

		return parent::render('show', $arguments, 'Item', NULL, NULL, $pageUid, $pageType, $noCache, $noCacheHash, $section, $format, $linkAccessRestrictedPages, $additionalParams, $absolute, $addQueryString, $argumentsToBeExcludedFromQueryString);
	}
}
 
?>