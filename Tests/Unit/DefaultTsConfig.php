<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Class holds default TS configuration for testcases
 *
 * @package Tests
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class Tx_Yag_Tests_DefaultTsConfig
{
    /**
     * Typoscript configuration
     *
     * @var string
     */
    public $tsConfigString = "
		plugin.tx_yag.settings {
		    
			importer {
				supportedFileTypes = jpg,jpeg,gif,png
				importFileMask = 664
		    }

		    imageProcessor {
		        tempPath = tmp
	        }
	        
	        general {
	        	hashFilesystemRoot = /
	        }
		}
	";
    
    
    
    /**
     * Typoscript configuration array
     *
     * @var array
     */
    public $tsConfigArray = array();
    
    
    
    /**
     * Holds an instance of this class
     *
     * @var Tx_Yag_Tests_DefaultTsConfig
     */
    protected static $instance = null;
    
    
    
    /**
     * Returns an instance of this class as singleton
     *
     * @return Tx_Yag_Tests_DefaultTsConfig
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    
    
    /**
     * Constructor
     */
    protected function __construct()
    {
        $this->initTsConfigArray();
    }
    
    
    
    /**
     * Initializes configuration array by TS string
     *
     */
    protected function initTsConfigArray()
    {
        $typoScriptParser = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser');
        $typoScriptParser->parse($this->tsConfigString);
        $this->tsConfigArray = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Service\\TypoScriptService')->convertTypoScriptArrayToPlainArray($typoScriptParser->setup);
    }
    
    
    
    /**
     * Returns configuration builder for default TS settings
     *
     * @return Tx_Yag_Domain_Configuration_ConfigurationBuilder
     */
    public function getDefaultConfigurationBuilder()
    {
        return new Tx_Yag_Domain_Configuration_ConfigurationBuilder($this->tsConfigArray['plugin']['tx_yag']['settings'], 'test', 'test');
    }
}
