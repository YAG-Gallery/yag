<?php
namespace DL\Yag\ViewHelpers\Link;
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
class AlbumViewHelper extends \PunktDe\PtExtlist\ViewHelpers\Link\ActionViewHelper
{

    /**
     * Arguments Initialization
     */
    public function initializeArguments() {
        $this->registerArgument('albumUid', 'int',
            'UID of album to render link for', false);
        $this->registerArgument('album', 'Tx_Yag_Domain_Model_Album',
            'Album object to render link for', false);
        $this->registerArgument('gallery', 'Tx_Yag_Domain_Model_Gallery',
            'Gallery object to render link for', false);
    }

    /**
     * Renders link for an album
     *
     * @param string $action Target action
     * @param array $arguments Arguments
     * @param string $controller Target controller. If NULL current controllerName is used
     * @param string $extensionName Target Extension Name (without "tx_" prefix and no underscores). If NULL the current extension name is used
     * @param string $pluginName Target plugin. If empty, the current plugin name is used
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
     * @param string $addQueryStringMethod Set which parameters will be kept. Only active if $addQueryString = TRUE
     * @return string Rendered link for album
     * @throws Exception
     */
    public function render($action = null, array $arguments = array(), $controller = null, $extensionName = null, $pluginName = null, $pageUid = null, $pageType = 0, $noCache = false, $noCacheHash = false, $section = '', $format = '', $linkAccessRestrictedPages = false, array $additionalParams = array(), $absolute = false, $addQueryString = false, array $argumentsToBeExcludedFromQueryString = array(), $addQueryStringMethod = NULL)
    {
        $albumUid = $this->arguments['albumUid'];
        $album  = $this->arguments['album'];
        $gallery  = $this->arguments['gallery'];

        if ($albumUid == 0 && $album === null) {
            throw new \Exception('You have to set "albumUid" or "album" as parameter. Both parameters can not be empty when using albumLinkViewHelper', 1295575454);
        }

        if ($albumUid == 0) {
            $albumUid = $album->getUid();
        }

        $baseNamespace = \Tx_Yag_Domain_Context_YagContextFactory::getInstance()->getObjectNamespace();
        $arguments = \PunktDe\PtExtbase\Utility\NamespaceUtility::saveDataInNamespaceTree($baseNamespace . '.albumUid', [], $albumUid);

        if ($gallery !== null) {
            $arguments = \PunktDe\PtExtbase\Utility\NamespaceUtility::saveDataInNamespaceTree($baseNamespace . '.galleryUid', $arguments, $gallery->getUid());
        }

        return parent::render('submitFilter', $arguments, 'ItemList', null, null, $pageUid, $pageType, $noCache, $noCacheHash, $section, $format);
    }
}
