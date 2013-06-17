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
 * Class implementing factory for collection of filterbox configurations
 * 
 * @author Daniel Lienert <lienert@punkt.de>
 * @package Domain
 * @subpackage Configuration\Image
 */
class Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollectionFactory {

	/**
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @param $resolutionConfiguration
	 * @return Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection
	 */
	public static function getInstance(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder, $resolutionSettings) {
		
		$resolutionConfigCollection = new Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection();
		
		foreach($resolutionSettings as $resolutionName => $resolutionSetting) {
			$resolutionSetting['name'] = $configurationBuilder->getTheme() . '.' . $resolutionName;
			$resolutionConfig = new Tx_Yag_Domain_Configuration_Image_ResolutionConfig($configurationBuilder, $resolutionSetting);
			$resolutionConfigCollection->addResolutionConfig($resolutionConfig, $resolutionName);
		}
		
		return $resolutionConfigCollection;
	}


	/**
	 * @static
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @return Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection
	 */
	public static function getInstanceOfAllThemes(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {

		$allSettings = $configurationBuilder->getOrigSettings();
		$themes = $allSettings['themes'];

		$resolutionConfigCollection =  new Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection();
		
		foreach ($themes as $themeName => $theme) {
			if(array_key_exists('resolutionConfigs', $theme) && is_array($theme['resolutionConfigs'])) {
				foreach ($theme['resolutionConfigs'] as $resolutionName => $resolutionSetting) {
					$resolutionSetting['name'] = $themeName . '.' . $resolutionName;
					$resolutionConfig = new Tx_Yag_Domain_Configuration_Image_ResolutionConfig($configurationBuilder, $resolutionSetting);
					$resolutionConfigCollection->addResolutionConfig($resolutionConfig, $resolutionSetting['name']);
				}
			}
		}

		return $resolutionConfigCollection;
	}


	
	/**
	 * @static
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @return Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection
	 */
	public static function getInstanceOfRegistrySelectedThemes(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		$resolutionConfigCollection = self::getInstanceOfAllThemes($configurationBuilder);

		$themesToBuild = array('backend');
		$selectedThemes = unserialize(t3lib_div::makeInstance('t3lib_Registry')->get('tx_yag', 'rfcSelectedThemes', serialize(array())));

		if(!array_key_exists('*', $selectedThemes)) {
			foreach($selectedThemes as $themeName => $isSelected) {
				if($isSelected) $themesToBuild[] = $themeName;
			}

			$resolutionConfigCollection = $resolutionConfigCollection->extractCollectionByThemeList($themesToBuild);
		}

		return $resolutionConfigCollection;
	}
}
?>