<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Michael Knoll <mimi@kaktusteam.de>
*           Daniel Lienert <daniel@lienert.cc>
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
 * Controller Development, generating some sample content for gallery
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_DevelopmentController extends Tx_Yag_Controller_AbstractController {
	
	/**
	 * Gallery Repository
	 *
	 * @var Tx_Yag_Domain_Repository_GalleryRepository
	 */
	protected $galleryRepository;
	
	
	
	/**
	 * Album repository
	 *
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;
	
	
	
	/**
	 * Resolution Repository
	 *
	 * @var Tx_Yag_Domain_Repository_ResolutionRepository
	 */
	protected $resolutionRepository;
	
	
	
	/**
	 * Resolution Preset Repository
	 *
	 * @var Tx_Yag_Domain_Repository_ResolutionPresetRepository
	 */
	protected $resolutionPresetRepository;
	
	
	
	/**
	 * Item repository
	 *
	 * @var Tx_Yag_Domain_Repository_ItemRepository
	 */
	protected $itemRepository;
	
	
	
	/**
	 * Item Type Repository
	 *
	 * @var Tx_Yag_Domain_Repository_ItemTypeRepository
	 */
	protected $itemTypeRepository;
	
	
	
	/**
	 * Item Source Repository
	 *
	 * @var Tx_Yag_Domain_Repository_ItemSourceRepository
	 */
	protected $itemSourceRepository;
	
	
	
	/**
	 * Item Source Type Repository
	 *
	 * @var Tx_Yag_Domain_Repository_ItemSourceTypeRepository
	 */
	protected $itemSourceTypeRepository;
	
	
	
	/**
	 * Item file repository
	 *
	 * @var Tx_Yag_Domain_Repository_ItemFileRepository
	 */
	protected $itemFileRepository;
	
	
	
	/**
	 * Resolution item file relation repository
	 *
	 * @var Tx_Yag_Domain_Repository_ResolutionItemFileRelationRepository
	 */
	protected $resolutionItemFileRelationRepository;
	
	
	
    /**
     * Initializes the current action
     *
     * @return void
     */
    protected function initializeAction() {
    	$this->galleryRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository');
        $this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
        $this->resolutionRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionRepository');
        $this->resolutionPresetRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionPresetRepository');
        $this->itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
        $this->itemTypeRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemTypeRepository');
        $this->itemSourceRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemSourceRepository');
        $this->itemSourceTypeRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemSourceTypeRepository');
        $this->itemFileRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemFileRepository');
        $this->resolutionItemFileRelationRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionItemFileRelationRepository');
    }
	
	/**
	 * Creates sample data like resolutions, albums etc. to start working with
	 */
	public function createSampleDataAction() {
		
		// Add gallery
		$gallery = new Tx_Yag_Domain_Model_Gallery();
		$gallery->setDescription('Description for first gallery');
		$gallery->setName('First Gallery');
		
		
		// Add some resolution stuff
		$resolutionPreset = new Tx_Yag_Domain_Model_ResolutionPreset();
		$resolutionPreset->setName('Default Resolution Preset');
		$singlesResolution = new Tx_Yag_Domain_Model_Resolution(800, 600, 'single', $resolutionPreset);
		$thumbsResolution = new Tx_Yag_Domain_Model_Resolution(80, 60, 'thumb', $resolutionPreset);
		
		// Add item type stuff
		$itemType = new Tx_Yag_Domain_Model_ItemType();
		$itemType->setName('photo');
		
		// Add source type
		$itemSourceType = new Tx_Yag_Domain_Model_ItemSourceType();
		$itemSourceType->setName('file');
		
		// Add album
		$album = new Tx_Yag_Domain_Model_Album();
		$album->getResolutionPresets()->attach($resolutionPreset);
		$album->getGalleries()->attach($gallery);
		$gallery->getAlbums()->attach($album);
		
		// Persist stuff
		$this->galleryRepository->add($gallery);
		$this->resolutionRepository->add($thumbsResolution);
		$this->resolutionRepository->add($singlesResolution);
		$this->resolutionPresetRepository->add($resolutionPreset);
		$this->itemTypeRepository->add($itemType);
		
		// Create item files and items
		for ($i = 1; $i < 10; $i++) {
			// Create an item file
			$singleItemFile = new Tx_Yag_Domain_Model_ItemFile('typo3conf/ext/yag/Resources/Public/Samples/', 'demo_800_600-00' . $i . '.jpg');
			$thumbItemFile = new Tx_Yag_Domain_Model_ItemFile('typo3conf/ext/yag/Resources/Public/Samples/', 'demo_80_60-00' . $i . '.jpg');
			
			// Create item source (item source is the same file as single image here!)
			$itemSource = new Tx_Yag_Domain_Model_ItemSource();
			$itemSource->setItemSourceType($itemSourceType);
			$itemSource->setUri('typo3conf/ext/yag/Resources/Public/Samples/', 'demo_800_600-00' . $i . '.jpg');
			
			// Create resolution item file relations
			$singlesResolutionItemFileRelation = new Tx_Yag_Domain_Model_ResolutionItemFileRelation();
			$singlesResolutionItemFileRelation->setResolution($singlesResolution);
			$singlesResolutionItemFileRelation->setItemFile($singleItemFile);
			$thumbsResolutionItemFileRelation = new Tx_Yag_Domain_Model_ResolutionItemFileRelation();
			$thumbsResolutionItemFileRelation->setResolution($thumbsResolution);
			$thumbsResolutionItemFileRelation->setItemFile($thumbItemFile);
			
			// Create item and add item files
			$item = new Tx_Yag_Domain_Model_Item();
			$item->setDescription('Description for photo ' . $i);
			$item->setItemSource($itemSource);
			$item->setTitle('Photo ' . $i);
			$item->getItemFiles()->attach($singlesResolutionItemFileRelation);
			$item->getItemFiles()->attach($thumbsResolutionItemFileRelation);
		
			// add item to album
			$album->getItems()->attach($item);
			
			// Persist stuff
			$this->itemFileRepository->add($singleItemFile);
			$this->itemFileRepository->add($thumbItemFile);
			$this->itemSourceRepository->add($itemSource);
			$this->itemRepository->add($item);
			$this->resolutionItemFileRelationRepository->add($singlesResolutionItemFileRelation);
			$this->resolutionItemFileRelationRepository->add($thumbsResolutionItemFileRelation);
		}
		
		// Persist album
		$this->albumRepository->add($album);
		
	}
	

}

?>
