<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
*           Daniel Lienert <daniel@lienert.cc>
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
 * Repository for Tx_Yag_Domain_Model_Item
 *
 * @package Domain
 * @subpackage Repository
 * @author Michael Knoll
 * @author Daniel Lienert
 */
class Tx_Yag_Domain_Repository_ItemRepository extends Tx_Yag_Domain_Repository_AbstractRepository {

	/**
	 * Get the "image not found" default image
	 * 
	 * @param $sysImageConfigName
	 * @return Tx_Yag_Domain_Model_Item
	 * @throws Exception
	 */
	public function getSystemImage($sysImageConfigName) {
		
		$configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance();
		$sysImageConfigCollection = $configurationBuilder->buildSysImageConfiguration();
		
		if(!$sysImageConfigCollection->hasItem($sysImageConfigName)) {
			throw new Exception('No system image configuration with name ' . $sysImageConfigName . ' found!', 1298832340);
		}
		
		$sysImageConfig = $sysImageConfigCollection->getSysImageConfig($sysImageConfigName);
		
		$sysImage = $this->findOneBySourceuri($sysImageConfig->getSourceUri());
		
		if($sysImage) {
			return $sysImage;
		} else {
			return $this->createNewSystemImage($sysImageConfig);
		}
	}
	
	

	/**
	 * Create and return a new System Image
	 * This image is persisted in the image database
	 * 
	 * @param Tx_Yag_Domain_Configuration_Image_SysImageConfig $sysImageConfig
	 * @return Tx_Yag_Domain_Model_Item
	 */
	protected function createNewSystemImage(Tx_Yag_Domain_Configuration_Image_SysImageConfig $sysImageConfig) {
		$sysImage = t3lib_div::makeInstance('Tx_Yag_Domain_Model_Item');
		$sysImage->setSourceuri($sysImageConfig->getSourceUri());
		$sysImage->setFilename(basename($sysImageConfig->getSourceUri()));
		$sysImage->setTitle($sysImageConfig->getTitle());
		$sysImage->setDescription($sysImageConfig->getDescription());
		
		list($width, $height, $type, $attr) = getimagesize(Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($sysImageConfig->getSourceUri()));
		$sysImage->setWidth($width);
		$sysImage->setHeight($height);
				
		$this->add($sysImage);
		return $sysImage;
	}
	
	
	
	/**
	 * Get the item which is in the database after the given item
	 * 
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @param int $limit of items to return
	 * @return Tx_Yag_Domain_Model_Item $item
	 */
	public function getItemsAfterThisItem(Tx_Yag_Domain_Model_Item $item = NULL, $limit = 1) {
		$itemUid = $item ? $item->getUid() : 0;
		
		$query = $this->createQuery();
		$result = $query->matching($query->greaterThan('uid', $itemUid))
			  			->setLimit($limit)
			  			->execute();
			  			
		$object = NULL;
		if ($result->count() == 0) {
			return FALSE;
			
		} elseif ($result->count() == 1 && $result->current() !== FALSE) {
			$object = $result->current();
			$this->identityMap->registerObject($object, $object->getUid());
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
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult( TRUE );
		$result = $query->statement('SELECT sum(filesize) as sumFileSize 
									FROM tx_yag_domain_model_item
									WHERE deleted = 0')->execute();
		return $result[0]['sumFileSize'];
	}
	
	
	
	/**
	 * Count all items that belong to a gallery
	 * 
	 * @param Tx_Yag_Domain_Model_Gallery $gallery
	 * @return int 
	 */
	public function countItemsInGallery(Tx_Yag_Domain_Model_Gallery $gallery) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult( TRUE );
		$statement = 'SELECT count(*) as sumItems FROM `tx_yag_domain_model_item` item
									INNER JOIN `tx_yag_domain_model_album` album ON item.album = album.uid
									WHERE album.gallery = %s
									AND album.deleted = 0 AND album.hidden = 0 
									AND item.deleted = 0 AND item.hidden = 0';
		$result = $query->statement(sprintf($statement, $gallery->getUid()))->execute();
		return (int) $result[0]['sumItems'];
	}



    /**
     * Returns a sorted list of items for given album, sorting field and sorting direction.
     *
     * Sorting of item is set on returned collection of items!
     *
     * @param Tx_Yag_Domain_Model_Album $album
     * @param string $sortingField
     * @param string $sortingDirection
     * @return array
     */
    public function getSortedItemsByAlbumFieldAndDirection(Tx_Yag_Domain_Model_Album $album, $sortingField, $sortingDirection) {
        $sortings = array($sortingField => $sortingDirection);
        $query = $this->createQuery();
        $query->matching($query->equals('album', $album))
              ->setOrderings($sortings);
        $items = $query->execute();

        $sortingNumber = 0;
        foreach ($items as $item) { /* @var $item Tx_Yag_Domain_Model_Item */
            $item->setSorting($sortingNumber);
            $sortingNumber++;
        }

        return $items;
    }



    /**
     * Returns item with highest sorting for given album
     * 
     * @param Tx_Yag_Domain_Model_Album $album
     * @return array|Tx_Extbase_Persistence_QueryResultInterface
     */
    public function getItemWithMaxSortingForAlbum(Tx_Yag_Domain_Model_Album $album) {
        $query = $this->createQuery();
        $query->matching($query->equals('album', $album));
        $query->setOrderings(array('sorting' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING));
        $query->setLimit(1);
        return $query->execute();
    }




	/**
	 * @param $uidArray
	 * @return array|Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function getItemsByUids($uidArray) {
		$query = $this->createQuery();
		$query->matching($query->in('uid', $uidArray));
		return $query->execute();
	}



    /**
     * Returns a random set of images for a given number, gallery and album
     *
     * @param $numberOfItems Sets number of items to be returned
     * @param int $galleryUid Gallery UID to take images from
     * @param int $albumUid Album UID to take images from
     * @return array<Tx_Yag_Domain_Model_Item>
     */
    public function getRandomItems($numberOfItems, $galleryUid = 0, $albumUid = 0) {
        return $this->getItemsByUids($this->getRandomItemUIDs($numberOfItems, $galleryUid, $albumUid));
    }


	/**
	 * @param $randomItemCount
	 * @param int $galleryUid
	 * @param int $albumUid
	 * @return array
	 */
	public function getRandomItemUIDs($randomItemCount, $galleryUid = 0, $albumUid = 0) {
		$randomItemUIDs = array();
		$itemPositionWhiteList = array();

		$galleryUid = (int) $galleryUid;
		$albumUid = (int) $albumUid;

		/**
		 * Build Query Parts
		 */
		$additionalJoins = '';

		$additionalWhere = ' tx_yag_domain_model_item.album > 0 '; // Only show images with connection to an album (itemNotFoundEntries have non)
		$additionalWhere .= $this->getTypo3SpecialFieldsWhereClause(array('tx_yag_domain_model_item')) . ' ';

		if($albumUid || $galleryUid) {
			$additionalJoins .= ' INNER JOIN tx_yag_domain_model_album ON tx_yag_domain_model_item.album = tx_yag_domain_model_album.uid ';
		}

		if ($albumUid) {
			$additionalWhere .= ' AND tx_yag_domain_model_album.uid = ' . $albumUid . ' ';
			$additionalWhere .= $this->getTypo3SpecialFieldsWhereClause(array('tx_yag_domain_model_album')) . ' ';
		}

		if ($galleryUid) {
			$additionalJoins .= ' INNER JOIN tx_yag_domain_model_gallery ON tx_yag_domain_model_gallery.uid = tx_yag_domain_model_album.gallery ';
			$additionalWhere .= ' AND tx_yag_domain_model_album.gallery = ' . $galleryUid . ' ';
			$additionalWhere .= $this->getTypo3SpecialFieldsWhereClause(array('tx_yag_domain_model_gallery')) . ' ';
		}


		/*
		 * Get the overall itemCount
		 */
		$countStatement = "SELECT count(*) as itemCount
							FROM tx_yag_domain_model_item
							%s
							WHERE %s";
		$countStatement = sprintf($countStatement, $additionalJoins, $additionalWhere);

		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);

		$countResult = $query->statement($countStatement)->execute();
		$itemCount = $countResult[0]['itemCount'];

		if($randomItemCount > $itemCount) $randomItemCount = $itemCount;


		/**
		 * Select the items
		 */
		$selectStatementTemplate = "SELECT tx_yag_domain_model_item.uid as itemUid
							FROM tx_yag_domain_model_item
							%s
							WHERE %s
							LIMIT %s, 1";

		for($i = 0; $i < $randomItemCount; $i++) {

			$itemPosition = $this->pickRandomItem($itemCount, $itemPositionWhiteList);

			if($itemPosition !== NULL) {
				$selectStatement = sprintf($selectStatementTemplate, $additionalJoins, $additionalWhere, $itemPosition);

				$result = $query->statement($selectStatement)->execute();
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
	 * @return int
	 */
	protected function pickRandomItem($itemCount, &$itemPositionWhiteList) {
		if (!isset($itemPositionWhiteList) || count($itemPositionWhiteList) == 0) {
			$itemPositionWhiteList = range(0,$itemCount-1);
		}
		
		$itemPosition = array_rand($itemPositionWhiteList);

		unset($itemPositionWhiteList[$itemPosition]);
		return $itemPosition;
	}

}
?>