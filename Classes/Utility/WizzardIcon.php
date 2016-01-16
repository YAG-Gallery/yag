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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Utility to add the YAG Icon to Element Wizzard
 *
 * @package Utility
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class Tx_Yag_Utility_WizzardIcon
{
    /**
     * Processing the wizard items array
     *
     * @param	array		$wizardItems: The wizard items
     * @return	Modified array with wizard items
     */
    public function proc($wizardItems)
    {
        $llFile = ExtensionManagementUtility::extPath('yag').'Resources/Private/Language/locallang.xlf:';

        $wizardItems['plugins_tx_yag_pi1'] = array(
            'icon'            => ExtensionManagementUtility::extRelPath('yag') . 'Resources/Public/Icons/tx_yag_icon_32.png',
            'title'            => LocalizationUtility::translate('tx_yag_wizzard.title', 'yag'),
            'description'    => LocalizationUtility::translate('tx_yag_wizzard.description', 'yag'),
            'params'        => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=yag_pi1'
        );

        return $wizardItems;
    }
}
