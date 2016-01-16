<?php
/***************************************************************
* Copyright notice
*
*   2010 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
* All rights reserved
*
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
* Utility to include defined frontend libraries as jQuery and related CSS
*  
*
* @package Utility
* @author Daniel Lienert <typo3@lienert.cc>
*/
class Tx_Yag_Utility_HeaderInclusion implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
    * @var \TYPO3\CMS\Core\Page\PageRenderer
    */
    protected $pageRenderer;


    /**
    * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
    */
    protected $configurationBuilder;


    /**
     * @var Tx_Yag_Domain_FileSystem_Div
     */
    protected $fileSystemDiv;


    /**
     * @param Tx_Yag_Domain_FileSystem_Div $fileSystemDiv
     */
    public function injectFileSystemDiv(Tx_Yag_Domain_FileSystem_Div $fileSystemDiv)
    {
        $this->fileSystemDiv = $fileSystemDiv;
    }
    
    /**
     * Initialize the object (called by objectManager)
     * 
     */
    public function initializeObject()
    {
        if (TYPO3_MODE === 'BE') {
            $this->initializeBackend();
        } else {
            $this->initializeFrontend();
        }
    }


    /**
     * @return Tx_Yag_Domain_Configuration_ConfigurationBuilder
     */
    protected function getConfigurationBuilder()
    {
        if (!$this->configurationBuilder instanceof Tx_Yag_Domain_Configuration_ConfigurationBuilder) {
            $this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance();
        }

        return $this->configurationBuilder;
    }


    /**
     * Add a defined frontend library
     *
     * @param $libName
     * @param $jsPosition
     */
    public function addDefinedLibJSFiles($libName, $jsPosition = 'footer')
    {
        $feLibConfig = $this->getConfigurationBuilder()->buildFrontendLibConfiguration()->getFrontendLibConfig($libName);
        if ($feLibConfig->getInclude()) {
            foreach ($feLibConfig->getJSFiles() as $jsFilePath) {
                $this->addJSFile($jsFilePath, $jsPosition);
            }
        }
    }



    /**
     * Add the CSS of a defined library
     * 
     * @param string $libName
     */
    public function addDefinedLibCSS($libName)
    {
        $feLibConfig = $this->getConfigurationBuilder()->buildFrontendLibConfiguration()->getFrontendLibConfig($libName);
        if ($feLibConfig->getInclude()) {
            foreach ($feLibConfig->getCSSFiles() as $cssFilePath) {
                $this->addCSSFile($cssFilePath);
            }
        }
    }


    /**
     * Adds CSS file
     *
     * TODO we've set compress = FALSE, as paths (example background url) are rewritten if set to true which we do not want to happen
     *
     * @param $file
     * @param string $rel
     * @param string $media
     * @param string $title
     * @param bool $compress
     * @param bool $forceOnTop
     * @param string $allWrap
     */
    public function addCSSFile($file, $rel = 'stylesheet', $media = 'all', $title = '', $compress = false, $forceOnTop = false, $allWrap = '')
    {
        $this->pageRenderer->addCSSFile($this->fileSystemDiv->getFileRelFileName($file), $rel, $media, $title, $compress, $forceOnTop, $allWrap);
    }



    /**
     * Add a JS File to the header
     * 
     * @param string $file
     * @param string $type
     * @param boolean $compress
     * @param boolean $forceOnTop
     * @param string $allWrap
     * @param string $position
     * @return void
     */
    public function addJSFile($file, $position = 'footer', $type = 'text/javascript', $compress = true, $forceOnTop = false, $allWrap = '')
    {
        $filePath = GeneralUtility::isFirstPartOfStr(strtolower($file), 'http') ? $file : $this->fileSystemDiv->getFileRelFileName($file);

        if ($position === 'footer') {
            $this->pageRenderer->addJsFooterFile($filePath, $type, $compress, $forceOnTop, $allWrap);
        } else {
            $this->pageRenderer->addJsFile($filePath, $type, $compress, $forceOnTop, $allWrap);
        }
    }



    /**
     * @param $name
     * @param $block
     * @param bool $compress
     * @param bool $forceOnTop
     * @return void
     */
    public function addCssInlineBlock($name, $block, $compress = false, $forceOnTop = false)
    {
        $this->pageRenderer->addCssInlineBlock($name, $block, $compress, $forceOnTop);
    }



    /**
     * Add JS inline code
     *
     * @param string $name
     * @param string $block
     * @param boolean $compress
     * @param boolean $forceOnTop
     * @param string $position
     */
    public function addJSInlineCode($name, $block, $compress = true, $forceOnTop = false, $position = 'footer')
    {
        if ($position === 'header') {
            $this->pageRenderer->addJsInlineCode($name, $block, $compress, $forceOnTop);
        } else {
            $this->pageRenderer->addJsFooterInlineCode($name, $block, $compress, $forceOnTop);
        }
    }



    /**
     * Initialize Backend specific variables
     */
    protected function initializeBackend()
    {
        $doc = GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Template\\DocumentTemplate');
        $doc->backPath = $GLOBALS['BACK_PATH'];

        $this->pageRenderer = $doc->getPageRenderer();
        $this->relExtPath = '../' . $this->relExtPath;
    }



    /**
     * Initialize Frontend specific variables
     */
    protected function initializeFrontend()
    {
        $GLOBALS['TSFE']->backPath = TYPO3_mainDir;
        $this->pageRenderer = $GLOBALS['TSFE']->getPageRenderer();
    }



    /**
     * Expand the EXT to a relative path
     * 
     * @param string $filename
     * @return string
     * @deprecated Use Tx_Yag_Domain_FileSystem_Div::getFileRelFileName instead
     */
    public function getFileRelFileName($filename)
    {
        return $this->fileSystemDiv->getFileRelFileName($filename);
    }



    /**
     * Add theme defined CSS / JS to the header
     * @var Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration $themeConfiguration
     */
    public function includeThemeDefinedHeader(Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration $themeConfiguration)
    {
        $jsPosition = $themeConfiguration->getJsPosition();

        // add JS files from a defined library to the header 
        $headerJSLibs = $themeConfiguration->getJSLibraries();
        foreach ($headerJSLibs as $library) {
            $this->addDefinedLibJSFiles($library, $jsPosition);
        }

        // add CSS files from a defined library to the header
        $headerLibCSS = $themeConfiguration->getCSSLibraries();
        foreach ($headerLibCSS as $library) {
            $this->addDefinedLibCSS($library);
        }

        // Add CSS files to the header
        $headerCSSFiles = $themeConfiguration->getCSSFiles();
        foreach ($headerCSSFiles as $fileIdentifier => $filePath) {
            $this->addCSSFile($filePath);
        }

        // Add JS files to the header
        $headerJSFiles = $themeConfiguration->getJSFiles();
        foreach ($headerJSFiles as $fileIdentifier => $filePath) {
            $this->addJSFile($filePath, $jsPosition);
        }
    }
}
