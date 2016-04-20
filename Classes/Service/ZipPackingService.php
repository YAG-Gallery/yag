<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Daniel Lienert <typo3@lienert.cc>
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

namespace DL\Yag\Service;

use DL\Yag\Domain\Configuration\ConfigurationBuilder;
use DL\Yag\Domain\Configuration\Image\ResolutionConfig;
use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Domain\Model\Item;

class ZipPackingService {
    /**
     * @var \Tx_PtExtlist_Domain_Model_List_ListData
     */
    protected $itemListData;


    /**
     * @var ConfigurationBuilder
     */
    protected $configurationBuilder;


    /**
     * @var string
     */
    protected $fileNameFormat;


    /**
     * @var string
     */
    protected $resolutionIdentifier;


    /**
     * @var string
     */
    protected $fileNameVariableArray;


    /**
     * @var Div
     */
    protected $fileSystemDiv;


    /**
     * @param Div $fileSystemDiv
     */
    public function injectFileSystemDiv( Div $fileSystemDiv ) {
        $this->fileSystemDiv = $fileSystemDiv;
    }


    /**
     * @param ConfigurationBuilder $configurationBuilder
     */
    public function _injectConfigurationBuilder( ConfigurationBuilder $configurationBuilder ) {
        $this->configurationBuilder = $configurationBuilder;
        $this->initializeSettings();
    }


    /**
     * initialize the local settings
     */
    public function initializeSettings() {
        $zipDownloadSettings = $this->configurationBuilder->buildItemListConfiguration()->getZipDownloadSettings();

        if ( ! array_key_exists( 'resolution', $zipDownloadSettings ) ) {
            throw new Exception( 'Resolution was not defined in zipDownloadSettings', 1367155503 );
        }
        $this->resolutionIdentifier = $zipDownloadSettings['resolution'];

        if ( ! array_key_exists( 'fileNameFormat', $zipDownloadSettings ) ) {
            throw new Exception( 'FileNameFormat was not defined in zipDownloadSettings', 1367155504 );
        }
        $this->fileNameFormat = $zipDownloadSettings['fileNameFormat'];
    }


    /**
     * @return string
     * @throws Exception
     */
    public function buildPackage() {
        $tempFileName = tempnam( sys_get_temp_dir(), 'YagZipFile' );

        $zip = new ZipArchive();

        $zipOpenCode = $zip->open( $tempFileName, ZipArchive::CREATE );

        if ( $zipOpenCode !== true ) {
            throw new Exception( 'Unable to create a temp file for zip creation.(' . $zipOpenCode . ')', 1367131215 );
        }

        foreach ( $this->itemListData as $listRow ) {
            /** @var \Tx_PtExtlist_Domain_Model_List_Row $listRow */
            $item = $listRow->getCell( 'image' )->getValue();
            /** @var Item $item */
            $zip->addFile( $this->getFilePathOfResolution( $item ), $item->getOriginalFilename() );
        }

        if ( $zip->close() !== true ) {
            throw new Exception( 'Unable to generate the zip file', 1367131456 );
        }

        return $tempFileName;
    }


    /**
     * @param Item $item
     *
     * @return string
     */
    protected function getFilePathOfResolution( Item $item ) {
        if ( $this->resolutionIdentifier === 'original' ) {
            return Div::makePathAbsolute( $item->getSourceuri() );
        } else {
            return Div::makePathAbsolute( $item->getResolutionByConfig( $this->getRequestedResolutionConfig() )->getPath() );
        }
    }


    /**
     * @return ResolutionConfig
     */
    protected function getRequestedResolutionConfig() {
        return $this->configurationBuilder->buildThemeConfiguration()->getResolutionConfigCollection()->getResolutionConfig( $this->resolutionIdentifier );
    }


    /**
     * @return string
     */
    public function getFileName() {
        $parameters = array();

        if ( $this->itemListData->count() > 0 ) {
            $item = $this->itemListData->getFirstRow()->getCell( 'image' )->getValue();
            /** @var Item $item */

            $parameters = array(
                'album'   => $item->getAlbum()->getName(),
                'gallery' => $item->getAlbum()->getGallery()->getName()
            );
        }

        $formattedFileName = \Tx_PtExtlist_Utility_RenderValue::renderDataByConfigArray( $parameters, $this->fileNameFormat );
        if ( substr( strtolower( $formattedFileName ), - 4, 4 ) != '.zip' ) {
            $formattedFileName .= '.zip';
        }
        $formattedFileName = $this->fileSystemDiv->cleanFileName( $formattedFileName );

        return $formattedFileName;
    }


    /**
     * @param \Tx_PtExtlist_Domain_Model_List_ListData $itemListData
     */
    public function setItemListData( $itemListData ) {
        $this->itemListData = $itemListData;
    }
}
