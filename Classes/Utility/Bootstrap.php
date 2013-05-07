<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <lienert@punkt.de>
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

class Tx_Yag_Utility_Bootstrap implements t3lib_Singleton {

	/**
	 * @var string
	 */
	protected $theme = 'default';


	/**
	 * @var string
	 */
	protected $contextIdentifier = 'extUsage';


	/**
	 * @return void
	 */
	public function boot() {

		$this->initConfigurationBuilder();

	}



	/**
	 * @return void
	 */
	protected function initConfigurationBuilder() {

		$yagSettings = Tx_PtExtbase_Div::typoscriptRegistry('plugin.tx_yag.settings.');
		$yagEBSettings = t3lib_div::makeInstance('Tx_Extbase_Service_TypoScriptService')->convertTypoScriptArrayToPlainArray($yagSettings);

		Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::injectSettings($yagEBSettings);
		Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance($this->contextIdentifier, $this->theme);
		Tx_Yag_Domain_Context_YagContextFactory::createInstance($this->contextIdentifier);
	}


	/**
	 * @param $theme
	 * @return Tx_Yag_Utility_Bootstrap
	 */
	public function setTheme($theme) {
		$this->theme = $theme;
		return $this;
	}


	/**
	 * @param $contextIdentifier
	 * @return Tx_Yag_Utility_Bootstrap
	 */
	public function setContextIdentifier($contextIdentifier) {
		$this->contextIdentifier = $contextIdentifier;
		return $this;
	}
}

?>
