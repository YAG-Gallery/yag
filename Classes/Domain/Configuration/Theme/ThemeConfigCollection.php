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
 * collection of resolution configs
 *
 * @package Domain
 * @subpackage Configuration\Image
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_Theme_ThemeConfigCollection extends Tx_PtExtbase_Collection_ObjectCollection {

	/**
	 * @var string
	 */
	protected $restrictedClassName = 'Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration';
	
	
	
	/**
	 * @param Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration $themeConfig
	 * @param $themeName string
	 * @return void
	 */
	public function addThemeConfig(Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration $themeConfig, $themeName) {
		$this->addItem($themeConfig, $themeName);
	}
	
	
	
	/**
	 * @throws Exception Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration
	 * @param $themeName string
	 * @return mixed
	 */
	public function getResolutionConfig($themeName) {
		if($this->hasItem($themeName)) {
			return $this->getItemById($themeName);
		} else {
			throw new Exception('The theme with name ' . $themeName . ' is not defined! 1316763550');
		}
	}
}

?>