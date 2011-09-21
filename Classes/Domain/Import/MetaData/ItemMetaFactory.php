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

	/**
	 * Create meta data object for given filename
	 *
	 * @param string $filename Path to file
	 * @return Tx_Yag_Domain_Model_ItemMeta Meta Data object for file
	 */
	public static function createItemMetaForFile($filename) {
		$exifData = Tx_Yag_Domain_Import_MetaData_ExifParser::parseExifData($filename);
		$iptcData = Tx_Yag_Domain_Import_MetaData_IptcParser::parseIptcData($filename);
		$xmpData = Tx_Yag_Domain_Import_MetaData_XmpParser::parseXmpData($filename);
		
		$itemMeta = new Tx_Yag_Domain_Model_ItemMeta();
		
		$itemMeta->setExif(serialize($exifData));
		$itemMeta->setIptc(serialize($iptcData));
		$itemMeta->setXmp($xmpData);
		
		$itemMeta->setAperture($exifData['COMPUTED']['ApertureNumber']);
		$itemMeta->setArtist($iptcData["2#080"][0]);

		$itemMeta->setArtistMail(self::getXmpValueByKey($xmpData, 'Iptc4xmpCore\:CiEmailWork'));
		$itemMeta->setArtistWebsite(self::getXmpValueByKey($xmpData, 'Iptc4xmpCore\:CiEmailWork')); 
		$itemMeta->setCameraModel($exifData['Make'] . ' - ' . $exifData['Model']);
		$itemMeta->setCopyright($iptcData["2#116"][0]);
		$itemMeta->setDescription($exifData['ImageDescription']);
		$itemMeta->setFlash($exifData['Flash']);
		$itemMeta->setFocalLength($exifData['FocalLengthIn35mmFilm']);
		//$itemMeta->setGpsLatitude(); // not available yet
		//$itemMeta->setGpsLongitude(); // not available yet
		$itemMeta->setIso($exifData['ISOSpeedRatings']); 
		if(is_array($iptcData['2#025'])) $itemMeta->setKeywords(implode(',', $iptcData['2#025']));
		$itemMeta->setLens(self::getXmpValueByKey($xmpData, 'aux\:Lens'));
		$itemMeta->setShutterSpeed($exifData['ShutterSpeedValue']);
		
		return $itemMeta;
	}
	
	
	
	/**
	 * Returns a value from xmpData for a given key
	 *
	 * @param string $xmpData Xmp Data to search for key
	 * @param string $key Key to search for
	 * @return string Value of key, if available
	 */
	protected static function getXmpValueByKey($xmpData, $key) {
		$results = array();
		preg_match('/' . $key . '="(.+?)"/m', $xmpData, $results);
		return $results[1];
	}
	
}
 
?>