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

namespace DL\Yag\Domain\Repository;

use DL\Yag\Domain\Configuration\Image\ResolutionConfig;
use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Domain\Model\Item;
use DL\Yag\Domain\Model\ResolutionFileCache;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for ResolutionFileCache
 *
 * @package    Domain
 * @subpackage Repository
 * @author     Daniel Lienert <lienert@punkt.de>
 * @author     Michael Knoll <mimi@kaktusteam.de>
 */
class ResolutionFileCacheRepository extends Repository {
    /**
     * Set to false --> pidDetector is NOT respected
     * @var bool
     */
    protected $respectPidDetector = false;


    /**
     * This counter is not save for concurrent requests!
     * It supports the hashFileSystem to spread the item-ids over the hash file-system
     * @var integer
     */
    protected $internalObjectCounter = 0;


    /**
     * Persist the cache after n items. If the server process
     * gets killed while rendering a large page, the processed data
     * does not get lost.
     *
     * @var integer
     */
    protected $persistCacheAfterItems = 10;


    /**
     * Sets the respect storage page to false.
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct( ObjectManagerInterface $objectManager ) {
        parent::__construct( $objectManager );
        $this->defaultQuerySettings = new Typo3QuerySettings();
        $this->defaultQuerySettings->setRespectStoragePage( false );
        $this->defaultQuerySettings->setRespectSysLanguage( false );
    }


    /**
     * TODO: Find out why this method is called also when it not exists ...
     */
    public function initializeObject() {
    }


    /**
     * Get the item file resolution object
     *
     * @param Item             $item
     * @param ResolutionConfig $resolutionConfiguration
     *
     * @return ResolutionFileCache
     */
    public function getResolutionByItem( Item $item, ResolutionConfig $resolutionConfiguration ) {
        $query       = $this->createQuery();
        $constraints = array();

        $constraints[] = $query->equals( 'item', $item->getUid() );
        $constraints[] = $query->equals( 'paramhash', $resolutionConfiguration->getParameterHash() );

        $result = $query->matching( $query->logicalAnd( $constraints ) )->execute();

        $object = null;

        if ( $result !== null && ! is_array( $result ) && $result->current() !== false ) {
            $object  = $result->current();
            $session = $this->objectManager->get( 'TYPO3\CMS\Extbase\Persistence\Generic\Session' );
            $session->registerObject( $object, $object->getUid() );
        }

        return $object;
    }


    /**
     * @param       array               <\DL\Yag\Domain\Model\Item>
     * @param array $parameterHashArray <\DL\Yag\Domain\Model\ResolutionFileCache>
     *
     * @return array
     */
    public function getResolutionsByItems( array $itemArray, array $parameterHashArray ) {
        if ( count( $itemArray ) === 0 || count( $parameterHashArray ) === 0 ) {
            return array();
        }

        $query          = $this->createQuery();
        $constraints    = array();
        $fileCacheArray = array();

        $constraints[] = $query->in( 'item', array_keys( $itemArray ) );
        $constraints[] = $query->in( 'paramhash', $parameterHashArray );

        $result = $query->matching( $query->logicalAnd( $constraints ) )->execute( true );

        if ( $result !== null ) {
            foreach ( $result as $row ) {
                if ( is_a( $itemArray[ $row['item'] ], 'Item' ) ) {
                    $fileCacheArray[ $row['uid'] ] = new ResolutionFileCache(
                        $itemArray[ $row['item'] ],
                        $row['path'],
                        $row['width'],
                        $row['height'],
                        $row['paramhash']
                    );
                }
            }
        }

        return $fileCacheArray;
    }


    /**
     * Removes all cached files for a given item
     *
     * @param Item $item Item to remove cached files for
     */
    public function removeByItem( Item $item ) {
        $query = $this->createQuery();
        $query->matching( $query->equals( 'item', $item->getUid() ) );
        $cachedFilesForItem = $query->execute();

        foreach ( $cachedFilesForItem as $cachedFileForItem ) {
            /* @var $cachedFileForItem ResolutionFileCache */
            $this->remove( $cachedFileForItem );
        }
    }


    /**
     * Removes resolution file cache object and file from filesystem
     *
     * @param ResolutionFileCache $resolutionFileCache
     */
    public function remove( $resolutionFileCache ) {
        $cacheFilePath = Div::getT3BasePath() . $resolutionFileCache->getPath();
        if ( file_exists( $cacheFilePath ) ) {
            unlink( Div::getT3BasePath() . $resolutionFileCache->getPath() );
            parent::remove( $resolutionFileCache );
        }
    }


    /**
     * @param object $object
     */
    public function add( $object ) {
        $this->internalObjectCounter ++;
        parent::add( $object );

        if ( $this->internalObjectCounter % $this->persistCacheAfterItems === 0 ) {
            $this->persistenceManager->persistAll();
        }
    }


    /**
     * Calculates the next uid that would be given to
     * a resolutionFileCache record
     *
     */
    public function getCurrentUid() {
        $itemsInDatabase = $this->countAll();

        return $itemsInDatabase + $this->internalObjectCounter;
    }
}
