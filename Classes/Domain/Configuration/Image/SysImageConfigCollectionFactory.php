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
 * Class implementing factory for system image configurations
 * 
 * @author Daniel Lienert <lienert@punkt.de>
 * @package Domain
 * @subpackage Configuration\Image
 */
class Tx_Yag_Domain_Configuration_Image_SysImageConfigCollectionFactory {
	
	/**
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @param $sysImageSettings
	 * @return Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection
	 */
	public static function getInstance(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		
		$sysImageSettings = $configurationBuilder->getSettingsForConfigObject('sysImages');
		$sysImageConfigCollection = new Tx_Yag_Domain_Configuration_Image_SysImageConfigCollection();

		foreach($sysImageSettings as $sysImageConfigName => $sysImageSetting) {
			$sysImageSetting['name'] = $sysImageConfigName;
			$sysImageConfig = new Tx_Yag_Domain_Configuration_Image_SysImageConfig($configurationBuilder, $sysImageSetting);
			$sysImageConfigCollection->addSysImageConfig($sysImageConfig, $sysImageConfigName);
		}
		
		return $sysImageConfigCollection;
	}
}
?>