<?php
namespace DL\Yag\ViewHelpers\Uri;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Daniel Lienert <typo3@lienert.cc>,
 *
 *
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
 * @author Daniel Lienert
 * @package Viewhelpers
 * @subpackage Uri
 */
class CurrentViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Uri\ActionViewHelper
{
    /**
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
     * @param boolean $absolute If set, an absolute URI is rendered
     * @param boolean $addQueryString If set, the current query parameters will be kept in the URI
     * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = TRUE
     * @return string Rendered link
     */
    public function render()
    {
        $pageUid = $arguments['pageUid'];
        $pageType = $arguments['pageType'];
        $noCache = $arguments['noCache'];
        $noCacheHash = $arguments['noCacheHash'];
        $section = $arguments['section'];
        $format = $arguments['format'];
        $linkAccessRestrictedPages = $arguments['linkAccessRestrictedPages'];
        $additionalParams = $arguments['additionalParams'];
        $absolute = $arguments['absolute'];
        $addQueryString = $arguments['addQueryString'];
        $argumentsToBeExcludedFromQueryString = $arguments['argumentsToBeExcludedFromQueryString'];
        $addQueryStringMethod = $arguments['addQueryStringMethod'];
        $action = $arguments['action'];
        $controller = $arguments['controller'];
        $extensionName = $arguments['extensionName'];
        $pluginName = $arguments['pluginName'];
        $arguments = $arguments['arguments'];

        if (!$action) {
            $action = $this->controllerContext->getRequest()->getControllerActionName();
        }
        if (!$controller) {
            $controller = $this->controllerContext->getRequest()->getControllerName();
        }

        if (!$format) {
            $format = $this->controllerContext->getRequest()->getFormat();
        } elseif ($format === 'html') {
            $format = '';
        }

        $arguments = $this->filterAndMergeArguments($arguments);

        return parent::render($action, $arguments, $controller, $extensionName, $pluginName, $pageUid, $pageType, $noCache, $noCacheHash, $section, $format, $linkAccessRestrictedPages, $additionalParams, $absolute, $addQueryString, $argumentsToBeExcludedFromQueryString);
    }


    /**
     * @param $arguments
     * @return array
     */
    protected function filterAndMergeArguments($arguments)
    {
        $currentArguments = $this->controllerContext->getRequest()->getArguments();
        $systemArgumentKeys = ['controller', 'action', 'format', 'extensionName', 'pluginName'];

        foreach ($systemArgumentKeys as $systemArgumentKey) {
            unset($arguments[$systemArgumentKey]);
            unset($currentArguments[$systemArgumentKey]);
        }
        if($arguments != null) {
            return array_merge($currentArguments, $arguments);
        } else {
            return $currentArguments;
        }
    }
}
