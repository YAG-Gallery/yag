<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>
*  			Michael Knoll <mimi@kaktusteam.de>
*  			
*  All rights reserved
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
 * Class implements album configuration object Extlist configuration in YAG
 *
 * @package Domain
 * @subpackage Configuration\Extlist
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Configuration_Extlist_ExtlistConfiguration extends Tx_PtExtbase_Configuration_AbstractConfiguration {
	
	/**
	 * Returns list configuration for a given list identifier
	 *
	 * @param string $listIdentifier
	 * @return array
	 */
	public function getExtlistSettingsByListId($listIdentifier) {
		if (array_key_exists($listIdentifier, $this->settings)) {
			return $this->settings[$listIdentifier];
		} else {
			throw new Exception('No list configuration found for list identifier ' . $listIdentifier . ' Available are: ' . implode(', ', array_keys($this->settings)), 1294150333);
		}
	}
	
}
?>