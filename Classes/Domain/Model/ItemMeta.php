<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 Michael Knoll <mimi@kaktusteam.de>
*  			Daniel Lienert <daniel@lienert.cc>
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
 * ItemMeta
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Yag_Domain_Model_ItemMeta extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * exif data of item
	 * @var string
	 */
	protected $exif;
	
	/**
	 * iptc data of item
	 * @var string
	 */
	protected $iptc;
	
	/**
	 * xmp data of item
	 * @var string
	 */
	protected $xmp;
	
	/**
	 * Name of artist
	 * @var string
	 */
	protected $artist;
	
	/**
	 * E-Mail address of artist
	 * @var string
	 */
	protected $artistMail;
	
	/**
	 * Website of artist
	 * @var string
	 */
	protected $artistWebsite;
	
	/**
	 * Copyright of item
	 * @var string
	 */
	protected $copyright;
	
	/**
	 * Camera Model used for item
	 * @var string
	 */
	protected $cameraModel;
	
	/**
	 * Lens used for item
	 * @var string
	 */
	protected $lens;
	
	/**
	 * ISO of item
	 * @var string
	 */
	protected $iso;
	
	/**
	 * Focal length used for item
	 * @var string
	 */
	protected $focalLength;
	
	/**
	 * Shutter speed used for item
	 * @var string
	 */
	protected $shutterSpeed;
	
	/**
	 * Aperture used for item
	 * @var string
	 */
	protected $aperture;
	
	/**
	 * Was a flash used when making item
	 * @var string
	 */
	protected $flash;
	
	/**
	 * GPS Latitude of item
	 * @var string
	 */
	protected $gpsLatitude;
	
	/**
	 * gpsLongitude of item
	 * @var string
	 */
	protected $gpsLongitude;
	
	/**
	 * Keywords of item
	 * @var string
	 */
	protected $keywords;
	
	/**
	 * Description of item
	 * @var string
	 */
	protected $description;
	
	/**
	 * item
	 * @var Tx_Yag_Domain_Model_Item
	 */
	protected $item;
	
	/**
	 * Setter for exif
	 *
	 * @param string $exif exif data of item
	 * @return void
	 */
	public function setExif($exif) {
		$this->exif = $exif;
	}

	/**
	 * Getter for exif
	 *
	 * @return string exif data of item
	 */
	public function getExif() {
		return $this->exif;
	}
	
	/**
	 * Setter for iptc
	 *
	 * @param string $iptc iptc data of item
	 * @return void
	 */
	public function setIptc($iptc) {
		$this->iptc = $iptc;
	}

	/**
	 * Getter for iptc
	 *
	 * @return string iptc data of item
	 */
	public function getIptc() {
		return $this->iptc;
	}
	
	/**
	 * Setter for xmp
	 *
	 * @param string $xmp xmp data of item
	 * @return void
	 */
	public function setXmp($xmp) {
		$this->xmp = $xmp;
	}

	/**
	 * Getter for xmp
	 *
	 * @return string xmp data of item
	 */
	public function getXmp() {
		return $this->xmp;
	}
	
	/**
	 * Setter for artist
	 *
	 * @param string $artist Name of artist
	 * @return void
	 */
	public function setArtist($artist) {
		$this->artist = $artist;
	}

	/**
	 * Getter for artist
	 *
	 * @return string Name of artist
	 */
	public function getArtist() {
		return $this->artist;
	}
	
	/**
	 * Setter for artistMail
	 *
	 * @param string $artistMail E-Mail address of artist
	 * @return void
	 */
	public function setArtistMail($artistMail) {
		$this->artistMail = $artistMail;
	}

	/**
	 * Getter for artistMail
	 *
	 * @return string E-Mail address of artist
	 */
	public function getArtistMail() {
		return $this->artistMail;
	}
	
	/**
	 * Setter for artistWebsite
	 *
	 * @param string $artistWebsite Website of artist
	 * @return void
	 */
	public function setArtistWebsite($artistWebsite) {
		$this->artistWebsite = $artistWebsite;
	}

	/**
	 * Getter for artistWebsite
	 *
	 * @return string Website of artist
	 */
	public function getArtistWebsite() {
		return $this->artistWebsite;
	}
	
	/**
	 * Setter for copyright
	 *
	 * @param string $copyright Copyright of item
	 * @return void
	 */
	public function setCopyright($copyright) {
		$this->copyright = $copyright;
	}

	/**
	 * Getter for copyright
	 *
	 * @return string Copyright of item
	 */
	public function getCopyright() {
		return $this->copyright;
	}
	
	/**
	 * Setter for cameraModel
	 *
	 * @param string $cameraModel Camera Model used for item
	 * @return void
	 */
	public function setCameraModel($cameraModel) {
		$this->cameraModel = $cameraModel;
	}

	/**
	 * Getter for cameraModel
	 *
	 * @return string Camera Model used for item
	 */
	public function getCameraModel() {
		return $this->cameraModel;
	}
	
	/**
	 * Setter for lens
	 *
	 * @param string $lens Lens used for item
	 * @return void
	 */
	public function setLens($lens) {
		$this->lens = $lens;
	}

	/**
	 * Getter for lens
	 *
	 * @return string Lens used for item
	 */
	public function getLens() {
		return $this->lens;
	}
	
	/**
	 * Setter for iso
	 *
	 * @param string $iso ISO of item
	 * @return void
	 */
	public function setIso($iso) {
		$this->iso = $iso;
	}

	/**
	 * Getter for iso
	 *
	 * @return string ISO of item
	 */
	public function getIso() {
		return $this->iso;
	}
	
	/**
	 * Setter for focalLength
	 *
	 * @param string $focalLength Focal length used for item
	 * @return void
	 */
	public function setFocalLength($focalLength) {
		$this->focalLength = $focalLength;
	}

	/**
	 * Getter for focalLength
	 *
	 * @return string Focal length used for item
	 */
	public function getFocalLength() {
		return $this->focalLength;
	}
	
	/**
	 * Setter for shutterSpeed
	 *
	 * @param string $shutterSpeed Shutter speed used for item
	 * @return void
	 */
	public function setShutterSpeed($shutterSpeed) {
		$this->shutterSpeed = $shutterSpeed;
	}

	/**
	 * Getter for shutterSpeed
	 *
	 * @return string Shutter speed used for item
	 */
	public function getShutterSpeed() {
		return $this->shutterSpeed;
	}
	
	/**
	 * Setter for aperture
	 *
	 * @param string $aperture Aperture used for item
	 * @return void
	 */
	public function setAperture($aperture) {
		$this->aperture = $aperture;
	}

	/**
	 * Getter for aperture
	 *
	 * @return string Aperture used for item
	 */
	public function getAperture() {
		return $this->aperture;
	}
	
	/**
	 * Setter for flash
	 *
	 * @param string $flash Was a flash used when making item
	 * @return void
	 */
	public function setFlash($flash) {
		$this->flash = $flash;
	}

	/**
	 * Getter for flash
	 *
	 * @return string Was a flash used when making item
	 */
	public function getFlash() {
		return $this->flash;
	}
	
	/**
	 * Setter for gpsLatitude
	 *
	 * @param string $gpsLatitude GPS Latitude of item
	 * @return void
	 */
	public function setGpsLatitude($gpsLatitude) {
		$this->gpsLatitude = $gpsLatitude;
	}

	/**
	 * Getter for gpsLatitude
	 *
	 * @return string GPS Latitude of item
	 */
	public function getGpsLatitude() {
		return $this->gpsLatitude;
	}
	
	/**
	 * Setter for gpsLongitude
	 *
	 * @param string $gpsLongitude gpsLongitude of item
	 * @return void
	 */
	public function setGpsLongitude($gpsLongitude) {
		$this->gpsLongitude = $gpsLongitude;
	}

	/**
	 * Getter for gpsLongitude
	 *
	 * @return string gpsLongitude of item
	 */
	public function getGpsLongitude() {
		return $this->gpsLongitude;
	}
	
	/**
	 * Setter for keywords
	 *
	 * @param string $keywords Keywords of item
	 * @return void
	 */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * Getter for keywords
	 *
	 * @return string Keywords of item
	 */
	public function getKeywords() {
		return $this->keywords;
	}
	
	/**
	 * Setter for description
	 *
	 * @param string $description Description of item
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Getter for description
	 *
	 * @return string Description of item
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * Setter for item
	 *
	 * @param Tx_Yag_Domain_Model_Item $item item
	 * @return void
	 */
	public function setItem(Tx_Yag_Domain_Model_Item $item) {
		$this->item = $item;
	}

	/**
	 * Getter for item
	 *
	 * @return Tx_Yag_Domain_Model_Item item
	 */
	public function getItem() {
		return $this->item;
	}
	
}
?>