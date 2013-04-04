<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Base testcase for all yag testcases
 *
 * @package Tests
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
abstract class Tx_Yag_Tests_BaseTestCase extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @var string
	 */
	protected $extensionName = 'yag';

	/**
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder;


	/**
	 * @return Tx_Yag_Domain_Model_Item
	 */
	protected function getTestItemObject() {
		$item = new Tx_Yag_Domain_Model_Item();
		$item->setSourceuri(substr(t3lib_extMgm::extPath($this->extensionName) . 'Tests/TestImages/',strlen(PATH_site)) . 'testImage.jpg');


		return $item;
	}


	/**
	 * @param null $settings
	 */
	protected function initConfigurationBuilderMock($settings = NULL) {

		if(!$settings) {
			$tsFilePath = t3lib_extMgm::extPath($this->extensionName) . 'Configuration/TypoScript/setup.txt';
			$typoscript = Tx_PtExtbase_Div::loadTypoScriptFromFile($tsFilePath);
			$settings = t3lib_div::makeInstance('Tx_Extbase_Service_TypoScriptService')->convertTypoScriptArrayToPlainArray($typoscript);
			$settings = $settings['plugin']['tx_yag']['settings'];
		}

		Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::injectSettings($settings);
		$this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance('test', 'default');
	}
}
?>