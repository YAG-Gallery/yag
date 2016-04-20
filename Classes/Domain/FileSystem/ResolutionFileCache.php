<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
 *           Daniel Lienert <typo3@lienert.cc>
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

namespace DL\Yag\Domain\FileSystem;

use DL\Yag\Domain\Configuration\ConfigurationBuilder;
use DL\Yag\Domain\Configuration\Image\ResolutionConfig;
use DL\Yag\Domain\Configuration\Theme\ThemeConfiguration;
use DL\Yag\Domain\ImageProcessing\AbstractProcessor;
use DL\Yag\Domain\Model\Item;
use DL\Yag\Domain\Repository\ResolutionFileCacheRepository;

/**
 * @package    Domain
 * @subpackage FileSystem
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
class ResolutionFileCache {
    /**
     * @var ResolutionFileCacheRepository
     */
    protected $resolutionFileCacheRepository;


    /**
     * @var HashFileSystem
     */
    protected $hashFileSystem;


    /**
     * @var AbstractProcessor
     */
    protected $imageProcessor;


    /**
     *  Configurationbuilder
     * @var ConfigurationBuilder
     */
    protected $configurationBuilder;


    /**
     * Acts as 1st level cache to avoid rendering the same
     * image (eg the file-not-found image) multiple times in one run
     * without saving it to the database
     *
     * @var array of \DL\Yag\Domain\Model\ResolutionFileCache
     */
    protected $localResolutionFileCache = array();


    /**
     * Inject resolution file cache
     *
     * @param ResolutionFileCacheRepository $resolutionFileCacheRepository
     */
    public function injectResolutionFileCacheRepository( ResolutionFileCacheRepository $resolutionFileCacheRepository ) {
        $this->resolutionFileCacheRepository = $resolutionFileCacheRepository;
    }


    /**
     * Inject hash file system
     *
     * @param HashFileSystem $hashFileSystem
     */
    public function _injectHashFileSystem( HashFileSystem $hashFileSystem ) {
        $this->hashFileSystem = $hashFileSystem;
    }


    /**
     * Inject resolution file cache
     *
     * @param AbstractProcessor $imageProcessor
     */
    public function _injectImageProcessor( AbstractProcessor $imageProcessor ) {
        $this->imageProcessor = $imageProcessor;
    }


    /**
     * @param ConfigurationBuilder $configurationBuilder
     */
    public function _injectConfigurationBuilder( ConfigurationBuilder $configurationBuilder ) {
        $this->configurationBuilder = $configurationBuilder;
    }


    /**
     * Get a file resolution
     *
     * @param Item             $item
     * @param ResolutionConfig $resolutionConfiguration
     *
     * @return ResolutionFileCache
     */
    public function getItemFileResolutionPathByConfiguration( Item $item, ResolutionConfig $resolutionConfiguration ) {
        $resolutionFile = $this->getResolutionFileFromLocalCache( $resolutionConfiguration, $item );

        if ( $resolutionFile == null ) {
            $resolutionFile = $this->resolutionFileCacheRepository->getResolutionByItem( $item, $resolutionConfiguration );
        }

        if ( $resolutionFile == null || ! file_exists( Div::makePathAbsolute( $resolutionFile->getPath() ) ) ) {
            $resolutionFile = $this->imageProcessor->generateResolution( $item, $resolutionConfiguration );
        }

        $this->addResolutionFiletoLocalCache( $resolutionFile );

        return $resolutionFile;
    }


    /**
     * @param                    array <\Tx_PtExtlist_Domain_Model_List_Row> $itemArray
     * @param ThemeConfiguration $themeConfiguration
     *
     * @return void
     */
    public function preloadCacheForItemsAndTheme( $itemArray, ThemeConfiguration $themeConfiguration ) {
        $imageArray         = array();
        $parameterHashArray = array();

        foreach ( $itemArray as $item ) {
            if ( is_a( $item, '\Tx_PtExtlist_Domain_Model_List_Row' ) && is_a( $item['image']->getValue(), 'Item' ) ) {
                $item                          = $item['image']->getValue();
                $imageArray[ $item->getUid() ] = $item;
            }
        }

        foreach ( $themeConfiguration->getResolutionConfigCollection() as $resolutionConfig ) {
            /** @var $resolutionConfig ResolutionConfig */
            $parameterHashArray[] = $resolutionConfig->getParameterHash();
        }

        $resolutions = $this->resolutionFileCacheRepository->getResolutionsByItems( $imageArray, $parameterHashArray );
        foreach ( $resolutions as $resolution ) {
            /** @var $resolution ResolutionFileCache */
            if ( is_a( $resolution, 'ResolutionFileCache' ) ) {
                $this->addResolutionFiletoLocalCache( $resolution );
            }
        }
    }


    /**
     * Retrieve a resolution file from local cache
     *
     * @param ResolutionConfig $resolutionConfiguration
     * @param Item             $item
     *
     * @return ResolutionFileCache|null
     */
    protected function getResolutionFileFromLocalCache( ResolutionConfig $resolutionConfiguration, Item $item ) {
        $objectIdentifier = md5( $resolutionConfiguration->getParameterHash() . $item->getSourceuri() );

        if ( array_key_exists( $objectIdentifier, $this->localResolutionFileCache ) ) {
            return $this->localResolutionFileCache[ $objectIdentifier ];
        }

        return null;
    }


    /**
     * Add cachefileobjrct to local cache
     *
     * @param \DL\Yag\Domain\Model\ResolutionFileCache $cacheFileObject
     */
    protected function addResolutionFiletoLocalCache( \DL\Yag\Domain\Model\ResolutionFileCache $cacheFileObject ) {
        $objectIdentifier                                    = md5( $cacheFileObject->getParamhash() . $cacheFileObject->getItem()->getSourceuri() );
        $this->localResolutionFileCache[ $objectIdentifier ] = $cacheFileObject;
    }


    /**
     * @param Item $item
     * @param      $resolutionConfigs ResolutionConfigCollection
     */
    public function buildResolutionFilesForItem( Item $item, ResolutionConfigCollection $resolutionConfigs = null ) {
        if ( $resolutionConfigs == null ) {
            $resolutionConfigs = ResolutionConfigCollectionFactory::getInstanceOfAllThemes( $this->configurationBuilder );
        }

        foreach ( $resolutionConfigs as $resolutionConfig ) {
            $this->getItemFileResolutionPathByConfiguration( $item, $resolutionConfig );
        }
    }


    /**
     * Clear the whole resolutionFileCache
     * - Truncate the cache table
     * - Remove alle files from the cache directory
     */
    public function clear() {
        $GLOBALS['TYPO3_DB']->sql_query( 'TRUNCATE resolutionfilecache' );

        $cacheDirectoryRoot = $this->configurationBuilder->buildExtensionConfiguration()->getHashFilesystemRootAbsolute();
        Div::rRMDir( $cacheDirectoryRoot );
    }


    /**
     * @return int file count
     */
    public function getCacheFileCount() {
        return $this->resolutionFileCacheRepository->countAll();
    }


    /**
     * @return int CacheSize
     */
    public function getCacheSize() {
        $cacheDirectoryRoot = $this->configurationBuilder->buildExtensionConfiguration()->getHashFilesystemRootAbsolute();

        return Div::getDirSize( $cacheDirectoryRoot );
    }
}
