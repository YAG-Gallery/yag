<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Class for XMP meta data parsing
 *
 * @package Domain
 * @subpackage Import\MetaData
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Import_MetaData_XmpParser extends Tx_Yag_Domain_Import_MetaData_AbstractParser {
	
	/**
	 * Parses given file for xmp data
	 * Currently returns the XMP Data
	 * 
	 * @param string $filename
	 * @return string XMP Data
	 */
	public function parseXmpData($filename) {

		$content = file_get_contents($filename);
		$xmp_data_start = strpos($content, '<x:xmpmeta');
		$xmp_data_end   = strpos($content, '</x:xmpmeta>');
		$xmp_length     = $xmp_data_end - $xmp_data_start;

		$xmp_data       = substr($content, $xmp_data_start, $xmp_length + 12);

		unset($content);
		return $xmp_data;
	}



	/**
	 * Returns a value from xmpData for a given key
	 *
	 * @param string $xmpData Xmp Data to search for key
	 * @param string $key Key to search for
	 * @return string Value of key, if available
	 */
	public function getXmpValueByKey($xmpData, $key) {
		$results = array();
		preg_match('/' . $key . '="(.+?)"/m', $xmpData, $results);
		return $results[1];
	}
	
}
 
?>