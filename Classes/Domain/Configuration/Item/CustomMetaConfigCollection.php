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
 * Collection of custom item meta configs
 *
 * @package Domain
 * @subpackage Configuration\Item
 * 
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_Item_CustomMetaConfigCollection extends Tx_PtExtbase_Collection_ObjectCollection
{
    /**
     * @var string
     */
    protected $restrictedClassName = 'Tx_Yag_Domain_Configuration_Item_CustomMetaConfig';
    
    
    
    /**
     * Add a config to the collection
     * 
     * @param Tx_Yag_Domain_Configuration_Item_CustomMetaConfig $customMetaConfig
     * @param string $metaConfigKey
     */
    public function addCustomMetaConfig(Tx_Yag_Domain_Configuration_Item_CustomMetaConfig $customMetaConfig, $metaConfigKey)
    {
        $this->addItem($customMetaConfig, $metaConfigKey);
    }


    /**
     * @param $metaConfigKey
     * @return mixed
     * @throws Exception
     */
    public function getCustomMetaConfig($metaConfigKey)
    {
        if ($this->hasItem($metaConfigKey)) {
            return $this->getItemById($metaConfigKey);
        } else {
            throw new Exception('The meta config with name ' . $metaConfigKey . ' is not defined! 1383694474');
        }
    }


    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count();
    }
}
