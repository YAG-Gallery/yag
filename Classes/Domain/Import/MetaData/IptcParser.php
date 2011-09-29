<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Class for IPTC metadata parsing
 *
 * @package Domain
 * @subpackage Import\MetaData
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Import_MetaData_IptcParser extends Tx_Yag_Domain_Import_MetaData_AbstractParser implements t3lib_Singleton {
	
	/**
	 * Parses IPTC data for a given file
	 *
	 * @param string $filename Path of file to be parsed
	 * @return array IPTC data or null if none existing
	 */
	public function parseIptcData($filename) {

		if(function_exists('iptcparse')) {

			getimagesize($filename, $info);

			if (is_array($info)) {
				$iptc = iptcparse($info["APP13"]);

				foreach($iptc as $iptcKey => &$iptcValue) {
					$iptcValue = $this->convert_to_utf8($iptcValue);
				}

				return $iptc;
			}
		}

		return null;
	}


	protected function convert_to_utf8($value) {
		if (function_exists("mb_detect_encoding") &&
			 function_exists("mb_convert_encoding") &&
			 mb_detect_encoding($value, "ISO-8859-1, UTF-8") != "UTF-8"
		) {
      $value = mb_convert_encoding($value, "UTF-8", mb_detect_encoding($value));
    } else if (function_exists("mb_detect_encoding") &&
					mb_detect_encoding($value, "ISO-8859-1, UTF-8") != "UTF-8"
		) {
			$value = utf8_encode($value);
		}
		return $value;
	}
}
 
?>