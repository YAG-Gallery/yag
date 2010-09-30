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
 * Interface definition file for a album path settings object.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


/**
 * Interface defines functionality required for an album path settings object
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-29
 * @package Typo3
 * @subpackage yag
 */
interface Tx_Yag_Lib_AlbumPathSettingsInterface {

	public function getBasePath();
	public function getThumbsPath();
	public function getSinglesPath();
	public function getOrigsPath();
	
	public function setBasePath($basePath);
	public function setThumbsPath($thumbsPath);
	public function setSinglesPath($singlesPath);
	public function setOrigsPath($origsPath);
	
}

?>
