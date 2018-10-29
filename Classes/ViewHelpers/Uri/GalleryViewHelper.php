<?php
namespace DL\Yag\ViewHelpers\Uri;


/***************************************************************
*  Copyright notice
*
*  (c) 2010-2014 Daniel Lienert <typo3@lienert.cc>
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
 * Class implements a viewhelper for rendering an uri to a gallery
 *
 * @package ViewHelpers
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class GalleryViewHelper extends \PunktDe\PtExtlist\ViewHelpers\Uri\ActionViewHelper
{
    /**
     * Arguments Initialization
     */
    public function initializeArguments() {
        $this->registerArgument('galleryUid', 'int',
            'UID of album to render link for', false);
        $this->registerArgument('gallery', 'Tx_Yag_Domain_Model_Gallery',
            'Album object to render link for', false);
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
     * @throws Exception
     * @return string Rendered link for gallery
     *
     */
    public function render(
        $action = null,
        array $arguments = array(),
        $controller = null,
        $extensionName = null,
        $pluginName = null,
        $pageUid = null,
        $pageType = 0,
        $noCache = false,
        $noCacheHash = false,
        $section = '',
        $format = '',
        $linkAccessRestrictedPages = false,
        array $additionalParams = array(),
        $absolute = false,
        $addQueryString = false,
        array $argumentsToBeExcludedFromQueryString = array(),
        $addQueryStringMethod = NULL)
    {
        $galleryUid = $this->arguments['galleryUid'];
        $gallery  = $this->arguments['gallery'];

        if ($galleryUid === null && $gallery === null) {
            throw new Exception('You have to set "galleryUid" or "gallery" as parameter. Both parameters can not be empty when using galleryLinkViewHelper', 1295575455);
        }
        if ($galleryUid === null) {
            $galleryUid = $gallery->getUid();
        }

        $namespace = \Tx_Yag_Domain_Context_YagContextFactory::getInstance()->getObjectNamespace() . '.galleryUid';
        $arguments = \PunktDe\PtExtbase\Utility\NamespaceUtility::saveDataInNamespaceTree($namespace, [], $galleryUid);

        return parent::render('index', $arguments, 'Gallery', null, null, $pageUid, $pageType, $noCache, $noCacheHash, $section, $format);
    }
}
