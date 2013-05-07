<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
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
 * Class implements container for meta data for images.
 *
 * @package Domain
 * @subpackage Model
 */
class Tx_Yag_Domain_Model_ItemMeta
	extends Tx_Extbase_DomainObject_AbstractEntity
	implements Tx_Yag_Domain_Model_DomainModelInterface {
	
    /**
     * EXIF data of item
     *
     * @var string $exif
     */
    protected $exif;


    
    /**
     * IPTC data of item
     *
     * @var string $iptc
     */
    protected $iptc;



    /**
     * XMP data of item
     *
     * @var string $xmp
     */
    protected $xmp;



    /**
     * Artist who took item
     *
     * @var string $artist
     */
    protected $artist;



    /**
     * E-Mail address of artist who took item
     *
     * @var string $artistMail
     */
    protected $artistMail;



    /**
     * Website of artist who took album
     *
     * @var string $artistWebsite
     */
    protected $artistWebsite;



    /**
     * Copyright notice of item
     *
     * @var string $copyright
     */
    protected $copyright;



    /**
     * Camera model, item has been taken with
     *
     * @var string $cameraModel
     */
    protected $cameraModel;



    /**
     * Lens, item has been taken with
     *
     * @var string $lens
     */
    protected $lens;



    /**
     * Focal length, item has been taken with
     *
     * @var integer $focalLength
     */
    protected $focalLength;



    /**
     * Shutter speed, item has been taken with
     *
     * @var string $shutterSpeed
     */
    protected $shutterSpeed;



    /**
     * Aperture, item has been taken with
     *
     * @var string $aperture
     */
    protected $aperture;



    /**
     * ISO, item has been taken with
     *
     * @var integer $iso
     */
    protected $iso;



    /**
     * Holds whether flash has been used when taking item
     *
     * @var string $flash
     */
    protected $flash;



    /**
     * GPS Latitude of place where item has been taken
     *
     * @var string $gpsLatitude
     */
    protected $gpsLatitude;



    /**
     * GPS longitude of place where item has been taken
     *
     * @var string $gpsLongitude
     */
    protected $gpsLongitude;



    /**
     * Komma seperated list of keywords for item
     *
     * @var string $keywords
     */
    protected $keywords;


	/**
	 * @var string title
	 */
	protected $title;



    /**
     * Description of item
     *
     * @var string $description
     */
    protected $description;



    /**
     * Date, when item has been taken
     *
     * @var DateTime $captureDate
     */
    protected $captureDate;



    /**
     * Item to which meta data belongs to
     *
     * @lazy
     * @var Tx_Yag_Domain_Model_Item $item
     */
    protected $item;



    /**
     * Setter for exif
     *
     * @param string $exif EXIF data of item
     * @return void
     */
    public function setExif($exif) {
        $this->exif = $exif;
    }



    /**
     * Getter for exif
     *
     * @return string EXIF data of item
     */
    public function getExif() {
        return $this->exif;
    }



    /**
     * Setter for iptc
     *
     * @param string $iptc IPTC data of item
     * @return void
     */
    public function setIptc($iptc) {
        $this->iptc = $iptc;
    }



    /**
     * Getter for iptc
     *
     * @return string IPTC data of item
     */
    public function getIptc() {
        return $this->iptc;
    }



    /**
     * Setter for xmp
     *
     * @param string $xmp XMP data of item
     * @return void
     */
    public function setXmp($xmp) {
        $this->xmp = $xmp;
    }



    /**
     * Getter for xmp
     *
     * @return string XMP data of item
     */
    public function getXmp() {
        return $this->xmp;
    }



    /**
     * Setter for artist
     *
     * @param string $artist Artist who took item
     * @return void
     */
    public function setArtist($artist) {
        $this->artist = $artist;
    }



    /**
     * Getter for artist
     *
     * @return string Artist who took item
     */
    public function getArtist() {
        return $this->artist;
    }



    /**
     * Setter for artistMail
     *
     * @param string $artistMail E-Mail address of artist who took item
     * @return void
     */
    public function setArtistMail($artistMail) {
        $this->artistMail = $artistMail;
    }



    /**
     * Getter for artistMail
     *
     * @return string E-Mail address of artist who took item
     */
    public function getArtistMail() {
        return $this->artistMail;
    }



    /**
     * Setter for artistWebsite
     *
     * @param string $artistWebsite Website of artist who took album
     * @return void
     */
    public function setArtistWebsite($artistWebsite) {
        $this->artistWebsite = $artistWebsite;
    }



    /**
     * Getter for artistWebsite
     *
     * @return string Website of artist who took album
     */
    public function getArtistWebsite() {
        return $this->artistWebsite;
    }



    /**
     * Setter for copyright
     *
     * @param string $copyright Copyright notice of item
     * @return void
     */
    public function setCopyright($copyright) {
        $this->copyright = $copyright;
    }



    /**
     * Getter for copyright
     *
     * @return string Copyright notice of item
     */
    public function getCopyright() {
        return $this->copyright;
    }



    /**
     * Setter for cameraModel
     *
     * @param string $cameraModel Camera model, item has been taken with
     * @return void
     */
    public function setCameraModel($cameraModel) {
        $this->cameraModel = $cameraModel;
    }



    /**
     * Getter for cameraModel
     *
     * @return string Camera model, item has been taken with
     */
    public function getCameraModel() {
        return $this->cameraModel;
    }



    /**
     * Setter for lens
     *
     * @param string $lens Lens, item has been taken with
     * @return void
     */
    public function setLens($lens) {
        $this->lens = $lens;
    }



    /**
     * Getter for lens
     *
     * @return string Lens, item has been taken with
     */
    public function getLens() {
        return $this->lens;
    }



    /**
     * Setter for focalLength
     *
     * @param integer $focalLength Focal length, item has been taken with
     * @return void
     */
    public function setFocalLength($focalLength) {
        $this->focalLength = $focalLength;
    }

    /**
     * Getter for focalLength
     *
     * @return integer Focal length, item has been taken with
     */
    public function getFocalLength() {
        return $this->focalLength;
    }



    /**
     * Setter for shutterSpeed
     *
     * @param string $shutterSpeed Shutter speed, item has been taken with
     * @return void
     */
    public function setShutterSpeed($shutterSpeed) {
        $this->shutterSpeed = $shutterSpeed;
    }



    /**
     * Getter for shutterSpeed
     *
     * @return string Shutter speed, item has been taken with
     */
    public function getShutterSpeed() {
        return $this->shutterSpeed;
    }



    /**
     * Setter for aperture
     *
     * @param string $aperture Aperture, item has been taken with
     * @return void
     */
    public function setAperture($aperture) {
        $this->aperture = $aperture;
    }



    /**
     * Getter for aperture
     *
     * @return string Aperture, item has been taken with
     */
    public function getAperture() {
        return $this->aperture;
    }



    /**
     * Setter for iso
     *
     * @param integer $iso ISO, item has been taken with
     * @return void
     */
    public function setIso($iso) {
        $this->iso = $iso;
    }



    /**
     * Getter for iso
     *
     * @return integer ISO, item has been taken with
     */
    public function getIso() {
        return $this->iso;
    }



    /**
     * Setter for flash
     *
     * @param string $flash Holds whether flash has been used when taking item
     * @return void
     */
    public function setFlash($flash) {
        $this->flash = $flash;
    }



    /**
     * Getter for flash
     *
     * @return string Holds whether flash has been used when taking item
     */
    public function getFlash() {
        return $this->flash;
    }



    /**
     * Setter for gpsLatitude
     *
     * @param string $gpsLatitude GPS Latitude of place where item has been taken
     * @return void
     */
    public function setGpsLatitude($gpsLatitude) {
        $this->gpsLatitude = $gpsLatitude;
    }



    /**
     * Getter for gpsLatitude
     *
     * @return string GPS Latitude of place where item has been taken
     */
    public function getGpsLatitude() {
        return $this->gpsLatitude;
    }



    /**
     * Setter for gpsLongitude
     *
     * @param string $gpsLongitude GPS longitude of place where item has been taken
     * @return void
     */
    public function setGpsLongitude($gpsLongitude) {
        $this->gpsLongitude = $gpsLongitude;
    }



    /**
     * Getter for gpsLongitude
     *
     * @return string GPS longitude of place where item has been taken
     */
    public function getGpsLongitude() {
        return $this->gpsLongitude;
    }



    /**
     * Setter for keywords
     *
     * @param string $keywords Komma seperated list of keywords for item
     * @return void
     */
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }



    /**
     * Getter for keywords
     *
     * @return string Komma seperated list of keywords for item
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
     * Setter for captureDate
     *
     * @param DateTime $captureDate Date, when item has been taken
     * @return void
     */
    public function setCaptureDate(DateTime $captureDate) {
        $this->captureDate = $captureDate;
    }



    /**
     * Getter for captureDate
     *
     * @return DateTime Date, when item has been taken
     */
    public function getCaptureDate() {
        return $this->captureDate;
    }



    /**
     * Setter for item
     *
     * @param Tx_Yag_Domain_Model_Item $item Item to which meta data belongs to
     * @return void
     */
    public function setItem(Tx_Yag_Domain_Model_Item $item) {
        $this->item = $item;
    }



    /**
     * Getter for item
     *
     * @return Tx_Yag_Domain_Model_Item Item to which meta data belongs to
     */
    public function getItem() {
        return $this->item;
    }


	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}


	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}


	/**
	 * @return array
	 */
	public function getAttributeArray() {
		$exclude = array('exif', 'iptc', 'xmp', 'item');
		$properties = array();

		foreach(get_object_vars($this) as $key => $value) {
			if(!in_array($key, $exclude)) {
				$properties[$key] = $value;
			}
		}

		return $properties;
	}
}
?>