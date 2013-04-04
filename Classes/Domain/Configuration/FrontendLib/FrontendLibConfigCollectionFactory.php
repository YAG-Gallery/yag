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
 * Class implementing factory for collection of frontendlib configurations
 * 
 * @author Daniel Lienert <lienert@punkt.de>
 * @package Domain
 * @subpackage Configuration\FrontendLib
 */
class Tx_Yag_Domain_Configuration_FrontendLib_FrontendLibConfigCollectionFactory {
	
	/**
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @param $frontendLibSettings
	 * @return Tx_Yag_Domain_Configuration_FrontendLib_FrontendLibConfigCollection
	 */
	public static function getInstance(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		
		$frontendLibConfigCollection = new Tx_Yag_Domain_Configuration_FrontendLib_FrontendLibConfigCollection();
		$frontendLibSettings = $configurationBuilder->getSettingsForConfigObject('frontendLib');
		foreach($frontendLibSettings as $frontendLibName => $frontendLibSetting) {
			$frontendLibConfig = new Tx_Yag_Domain_Configuration_FrontendLib_FrontendLibConfig($configurationBuilder, $frontendLibSetting);
			$frontendLibConfigCollection->addFrontendLibConfig($frontendLibConfig, $frontendLibName);
		}
		
		return $frontendLibConfigCollection;
	}
}
?>