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

use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\Configuration\Image\SysImageConfig;
use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Domain\Model\Item;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Repository for Item
 *
 * @package    Domain
 * @subpackage Repository
 * @author     Michael Knoll
 * @author     Daniel Lienert
 */
class ItemRepository extends AbstractRepository {
    /**
     * Get the "image not found" default image
     *
     * @param $sysImageConfigName
     *
     * @return Item
     * @throws Exception
     */
    public function getSystemImage( $sysImageConfigName ) {
        $configurationBuilder     = ConfigurationBuilderFactory::getInstance();
        $sysImageConfigCollection = $configurationBuilder->buildSysImageConfiguration();

        if ( ! $sysImageConfigCollection->hasItem( $sysImageConfigName ) ) {
            throw new Exception( 'No system image configuration with name ' . $sysImageConfigName . ' found!', 1298832340 );
        }

        $sysImageConfig = $sysImageConfigCollection->getSysImageConfig( $sysImageConfigName );

        $sysImage = $this->findOneBySourceuri( $sysImageConfig->getSourceUri() );

        if ( $sysImage ) {
            return $sysImage;
        } else {
            return $this->createNewSystemImage( $sysImageConfig );
        }
    }


    /**
     * Create and return a new System Image
     * This image is persisted in the image database
     *
     * @param SysImageConfig $sysImageConfig
     *
     * @return Item
     */
    protected function createNewSystemImage( SysImageConfig $sysImageConfig ) {
        $sysImage = GeneralUtility::makeInstance( 'Item' );
        $sysImage->setSourceuri( $sysImageConfig->getSourceUri() );
        $sysImage->setFilename( basename( $sysImageConfig->getSourceUri() ) );
        $sysImage->setTitle( $sysImageConfig->getTitle() );
        $sysImage->setDescription( $sysImageConfig->getDescription() );

        list( $width, $height, $type, $attr ) = getimagesize( Div::makePathAbsolute( $sysImageConfig->getSourceUri() ) );
        $sysImage->setWidth( $width );
        $sysImage->setHeight( $height );

        $this->add( $sysImage );

        return $sysImage;
    }


    /**
     * @param ResolutionConfigCollection $resolutionConfigCollection
     * @param                            $count
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findImagesWithUnRenderedResolutions( ResolutionConfigCollection $resolutionConfigCollection, $count ) {
        $statement = $this->buildQueryStatementForImagesWithUnRenderedResolutions( $resolutionConfigCollection, $count );

        return $this->createQuery()->statement( $statement )->execute();
    }


    /**
     * @param ResolutionConfigCollection $resolutionConfigCollection
     *
     * @return integer
     */
    public function countImagesWithUnRenderedResolutions( ResolutionConfigCollection $resolutionConfigCollection ) {
        $statement = $this->buildQueryStatementForImagesWithUnRenderedResolutions( $resolutionConfigCollection );
        $result    = $this->createQuery()->statement( str_replace( 'SELECT item.*', 'SELECT count(*) as c', $statement ) )->execute( true );

        return $result[0]['c'];
    }


    /**
     * @param ResolutionConfigCollection $resolutionConfigCollection
     * @param                            $count
     *
     * @return string
     */
    protected function buildQueryStatementForImagesWithUnRenderedResolutions( ResolutionConfigCollection $resolutionConfigCollection, $count = 0 ) {
        $resolutionCount          = $resolutionConfigCollection->count();
        $resolutionParamHashArray = array();

        foreach ( $resolutionConfigCollection as $resolutionConfig ) {
            /** @var ResolutionConfig $resolutionConfig */
            $resolutionParamHashArray[] = $resolutionConfig->getParameterHash();
        }

        $resolutionParamHashCSV = "'" . implode( "','", $resolutionParamHashArray ) . "'";
        $statementTemplate      = "SELECT item.*, rescache.rescount FROM item item
								LEFT JOIN
								(SELECT resolutionfilecache.item, count(*) rescount
								FROM `resolutionfilecache`
								WHERE resolutionfilecache.paramhash IN (%s)
								GROUP BY resolutionfilecache.item) as rescache
								ON rescache.item = item.uid
								WHERE rescount < %s OR isnull(rescount)";

        $statementTemplate .= $count > 0 ? 'LIMIT 0, %s' : '';

        return sprintf( $statementTemplate, $resolutionParamHashCSV, $resolutionCount, $count );
    }


    /**
     * Get the item which is in the database after the given item
     *
     * @param Item $item
     * @param int  $limit of items to return
     *
     * @return Item $item
     */
    public function getItemsAfterThisItem( Item $item = null, $limit = 1 ) {
        $itemUid = $item ? $item->getUid() : 0;

        $query  = $this->createQuery();
        $result = $query->matching( $query->greaterThan( 'uid', $itemUid ) )
                        ->setLimit( $limit )
                        ->execute();

        $object = null;
        if ( $result->count() == 0 ) {
            return false;
        } elseif ( $result->count() == 1 && $result->current() !== false ) {
            $object  = $result->current();
            $session = $this->objectManager->get( 'TYPO3\CMS\Extbase\Persistence\Generic\Session' );
            $session->registerObject( $object, $object->getUid() );

            return $object;
        } else {
            return $result;
        }
    }


    /**
     * Get the sum of the size of all images, that are handled by YAG
     *
     * @return int
     */
    public function getItemSizeSum() {
        $query  = $this->createQuery();
        $result = $query->statement( 'SELECT sum(filesize) as sumFileSize
									FROM item
									WHERE deleted = 0' )->execute( true );

        return $result[0]['sumFileSize'];
    }


    /**
     * Count all items that belong to a gallery
     *
     * @param Gallery $gallery
     *
     * @return int
     */
    public function countItemsInGallery( Gallery $gallery ) {
        $query = $this->createQuery();

        $statement = 'SELECT count(*) as sumItems FROM `item` item
									INNER JOIN `album` album ON item.album = album.uid
									WHERE album.gallery = %s
									AND album.deleted = 0 AND album.hidden = 0 
									AND item.deleted = 0 AND item.hidden = 0 AND item.l18n_parent = 0';
        $result    = $query->statement( sprintf( $statement, $gallery->getUid() ) )->execute( true );

        return (int) $result[0]['sumItems'];
    }


    /**
     * Returns a sorted list of items for given album, sorting field and sorting direction.
     *
     * Sorting of item is set on returned collection of items!
     *
     * @param Album  $album
     * @param string $sortingField
     * @param string $sortingDirection
     *
     * @return array
     */
    public function getSortedItemsByAlbumFieldAndDirection( Album $album, $sortingField, $sortingDirection ) {
        $sortings = array( $sortingField => $sortingDirection );
        $query    = $this->createQuery();
        $query->matching( $query->equals( 'album', $album ) )
              ->setOrderings( $sortings );
        $items = $query->execute();

        $sortingNumber = 0;
        foreach ( $items as $item ) {
            /* @var $item Item */
            $item->setSorting( $sortingNumber );
            $sortingNumber ++;
        }

        return $items;
    }


    /**
     * Returns item with highest sorting for given album
     *
     * @param Album $album
     *
     * @return array|Tx_Extbase_Persistence_QueryResultInterface
     */
    public function getItemWithMaxSortingForAlbum( Album $album ) {
        $query = $this->createQuery();
        $query->matching( $query->equals( 'album', $album ) );
        $query->setOrderings( array( 'sorting' => QueryInterface::ORDER_DESCENDING ) );
        $query->setLimit( 1 );

        return $query->execute();
    }


    /**
     * @param $uidArray
     *
     * @return array|Tx_Extbase_Persistence_QueryResultInterface
     */
    public function getItemsByUids( $uidArray ) {
        $query = $this->createQuery();
        $query->matching( $query->in( 'uid', $uidArray ) );
        $result = $query->execute();

        $sortedResult = array();

        foreach ( $result as $item ) {
            /** @var Item $item */
            $position                  = array_search( $item->getUid(), $uidArray );
            $sortedResult[ $position ] = $item;
        }

        ksort( $sortedResult );

        return $sortedResult;
    }


    /**
     * This method keeps translated items in sync when properties of the original items (sorting / delete)
     * was changed in the gallery module.
     */
    public function syncTranslatedItems() {
        $this->persistenceManager->persistAll();

        $this->createQuery()->statement(
            'UPDATE item translatedItem
			INNER JOIN item parentItem ON translatedItem.l18n_parent = parentItem.uid
			SET translatedItem.sorting = parentItem.sorting, translatedItem.deleted = parentItem.deleted
			WHERE translatedItem.l18n_parent != 0
			AND (translatedItem.sorting != parentItem.sorting OR translatedItem.deleted != parentItem.deleted);
		' )->execute();
    }


    /**
     * Returns a random set of images for a given number, gallery and album
     *
     * @param     $numberOfItems Sets number of items to be returned
     * @param int $galleryUid    Gallery UID to take images from
     * @param int $albumUid      Album UID to take images from
     *
     * @return array<Item>
     */
    public function getRandomItems( $numberOfItems, $galleryUid = 0, $albumUid = 0 ) {
        return $this->getItemsByUids( $this->getRandomItemUIDs( $numberOfItems, $galleryUid, $albumUid ) );
    }


    /**
     * @param     $randomItemCount
     * @param int $galleryUid
     * @param int $albumUid
     *
     * @return array
     */
    public function getRandomItemUIDs( $randomItemCount, $galleryUid = 0, $albumUid = 0 ) {
        $randomItemUIDs        = array();
        $itemPositionWhiteList = array();

        $galleryUid = (int) $galleryUid;
        $albumUid   = (int) $albumUid;

        /**
         * Build Query Parts
         */
        $additionalJoins = '';

        $additionalWhere = ' item.album > 0 '; // Only show images with connection to an album (itemNotFoundEntries have non)
        $additionalWhere .= $this->getTypo3SpecialFieldsWhereClause( array( 'item' ) ) . ' ';

        if ( $albumUid || $galleryUid ) {
            $additionalJoins .= ' INNER JOIN album ON item.album = album.uid ';
        }

        if ( $albumUid ) {
            $additionalWhere .= ' AND album.uid = ' . $albumUid . ' ';
            $additionalWhere .= $this->getTypo3SpecialFieldsWhereClause( array( 'album' ) ) . ' ';
        }

        if ( $galleryUid ) {
            $additionalJoins .= ' INNER JOIN gallery ON gallery.uid = album.gallery ';
            $additionalWhere .= ' AND album.gallery = ' . $galleryUid . ' ';
            $additionalWhere .= $this->getTypo3SpecialFieldsWhereClause( array( 'gallery' ) ) . ' ';
        }


        /*
         * Get the overall itemCount
         */
        $countStatement = "SELECT count(*) as itemCount
							FROM item
							%s
							WHERE %s";
        $countStatement = sprintf( $countStatement, $additionalJoins, $additionalWhere );

        $query = $this->createQuery();

        $countResult = $query->statement( $countStatement )->execute( true );
        $itemCount   = $countResult[0]['itemCount'];

        if ( $randomItemCount > $itemCount ) {
            $randomItemCount = $itemCount;
        }


        /**
         * Select the items
         */
        $selectStatementTemplate = "SELECT item.uid as itemUid
							FROM item
							%s
							WHERE %s
							LIMIT %s, 1";

        for ( $i = 0; $i < $randomItemCount; $i ++ ) {
            $itemPosition = $this->pickRandomItem( $itemCount, $itemPositionWhiteList );

            if ( $itemPosition !== null ) {
                $selectStatement = sprintf( $selectStatementTemplate, $additionalJoins, $additionalWhere, $itemPosition );

                $result           = $query->statement( $selectStatement )->execute( true );
                $randomItemUIDs[] = $result[0]['itemUid'];
            }
        }

        return $randomItemUIDs;
    }


    /**
     * Pick a random image position. If a pick hits an already selected position, retry 10 times
     *
     * @param $itemCount
     * @param $itemPositionWhiteList
     *
     * @return int
     */
    protected function pickRandomItem( $itemCount, &$itemPositionWhiteList ) {
        if ( ! isset( $itemPositionWhiteList ) || count( $itemPositionWhiteList ) == 0 ) {
            $itemPositionWhiteList = range( 0, $itemCount - 1 );
        }

        $itemPosition = array_rand( $itemPositionWhiteList );

        unset( $itemPositionWhiteList[ $itemPosition ] );

        return $itemPosition;
    }
}
