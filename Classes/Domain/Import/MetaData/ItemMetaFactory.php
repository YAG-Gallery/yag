<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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

namespace DL\Yag\Domain\Import\MetaData;

use DL\Yag\Domain\Model\ItemMeta;
use Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 * Factory for item meta objects.
 *
 * Factory uses meta data parsers to create an item meta object for an album item.
 *
 * @package    Domain
 * @subpackage Import\MetaData
 * @author     Daniel Lienert <typo3@lienert.cc>
 * @author     Michael Knoll <mimi@kaktusteam.de>
 */
class ItemMetaFactory {
    /**
     * @var CoreDataParser
     */
    protected $coreDataParser;


    /**
     * @var ExifParser
     */
    protected $exifParser;


    /**
     * @var IptcParser
     */
    protected $iptcParser;


    /**
     * @var XmpParser
     */
    protected $xmpParser;


    /**
     * @var Dispatcher
     */
    protected $signalSlotDispatcher;


    /**
     * @param CoreDataParser $coreDataParser
     */
    public function injectCoreDataParser( CoreDataParser $coreDataParser ) {
        $this->coreDataParser = $coreDataParser;
    }


    /**
     * @param ExifParser $exifParser
     */
    public function injectExifParser( ExifParser $exifParser ) {
        $this->exifParser = $exifParser;
    }


    /**
     * @param IptcParser $iptcParser
     */
    public function injectIptcParser( IptcParser $iptcParser ) {
        $this->iptcParser = $iptcParser;
    }


    /**
     * @param XmpParser $xmpParser
     */
    public function injectXmpParser( XmpParser $xmpParser ) {
        $this->xmpParser = $xmpParser;
    }


    /**
     * @param Dispatcher $signalSlotDispatcher
     */
    public function injectSignalSlotDispatcher( Dispatcher $signalSlotDispatcher ) {
        $this->signalSlotDispatcher = $signalSlotDispatcher;
    }


    /**
     * Create meta data object for given fileName
     *
     * @param string $fileName Path to file
     *
     * @return ItemMeta Meta Data object for file
     */
    public function createItemMetaForFile( $fileName ) {
        $itemMeta = new ItemMeta();

        $this->setDefaults( $itemMeta );
        $this->processCoreData( $fileName, $itemMeta );
        $this->processExifData( $fileName, $itemMeta );
        $this->processIPTCData( $fileName, $itemMeta );
        $this->processXMPData( $fileName, $itemMeta );

        $this->signalSlotDispatcher->dispatch( __CLASS__, 'processMetaData', array(
            'metaData' => &$itemMeta,
            'fileName' => $fileName
        ) );

        return $itemMeta;
    }


    /**
     * @param ItemMeta $itemMeta
     */
    protected function setDefaults( ItemMeta $itemMeta ) {
        $itemMeta->setCaptureDate( new \DateTime( '01.01.0000 0:0:0' ) );
    }


    /**
     * @param          $fileName
     * @param ItemMeta $itemMeta
     */
    protected function processCoreData( $fileName, ItemMeta $itemMeta ) {
        $coreData = $this->coreDataParser->parseCoreData( $fileName );
        $itemMeta->setDpi( $coreData['dpi'] );
        $itemMeta->setColorSpace( $coreData['colorSpace'] );
    }


    /**
     * @param          $fileName
     * @param ItemMeta $itemMeta
     */
    protected function processExifData( $fileName, ItemMeta $itemMeta ) {
        $exifData = $this->exifParser->parseExifData( $fileName );
        $itemMeta->setExif( serialize( $exifData ) );

        $itemMeta->setAperture( $exifData['ApertureValue'] );
        $itemMeta->setCameraModel( $exifData['Make'] . ' - ' . $exifData['Model'] );
        $itemMeta->setDescription( $exifData['ImageDescription'] );
        $itemMeta->setFlash( $exifData['Flash'] );
        $itemMeta->setFocalLength( $exifData['FocalLength'] );
        $itemMeta->setIso( (int) $exifData['ISOSpeedRatings'] );
        $itemMeta->setShutterSpeed( $exifData['ShutterSpeedValue'] );

        $itemMeta->setGpsLatitude( $exifData['GPSLong'] );
        $itemMeta->setGpsLongitude( $exifData['GPSLat'] );

        try {
            $itemMeta->setCaptureDate( new \DateTime( '@' . $exifData['CaptureTimeStamp'] ) );
        } catch ( Exception $e ) {
            GeneralUtility::sysLog( 'Error while extracting EXIF CaptureTimeStamp from "' . $fileName . '". Error was: ' . $e->getMessage(), 'yag', 2 );
        }
    }


    /**
     * @param          $fileName
     * @param ItemMeta $itemMeta
     */
    protected function processIPTCData( $fileName, ItemMeta $itemMeta ) {
        $iptcData = $this->iptcParser->parseIptcData( $fileName );
        $itemMeta->setIptc( serialize( $iptcData ) );

        $itemMeta->setArtist( $iptcData["2#080"][0] );
        $itemMeta->setCopyright( $iptcData["2#116"][0] );
        $itemMeta->setTitle( trim( $iptcData["2#005"][0] ) );

        if ( is_array( $iptcData['2#025'] ) ) {
            $itemMeta->setKeywords( implode( ',', $iptcData['2#025'] ) );
        }
        if ( trim( $iptcData["2#120"][0] ) ) {
            $itemMeta->setDescription( $iptcData["2#120"][0] );
        }
    }


    /**
     * @param          $fileName
     * @param ItemMeta $itemMeta
     */
    protected function processXMPData( $fileName, ItemMeta $itemMeta ) {
        $xmpData = $this->xmpParser->parseXmpData( $fileName );

        $itemMeta->setXmp( $xmpData );

        $itemMeta->setArtistMail( $this->xmpParser->getXmpValueByKey( $xmpData, 'Iptc4xmpCore\:CiEmailWork' ) );
        $itemMeta->setArtistWebsite( $this->xmpParser->getXmpValueByKey( $xmpData, 'Iptc4xmpCore\:CiUrlWork' ) );
        $itemMeta->setLens( $this->xmpParser->getXmpValueByKey( $xmpData, 'aux\:Lens' ) );
    }
}
