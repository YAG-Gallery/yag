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
 * Exif parser for image meta data
 *
 * @package Domain
 * @subpackage Import\MetaData
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Import_MetaData_ExifParser extends Tx_Yag_Domain_Import_MetaData_AbstractParser implements t3lib_Singleton {
	
	/**
	 * Parses exif data from a given file
	 *
	 * @param string $filePath Path to file
	 * @return array Exif data
	 */
	public function parseExifData($filePath) {
		$exifArray = array();

		if(function_exists('exif_read_data')) {
			$exifArray = exif_read_data($filePath);

			$exifArray['ShutterSpeedValue'] = $this->calculateShutterSpeed($exifArray);
			$exifArray['ApertureValue'] = $this->calculateApertureValue($exifArray);
			$exifArray['CaptureTimeStamp'] = $this->calculateCaptureTimeStamp($exifArray);
			$exifArray['FocalLength'] = (int) $this->getFloatFromValue($exifArray['FocalLength']);
			$exifArray['ImageDescription'] = Tx_Yag_Utility_Encoding::toUTF8($exifArray['ImageDescription']);
			$exifArray['GPSLong'] = $this->getGps($exifArray["GPSLongitude"], $exifArray['GPSLongitudeRef']);
			$exifArray['GPSLat'] = $this->getGps($exifArray["GPSLatitude"], $exifArray['GPSLatitudeRef']);
		}
		
		return $exifArray;
	}


	/**
	 * @param array $exifArray
	 * @return int timeStamp
	 */
	public function calculateCaptureTimeStamp($exifArray) {
		$captureTimeStamp = 0;

		if (array_key_exists('DateTimeOriginal', $exifArray)) {
			$captureTimeStamp = strtotime($exifArray['DateTimeOriginal']);
		}

		return $captureTimeStamp;
	}


	/**
	 * @param $exif
	 * @return bool|string
	 */
	protected function calculateShutterSpeed(&$exif) {
		if (!isset($exif['ShutterSpeedValue'])) return '';
		
		$apex = $this->getFloatFromValue($exif['ShutterSpeedValue']);
		$shutter = pow(2, -$apex);
		if ($shutter == 0) return FALSE;
		if ($shutter >= 1) return round($shutter) . 's';
		return '1/' . round(1 / $shutter) . 's';
	}



	/**
	 * @param $exif
	 * @return bool|string
	 */
	protected function calculateApertureValue(&$exif) {
		if (!isset($exif['ApertureValue'])) return '';

		$apex = $this->getFloatFromValue($exif['ApertureValue']);
		$fstop = pow(2, $apex / 2);
		if ($fstop == 0) return '';

		return 'f/' . round($fstop, 1);
	}



	/**
	 * @param $value
	 * @return float
	 */
	protected function getFloatFromValue($value) {
		$pos = strpos($value, '/');
		if ($pos === FALSE) return (float)$value;

		$a = (float)substr($value, 0, $pos);
		$b = (float)substr($value, $pos + 1);

		return ($b == 0) ? ($a) : ($a / $b);
	}



	/**
	 * Original from Gerald Kaszuba / stackoverflow
	 *
	 * @param $exifCoord
	 * @param $hemi
	 * @return int
	 */
	function getGps($exifCoord, $hemi) {
		$degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
		$minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
		$seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;

		$flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

		return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
	}



	/**
	 * @param $coordPart
	 * @return float|int
	 */
	function gps2Num($coordPart) {

		$parts = explode('/', $coordPart);

		if (count($parts) <= 0)
			return 0;

		if (count($parts) == 1)
			return $parts[0];

		return floatval($parts[0]) / floatval($parts[1]);
	}
}
?>