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

require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('yag').'Classes/Utility/Flexform/AbstractFlexformUtility.php'; // pt_tools div class

/**
 * Utilitty to get selectable options from typoscript
 *
 * @package Utility
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class user_Tx_Yag_Utility_Flexform_TyposcriptDataProvider extends Tx_Yag_Utility_Flexform_AbstractFlexformUtility
{
    /**
     * Current pid
     * @var integer
     */
    protected $currentPid;
    
    
    
    /**
     * The YAG Typoscript part
     * 
     * @var array
     */
    protected $yagTypoScript = null;
    
    
    
    /**
     * Get a List of defined extList listconfigs
     * 
     * @param array $config
     * @return array $config
     */
    public function getDefinedThemes(array $config)
    {
        $this->initTsDataProvider($config);

        $themeList = array();
        $tsArray = $this->getTSArrayByPath('settings.themes');
        
        unset($tsArray['backend']);
        
        ksort($tsArray);
        
        foreach ($tsArray as $key => $valueArray) {
            $label = $key;
            $label[0] = strtoupper($label[0]);
            $themeList[] = array($label, $key);
        }
        
        $config['items'] = array_merge($config['items'], $themeList);
        return $config;
    }

    
    
    /**
     * Init the DataProvider
     * 
     * @param array $config
     */
    protected function initTsDataProvider($config)
    {
        $this->determineCurrentPID($config['row']['pid']);
        $this->loadYagTyposcriptArray();
    }
    
    
    
    /**
     * Load the complete extlist part from typoscript
     */
    protected function loadYagTyposcriptArray()
    {
        if (is_null($this->yagTypoScript)) {
            $extListTS = Tx_PtExtbase_Div::typoscriptRegistry('plugin.tx_yag.', $this->currentPid);
            $this->yagTypoScript =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Service\\TypoScriptService')->convertTypoScriptArrayToPlainArray($extListTS);
        }
    }


    /**
     * Return a list of typoscript keys beneath the current path
     *
     * @param $typoScriptPath
     * @return array
     */
    protected function getTypoScriptKeyList($typoScriptPath)
    {
        $keyList = array();
        $tsArray = $this->getTSArrayByPath($typoScriptPath);
        
        ksort($tsArray);
        
        foreach ($tsArray as $key => $valueArray) {
            $label = $key;
            $label[0] = strtoupper($label[0]);
            $keyList[] = array($label, $key);
        }

        return $keyList;
    }
    
    
    /**
     * return a typoscript array by given typoscript path
     * 
     * @param string $typoScriptPath
     * @return array 
     */
    protected function getTSArrayByPath($typoScriptPath)
    {
        $pathArray = explode('.', $typoScriptPath);
        $outTSArray = \TYPO3\CMS\Extbase\Utility\ArrayUtility::getValueByPath($this->yagTypoScript, $pathArray);
        
        if (!is_array($outTSArray)) {
            $outTSArray = array();
        }
        
        return $outTSArray;
    }
}
