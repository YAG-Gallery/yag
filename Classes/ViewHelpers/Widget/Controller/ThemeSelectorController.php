<?php
/***************************************************************
* Copyright notice
*
*   2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
* All rights reserved
*
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* 
* @package ViewHelpers
* @subpackage Widget\Controller
* @author Daniel Lienert <daniel@lienert.cc>
*/

class Tx_Yag_ViewHelpers_Widget_Controller_ThemeSelectorController extends Tx_Yag_ViewHelpers_Widget_Controller_AbstractWidgetController {


	/**
	 * @return void
	 */
	public function indexAction() {
		$themeCollection = $this->configurationBuilder->buildThemeConfigurationCollection();
		$this->view->assign('themeCollection', $themeCollection);
	}


	/**
	 * @return void
	 */
	public function selectThemeAction() {

		$selectedThemes = t3lib_div::_GET('selectedThemes');

		foreach($selectedThemes as $theme => $isSelected) {
			$selectedThemes[$theme] = $isSelected == 'true' ? true : false;
		}

		$registry = t3lib_div::makeInstance('t3lib_Registry'); /** @var $registry t3lib_Registry */
		$registry->set('tx_yag', 'rfcSelectedThemes', serialize($selectedThemes));

		exit();
	}
}
?>