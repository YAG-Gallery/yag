<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <knoll@punkt.de>
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
 * Directory based importer importing files for a given directory on the server
 *
 * @package Domain
 * @subpackage Import\DirectoryImporter
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Domain_Import_LightroomImporter_Importer extends Tx_Yag_Domain_Import_AbstractImporter {
	
	/**
	 * Holds an instance of album to which items should be imported
	 *
	 * @var Tx_Yag_Domain_Model_Album
	 */
	protected $album;
	
	
	
	/**
	 * Holds an instance of hash filesystem for adding original image files
	 *
	 * @var Tx_Yag_Domain_Filehandling_HashFileSystem
	 */
	protected $hashFileSystem;
	
	
	
	/**
	 * Holds an instance of item file repository
	 *
	 * @var Tx_Yag_Domain_Repository_ItemFileRepository
	 */
	protected $itemFileRepository;
	
	
	
	/**
	 * Holds an instance of persistence manager
	 *
	 * @var Tx_Extbase_Persistence_Manager
	 */
	protected $persistenceManager;
	
	
	
	/**
	 * Holds an instance of resolution item file relation repository
	 *
	 * @var Tx_Yag_Domain_Repository_ResolutionItemFileRelationRepository
	 */
	protected $resolutionItemFileRelationRepository;
	
	
	
	/**
	 * Holds an instance of image processor
	 *
	 * @var Tx_Yag_Domain_ImageProcessing_Processor
	 */
	protected $imageProcessor;
	
	
	
	/**
	 * Holds an instance of item repository
	 *
	 * @var Tx_Yag_Domain_Repository_ItemRepository
	 */
	protected $itemRepository;
	
	
	/**
	 * Holds an instance of resolution repository
	 *
	 * @var Tx_Yag_Domain_Repository_ResolutionRepository
	 */
	protected $resolutionRepository;
	
	
	
	/**
	 * Constructor for lightroom importer
	 *
	 */
	public function __construct($configurationBuilder, $albumContentManager) {
		// TODO put this into factory
		$this->albumContentManager = $albumContentManager;
		$this->configurationBuilder = $configurationBuilder;
		$this->hashFileSystem = Tx_Yag_Domain_Filehandling_HashFileSystemFactory::getInstance();
		$this->itemFileRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemFileRepository');
		$this->itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
		$this->persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager'); /* @var $persistenceManager Tx_Extbase_Persistence_Manager */
		$this->resolutionItemFileRelationRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionItemFileRelationRepository');
		$this->resolutionRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionRepository');
		$this->imageProcessor = new Tx_Yag_Domain_ImageProcessing_Processor($this->configurationBuilder->buildImageProcessorConfiguration());
	}
	
	
	
	
	/**
	 * Implementing interface method for import
	 * 
	 * TODO add error handling here
	 */
	public function runImport() {
		// Save original file
		$origItemFile = new Tx_Yag_Domain_Model_ItemFile(null, 'origFile');
		$this->itemFileRepository->add($origItemFile);
		$this->persistenceManager->persistAll();
		$origItemFile->setPath($this->hashFileSystem->createAndGetAbsolutePathById($origItemFile->getUid()) . '/' . $origItemFile->getUid() . '.jpg');

		// Move POST file to origItemFile
		// TODO how to put this into the tx_yag_pi1 namespace?
		#error_log('Filename ' . $_FILES['file']['tmp_name']);
		move_uploaded_file($_FILES['file']['tmp_name'], $origItemFile->getPath());
		
		// Do image processing on file
		$item = new Tx_Yag_Domain_Model_Item();
		$resolutionPresets = $this->album->getResolutionPresets();
		
		// add itemfile for each resolution
	    foreach($resolutionPresets as $resolutionPreset) {
            $query = $this->resolutionRepository->createQuery();
            $resolutions = $query->matching($query->equals('resolutionPreset', $resolutionPreset->getUid()))->execute();
            foreach($resolutions as $resolution) {
                $itemFile = $this->imageProcessor->resizeFile($origItemFile, $resolution);
                $this->itemFileRepository->add($itemFile);
                $resolutionItemFileRelation = new Tx_Yag_Domain_Model_ResolutionItemFileRelation($item, $itemFile, $resolution);
                $this->resolutionItemFileRelationRepository->add($resolutionItemFileRelation);
            }
        }
        
        // Persist item
        $this->itemRepository->add($item);
        $this->albumContentManager->addItem($item);
	}
	
	
	
	/**
	 * Sets album to which items should be imported
	 *
	 * @param Tx_Yag_Domain_Model_Album $album
	 */
	public function setAlbum(Tx_Yag_Domain_Model_Album $album) {
		$this->album = $album;
	}

}

?>
