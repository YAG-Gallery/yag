<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Importer for jm_gallery extension
 * 
 * TODO we do not cover case, when registry entry is given, but object is deleted!
 *
 * @package Domain
 * @subpackage Import\JmGallery
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Import_JmGallery_Importer {
	
	/**
	 * Some constants for using t3registry as mapping for jm_gallery UIDs
	 * on yag object UIDs.
	 */
	const REGISTRY_CATEGORY_MAPPING = 'tx_yag_jmgalleryimport_category_mapping';
	const REGISTRY_ALBUM_MAPPING = 'tx_yag_jmgalleryimport_album_mapping';
	const REGISTRY_IMAGE_MAPPING = 'tx_yag_jmgalleryimport_image_mapping';
	
	
	
	/**
	 * Holds an instance of t3lib_DB
	 *
	 * @var t3lib_DB
	 */
	protected $t3db;
	
	
	
	/**
	 * Holds an instance of t3lib_Registry
	 *
	 * @var t3lib_Registry
	 */
	protected $t3Registry;
	
	
	
	/**
	 * Holds an instance of extbase persistence manager
	 *
	 * @var Tx_Extbase_Persistence_Manager
	 */
	protected $persistenceManager;
	
	
	
	/**
	 * Holds instance of gallery repository
	 *
	 * @var Tx_Yag_Domain_Repository_GalleryRepository
	 */
	protected $galleryRepository;
	
	
	
	/**
	 * Holds instance of album repository
	 *
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;
	
	
	
	/**
	 * Holds instance of item repository
	 *
	 * @var Tx_Yag_Domain_Repository_ItemRepository
	 */
	protected $itemRepository;
	
	
	
	/**
	 * Holds an array of array('item' => yagItemObject, 'itemRow' => jm_gallery_image_row) that are not yet mapped in registry
	 *
	 * @var array
	 */
	protected $nonMappedItems = array();
	
	
	
	/**
	 * Constructor for jm_gallery importer
	 *
	 */
	public function __construct() {
		$this->t3db = $GLOBALS['TYPO3_DB'];
		$this->t3Registry = t3lib_div::makeInstance('t3lib_Registry');
		$this->persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		$this->galleryRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository');
		$this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
		$this->itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
	}
	
	
    
	/**
	 * Runs import of jm_gallery data
	 *
	 */
	public function runImport() {
		$categories = $this->getJmCategories();
		
		// Create yag gallery for each jm_gallery category
		foreach ($categories as $category) {
			$importedGallery = $this->importCategoryRow($category);
			$albums = $this->getJmAlbumsByCategoryUid($category['uid']);
			
			// Create yag album for each jm_gallery album
			foreach ($albums as $album) {
				$importedAlbum = $this->importAlbumRow($album, $importedGallery);
				$images = $this->getJmImagesByAlbumUid($album['uid']);
				
				// Create yag item for each jm_gallery image
				foreach($images as $image) {
					$this->importImageRow($image, $album['default_dir'], $importedAlbum);
				}
				
				// We map all items of an album at once as we need to have item UID and thus have to call persistAll()
				if (count($this->nonMappedItems) > 0) {
					$this->persistenceManager->persistAll();
					$this->mapNonMappedItems();
				}
			}
			// TODO map cover / thumb of album
		}
	}
	
	
	
	/**
	 * Returns an array of jm_gallery category rows
	 *
	 * @return array
	 */
	protected function getJmCategories() {
		$select = '*';
		$from = 'tx_jmgallery_categories';
		$categories = $this->t3db->exec_SELECTgetRows($select, $from);
		return $categories;
	}
	
	
	
	/**
	 * Returns an array of jm_gallery album rows
	 *
	 * @param array $categoryUid Uid of category to get albums for
	 * @return array
	 */
	protected function getJmAlbumsByCategoryUid($categoryUid) {
		$albums = array();
		$categoryAlbumRelations = $this->getJmAlbumToCategoriesRelationByCategoryUid($categoryUid);
		foreach ($categoryAlbumRelations as $categoryAlbumRelation) {
			$select = '*';
	        $from = 'tx_jmgallery_albums';
	        $where = 'uid = ' . $categoryAlbumRelation['uid_foreign'];
	        $albums[] = $this->t3db->exec_SELECTgetSingleRow($select, $from, $where);
		}
		return $albums;
	}
	
	
	
	/**
	 * Returns an array of categories-to-album relation rows 
	 *
	 * @param int $categoryUid Uid of category to get relations for
	 * @return array
	 */
	protected function getJmAlbumToCategoriesRelationByCategoryUid($categoryUid) {
		$select = '*';
		$from = 'tx_jmgallery_categories_albums_mm';
		$where = 'uid_local = ' . $categoryUid;
		$categoriesToAlbumRelations =  $this->t3db->exec_SELECTgetRows($select, $from, $where);
		return $categoriesToAlbumRelations;
	}
	
	
	
	/**
	 * Returns an array of jm_gallery image rows 
	 *
	 * @param int $albumUid Uid of album to get images for
	 * @return array
	 */
	protected function getJmImagesByAlbumUid($albumUid) {
		$select = '*';
		$from = 'tx_jmgallery_images';
		$where = 'album = ' . $albumUid;
		$images = $this->t3db->exec_SELECTgetRows($select, $from, $where);
		return $images;
	}
	
	
	
	/**
	 * Imports or updates a given category row into yag gallery
	 *
	 * @param array $categoryRow Row of jm_gallery category table
	 * @return Tx_Yag_Domain_Model_Gallery Instance of gallery object that was imported
	 */
	protected function importCategoryRow($categoryRow) {
		#t3lib_div::devLog('Importing jm_gallery category row into yag gallery', 'yag', 0, array('category' => $categoryRow));
		$gallery = null;
		if ($this->getYagGalleryUidMappingForJmCategoryRow($categoryRow) > 0) {
			// we update yag gallery with given jm_gallery row
			$gallery = $this->galleryRepository->findByUid($this->getYagGalleryUidMappingForJmCategoryRow($categoryRow));
		} else {
			// we insert a new yag gallery for jm_gallery row
			$gallery = new Tx_Yag_Domain_Model_Gallery();
			$this->galleryRepository->add($gallery);
			$this->persistenceManager->persistAll();
			$this->addYagGalleryUidMappingForJmCategoryRow($gallery, $categoryRow);
		}
		$this->mapCategoryRowOnGallery($categoryRow, $gallery);
		$this->galleryRepository->update($gallery);
		return $gallery;
	}
	
	
	
	/**
	 * Returns uid of yag gallery mapped to given category row or 0 if no mapping exists
	 *
	 * @param array $categoryRow Row of jm_gallery category table
	 * @return int Uid of yag gallery mapped to given category row
	 */
	protected function getYagGalleryUidMappingForJmCategoryRow($categoryRow) {
		return $this->t3Registry->get(self::REGISTRY_CATEGORY_MAPPING, $categoryRow['uid'], 0);
	}
	
	
	
	/**
	 * Inserts a new mapping for category uid <--> gallery uid mapping
	 *
	 * @param Tx_Yag_Domain_Model_Gallery $gallery Gallery object to set mapping for
	 * @param array $categoryRow Row of jm_gallery category table to set mapping for
	 */
	protected function addYagGalleryUidMappingForJmCategoryRow(Tx_Yag_Domain_Model_Gallery $gallery, $categoryRow) {
		$this->t3Registry->set(self::REGISTRY_CATEGORY_MAPPING, $categoryRow['uid'], $gallery->getUid());
	}
	
	
	
	/**
	 * Maps jm_gallery category data on yag gallery object
	 *
	 * @param array $categoryRow Row of jm_gallery categories tables
	 * @param Tx_Yag_Domain_Model_Gallery $gallery Yag gallery object to map data to
	 */
	protected function mapCategoryRowOnGallery($categoryRow, Tx_Yag_Domain_Model_Gallery $gallery) {
		$gallery->setName($categoryRow['name']);
		$gallery->setDescription($categoryRow['description']);
		$gallery->setSorting($categoryRow['sorting']);
		// TODO we need DateTime object here!
		//$gallery->setDate($categoryRow['crdate']);
	}
	
	
	
	/**
	 * Imports or updates a given album row into yag gallery
	 *
	 * @param array $albumRow Row of jm_gallery album table
	 * @param Tx_Yag_Domain_Model_Gallery $gallery Gallery into which album should be imported
	 * @return Tx_Yag_Domain_Model_Album Instance of album object that was imported
	 */
	protected function importAlbumRow($albumRow, Tx_Yag_Domain_Model_Gallery $gallery) {
		#t3lib_div::devLog('Importing jm_gallery album row into yag gallery', 'yag', 0, array('album' => $albumRow));
        $album = null;
        if ($this->getYagAlbumUidMappingForJmAlbumRow($albumRow) > 0) {
            // we update yag album with given jm_gallery album row
            $album = $this->albumRepository->findByUid($this->getYagAlbumUidMappingForJmAlbumRow($albumRow));
            $album->setGallery($gallery);
        } else {
            // we insert a new yag album for jm_gallery album row
            $album = new Tx_Yag_Domain_Model_Album();
            $album->setGallery($gallery);
            $this->albumRepository->add($album);
            $this->persistenceManager->persistAll();
            $this->addYagAlbumUidMappingForJmAlbumRow($album, $albumRow);
        }
        $this->mapAlbumRowOnAlbum($albumRow, $album, $gallery);
        $this->albumRepository->update($album);
        return $album;
	}
	
	
	
	/**
	 * Returns uid of yag album for a given jm_gallery album table row
	 *
	 * @param array $albumRow Row of jm_gallery album table
	 */
	protected function getYagAlbumUidMappingForJmAlbumRow($albumRow) {
		return $this->t3Registry->get(self::REGISTRY_ALBUM_MAPPING, $albumRow['uid'], 0);
	}
	
	
	
	/**
	 * Sets mapping for jm_gallery album table row on yag album object
	 *
	 * @param Tx_Yag_Domain_Model_Album $album Album object to set mapping for
	 * @param array $albumRow Row of jm_gallery album table row to set mapping for
	 */
	protected function addYagAlbumUidMappingForJmAlbumRow(Tx_Yag_Domain_Model_Album $album, $albumRow) {
		$this->t3Registry->set(self::REGISTRY_ALBUM_MAPPING, $albumRow['uid'], $album->getUid());
	}
	
	
	
	/**
	 * Maps jm_gallery data on yag album object
	 *
	 * @param array $albumRow Row of jm_gallery album table to be mapped on yag album
	 * @param Tx_Yag_Domain_Model_Album $album Yag album object to map data to
	 * @param Tx_Yag_Domain_Model_Gallery $gallery Gallery to which album belongs
	 */
	protected function mapAlbumRowOnAlbum($albumRow, Tx_Yag_Domain_Model_Album $album, Tx_Yag_Domain_Model_Gallery $gallery) {
		$album->setName($albumRow['name']);
		$album->setDescription($albumRow['description']);
		$album->setSorting($albumRow['sorting']);
		//$album->setGallery($gallery);
	}
	
	
	
	/**
	 * Imports or updates a given image row into yag gallery
	 *
	 * @param array $imageRow Row of jm_gallery image table
	 * @param string $imageBasePath Base path of jm_gallery image (from album)
	 * @param Tx_Yag_Domain_Model_Album $album Album into which items should be added
	 * @return Tx_Yag_Domain_Model_Item Instance of inserted item
	 */
	protected function importImageRow($imageRow, $imageBasePath, Tx_Yag_Domain_Model_Album $album) {
		#t3lib_div::devLog('Importing jm_gallery image row into yag gallery', 'yag', 0, array('image' => $imageRow));
        $item = null; /* @var $item getYagItemUidMappingForJmImageRow */
        if ($this->getYagItemUidMappingForJmImageRow($imageRow) > 0) {
            // we update yag item with given jm_gallery image row
            $item = $this->itemRepository->findByUid($this->getYagItemUidMappingForJmImageRow($imageRow));
	        $this->mapImageRowOnItem($imageRow, $item, $imageBasePath, $album);
	        $this->itemRepository->update($item);
        } else {
            // we insert a new yag item for jm_gallery item row
            $item = new Tx_Yag_Domain_Model_Item();
	        $this->mapImageRowOnItem($imageRow, $item, $imageBasePath, $album);
            $this->nonMappedItems[] = array('item' => $item, 'imageRow' =>$imageRow);
            $this->itemRepository->add($item);
        }
        return $item;
	}
	
	
	
	/**
	 * Returns mapping for given jm_gallery images table row
	 *
	 * @param array $imageRow Row of jm_gallery images table
	 * @return int Uid of yag item object for given jm_gallery images row
	 */
	protected function getYagItemUidMappingForJmImageRow($imageRow) {
		return $this->t3Registry->get(self::REGISTRY_IMAGE_MAPPING, $imageRow['uid'], 0);
	}
	
	
	
	/**
	 * Maps all entries in non mapped items array in registry.
	 *
	 */
	protected function mapNonMappedItems() {
		foreach($this->nonMappedItems as $mappingRow) {
			$this->addYagItemUidMappingForJmImageRow($mappingRow['item'], $mappingRow['imageRow']);
		}
		$this->nonMappedItems = array();
	}
	
	
	
	/**
	 * Adds a mapping for yag item object on jm_gallery images table row
	 *
	 * @param Tx_Yag_Domain_Model_Item $item Yag item object to add mapping for
	 * @param array $imageRow Row of jm_gallery images table to add mapping for
	 */
	protected function addYagItemUidMappingForJmImageRow(Tx_Yag_Domain_Model_Item $item, $imageRow) {
		$this->t3Registry->set(self::REGISTRY_IMAGE_MAPPING, $imageRow['uid'], $item->getUid());
	}
	
	
	
	/**
	 * Maps data of jm_gallery images table row on yag item object
	 *
	 * @param array $imageRow Row of jm_gallery images table to map data from
	 * @param Tx_Yag_Domain_Model_Item $item Yag item object to map data to
	 * @param string $imageBasePath Base path of images from album
	 */
	protected function mapImageRowOnItem($imageRow, Tx_Yag_Domain_Model_Item $item, $imageBasePath, Tx_Yag_Domain_Model_Album $album) {
		$item->setTitle($imageRow['caption']);
		$item->setFilename($imageRow['filename']);
		$item->setSourceuri($imageBasePath . '/' . $imageRow['filename']);
		$item->setAlbum($album);
		$sizes = array();
		preg_match('/(.+)x(.+)/', $imageRow['resolution'], $sizes);
		$item->setHeight($sizes[1]);
		$item->setWidth($sizes[2]);
		$item->setSorting($imageRow['sorting']);
		// TODO get item meta data from imported file
	}
	
}
?>