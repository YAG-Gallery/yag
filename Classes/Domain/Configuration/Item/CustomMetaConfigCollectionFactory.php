<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <lienert@punkt.de>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Class implementing factory for collection of meta configurations
 * 
 * @author Daniel Lienert <lienert@punkt.de>
 * @package Domain
 * @subpackage Configuration\Item
 */
class Tx_Yag_Domain_Configuration_Item_CustomMetaConfigCollectionFactory
{
    /**
     * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
     * @return Tx_Yag_Domain_Configuration_Item_CustomMetaConfigCollection
     */
    public static function getInstance(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder)
    {
        $customMetaSettings = $configurationBuilder->getSettingsForConfigObject('customMetaData');
        $customMetaCollection = new Tx_Yag_Domain_Configuration_Item_CustomMetaConfigCollection();

        foreach ($customMetaSettings as $customMetaKey => $customMetaSetting) {
            $customMetaSetting['key'] = $customMetaKey;
            $customMetaConfig = new Tx_Yag_Domain_Configuration_Item_CustomMetaConfig($configurationBuilder, $customMetaSetting);
            $customMetaCollection->addCustomMetaConfig($customMetaConfig, $customMetaKey);
        }
        
        return $customMetaCollection;
    }
}
