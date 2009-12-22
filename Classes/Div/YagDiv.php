<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*            
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
 * Library with static methods for YAG Gallery extension
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


/**
 * Class implements some static methods for YAG gallery
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Div_YagDiv {
	
	
	/**
	 * Returns installation base path of typo3 installation
	 *
	 * @return string  Base path of typo3 installation
	 */
	public static function getBasePath() {
		$scriptPath = PATH_thisScript;
		$scriptPathStripped = str_replace('index.php', '', $scriptPath);
		return $scriptPathStripped;
	}
	
	/**
	 * Returns path of directory that is configured as fileadmin
	 *
	 * @return string  Path to fileadmin
	 */
	public static function getFileadminPath() {
		return 'fileadmin/';
	}
	
}

?>