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
 * Factory for item meta objects.
 * 
 * Factory uses meta data parsers to create an item meta object for an album item.
 *
 * @package Domain
 * @subpackage Import\MetaData
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Import_MetaData_ItemMetaFactory {


	/**
	 * @var Tx_Yag_Domain_Import_MetaData_ExifParser
	 */
	protected $exifParser;


	/**
	 * @var Tx_Yag_Domain_Import_MetaData_IptcParser
	 */
	protected $iptcParser;


	/**
	 * @var Tx_Yag_Domain_Import_MetaData_XmpParser
	 */
	protected $xmpParser;


	/**
	 * @var Tx_Extbase_SignalSlot_Dispatcher
	 */
	protected $signalSlotDispatcher;


	/**
	 * @param Tx_Yag_Domain_Import_MetaData_ExifParser $exifParser
	 */
	public function injectExifParser(Tx_Yag_Domain_Import_MetaData_ExifParser $exifParser) {
		$this->exifParser = $exifParser;
	}


	/**
	 * @param Tx_Yag_Domain_Import_MetaData_IptcParser $iptcParser
	 */
	public function injectIptcParser(Tx_Yag_Domain_Import_MetaData_IptcParser $iptcParser) {
		$this->iptcParser = $iptcParser;
	}


	/**
	 * @param Tx_Yag_Domain_Import_MetaData_XmpParser $xmpParser
	 */
	public function injectXmpParser(Tx_Yag_Domain_Import_MetaData_XmpParser $xmpParser) {
		$this->xmpParser = $xmpParser;
	}



	/**
	 * @param Tx_Extbase_SignalSlot_Dispatcher $signalSlotDispatcher
	 */
	public function injectSignalSlotDispatcher(Tx_Extbase_SignalSlot_Dispatcher $signalSlotDispatcher) {
		$this->signalSlotDispatcher = $signalSlotDispatcher;
	}



	/**
	 * Create meta data object for given fileName
	 *
	 * @param string $fileName Path to file
	 * @return Tx_Yag_Domain_Model_ItemMeta Meta Data object for file
	 */
	public function createItemMetaForFile($fileName) {

		$itemMeta = new Tx_Yag_Domain_Model_ItemMeta();

		$this->setDefaults($itemMeta);
		$this->processExifData($fileName, $itemMeta);
		$this->processIPTCData($fileName, $itemMeta);
		$this->processXMPData($fileName, $itemMeta);

		$this->signalSlotDispatcher->dispatch(__CLASS__, 'processMetaData',array('metaData' => &$itemMeta, 'fileName' => $fileName));

		return $itemMeta;
	}



	/**
	 * @param $itemMeta
	 */
	protected function setDefaults($itemMeta) {
		$itemMeta->setCaptureDate(new DateTime('01.01.0000 0:0:0'));
	}



	/**
	 * @param $fileName
	 * @param Tx_Yag_Domain_Model_ItemMeta $itemMeta
	 */
	protected function processExifData($fileName, Tx_Yag_Domain_Model_ItemMeta $itemMeta) {
		$exifData = $this->exifParser->parseExifData($fileName);
		$itemMeta->setExif(serialize($exifData));

		$itemMeta->setAperture($exifData['ApertureValue']);
		$itemMeta->setCameraModel($exifData['Make'] . ' - ' . $exifData['Model']);
		$itemMeta->setDescription($exifData['ImageDescription']);
		$itemMeta->setFlash($exifData['Flash']);
		$itemMeta->setFocalLength($exifData['FocalLength']);
		$itemMeta->setIso((int) $exifData['ISOSpeedRatings']);
		$itemMeta->setShutterSpeed($exifData['ShutterSpeedValue']);

		$itemMeta->setGpsLatitude($exifData['GPSLong']);
		$itemMeta->setGpsLongitude($exifData['GPSLat']);

		try {
			$itemMeta->setCaptureDate(new DateTime('@' . $exifData['CaptureTimeStamp']));
		} catch(Exception $e) {
			t3lib_div::sysLog('Error while extracting EXIF CaptureTimeStamp from "' . $fileName . '". Error was: ' . $e->getMessage(), 'yag', 2);
		}
	}



	/**
	 * @param $fileName
	 * @param Tx_Yag_Domain_Model_ItemMeta $itemMeta
	 */
	protected function processIPTCData($fileName, Tx_Yag_Domain_Model_ItemMeta $itemMeta) {
		$iptcData = $this->iptcParser->parseIptcData($fileName);
		$itemMeta->setIptc(serialize($iptcData));

		$itemMeta->setArtist($iptcData["2#080"][0]);
		$itemMeta->setCopyright($iptcData["2#116"][0]);
		$itemMeta->setTitle(trim($iptcData["2#005"][0]));

		if(is_array($iptcData['2#025'])) $itemMeta->setKeywords(implode(',', $iptcData['2#025']));
		if(trim($iptcData["2#120"][0])) $itemMeta->setDescription($iptcData["2#120"][0]);
	}



	/**
	 * @param $fileName
	 * @param Tx_Yag_Domain_Model_ItemMeta $itemMeta
	 */
	protected function processXMPData($fileName, Tx_Yag_Domain_Model_ItemMeta $itemMeta) {

		$xmpData = $this->xmpParser->parseXmpData($fileName);

		$itemMeta->setXmp($xmpData);

		$itemMeta->setArtistMail($this->xmpParser->getXmpValueByKey($xmpData, 'Iptc4xmpCore\:CiEmailWork'));
		$itemMeta->setArtistWebsite($this->xmpParser->getXmpValueByKey($xmpData, 'Iptc4xmpCore\:CiUrlWork'));
		$itemMeta->setLens($this->xmpParser->getXmpValueByKey($xmpData, 'aux\:Lens'));
	}
}
 
?>