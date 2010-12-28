<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Factory for item meta objects.
 * 
 * Factory uses meta data parsers to create an item meta object for an album item.
 *
 * @package Domain
 * @subpackage Import\MetaData
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Import_MetaData_ItemMetaFactory {

	
	public static function createItemMetaForFile($filename) {
		$exifData = Tx_Yag_Domain_Import_MetaData_ExifParser::parseExifData($filename);
		$iptcData = Tx_Yag_Domain_Import_MetaData_IptcParser::parseIptcData($filename);
		$xmpData = Tx_Yag_Domain_Import_MetaData_XmpParser::parseXmpData($filename);
		
		$itemMeta = new Tx_Yag_Domain_Model_ItemMeta();
		var_dump($exifData);
		var_dump($iptcData);
		var_dump($xmpData);
	}
	
}
 
?>