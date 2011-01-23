<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Base class for all YAG importers
 *
 * @package Domain
 * @subpackage Import
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
abstract class Tx_Yag_Domain_Import_AbstractImporter implements Tx_Yag_Domain_Import_ImporterInterface {
    
    /**
     * Holds an instance of album content manager
     *
     * @var Tx_Yag_Domain_AlbumContentManager
     */
    protected $albumContentManager;
    
    
    
    /**
     * Holds an instance of configuration builder
     *
     * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
     */
    protected $configurationBuilder;
    
    
    
    /**
     * Holds an instance of album to which items should be imported
     *
     * @var Tx_Yag_Domain_Model_Album
     */
    protected $album;
    
    
    
    /**
     * Holds an instance of persistence manager
     *
     * @var Tx_Extbase_Persistence_Manager
     */
    protected $persistenceManager;
    
    
    
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
     * Holds an instance of item meta repository
     *
     * @var Tx_Yag_Domain_Repository_ItemMetaRepository
     */
    protected $itemMetaRepository;
    
    
    
    /**
     * Injector for persistence manager
     *
     * @param Tx_Extbase_Persistence_Manager $persistenceManager
     */
    public function injectPersistenceManager(Tx_Extbase_Persistence_Manager $persistenceManager) {
    	$this->persistenceManager = $persistenceManager; 
    }
    
    
    
    /**
     * Injector for item repository
     *
     * @param Tx_Yag_Domain_Repository_ItemRepository $itemRepository
     */
    public function injectItemRepository(Tx_Yag_Domain_Repository_ItemRepository $itemRepository) {
    	$this->itemRepository = $itemRepository;
    }
    
    
    
    /**
     * Injector for item meta repository
     *
     * @param Tx_Yag_Domain_Repository_ItemMetaRepository $itemRepository
     */
    public function injectItemMetaRepository(Tx_Yag_Domain_Repository_ItemMetaRepository $itemMetaRepository) {
        $this->itemMetaRepository = $itemMetaRepository;
    }
    
    
    
    /**
     * Injector for image processor
     *
     * @param Tx_Yag_Domain_ImageProcessing_Processor $imageProcessor
     */
    public function injectImageProcessor(Tx_Yag_Domain_ImageProcessing_Processor $imageProcessor) {
    	$this->imageProcessor = $imageProcessor;
    }
    
    
    
    /**
     * Injector for album content manager
     *
     * @param Tx_Yag_Domain_AlbumContentManager $albumContentManager
     */
    public function injectAlbumManager(Tx_Yag_Domain_AlbumContentManager $albumContentManager) {
        $this->albumContentManager = $albumContentManager;
    }
    
    
    
    /**
     * Injector for configuration builder
     *
     * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
     */
    public function injectConfigurationBuilder(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
        $this->configurationBuilder = $configurationBuilder;
    }
    
    
    
    /**
     * Sets album to which items should be imported
     *
     * @param Tx_Yag_Domain_Model_Album $album
     */
    public function setAlbum(Tx_Yag_Domain_Model_Album $album) {
        $this->album = $album;
    }
    
    
    
    /**
     * Creates MetaData information of given item
     *
     * @param Tx_Yag_Domain_Model_Item $item
     */
    public function parseMetaData($item) {
    	if (file_exists($item->getSourceuri())) {
    	    $exifData = Tx_Yag_Domain_Import_MetaData_ExifParser::parseExifData($item->getSourceuri());
    	    Tx_Yag_Domain_Model_ItemMeta::createInstanceByExifMetaData($exifData);
    	}
    }
    
    
    
    /**
     * Imports a file given by its filepath. If an item object
     * is given, this one is used. Otherwise a new one is created.
     *
     * @param string $filepath Absolute file path to file on server
     * @param Tx_Yag_Domain_Model_Item $item Item to attach file to
     * @return Tx_Yag_Domain_Model_Item Item created or used for import
     */
    protected function importFileByFilename($filepath, $item = null) {
        
    	// Create new item if none is given
    	if ($item === null) {
            $item = new Tx_Yag_Domain_Model_Item();
        }
         
        $filesizes = getimagesize($filepath);
        $relativeFilePath = $this->getRelativeFilePath($filepath);
        
        $item->setSourceuri($relativeFilePath);
        $item->setTitle(Tx_Yag_Domain_FileSystem_Div::getFilenameFromFilePath($relativeFilePath));
        $item->setItemMeta(Tx_Yag_Domain_Import_MetaData_ItemMetaFactory::createItemMetaForFile($filepath));
        $item->setAlbum($this->album);
        $item->setWidth($filesizes[0]);
        $item->setHeight($filesizes[1]);
        $item->setFilesize(filesize($filepath));
        $this->albumContentManager->addItem($item);
        $this->itemRepository->add($item);
        return $item;
    }
    
    
    
    /**
     * Returns relative base path of image
     * 
     * if image resides in /var/www/htdocs/your_site_root/images/img001.jpg
     * this function will return images/img001.jpg
     *
     * @param unknown_type $filePath
     * @return unknown
     */
    protected function getRelativeFilePath($filePath) {
        $basePath = Tx_Yag_Domain_FileSystem_Div::getT3BasePath();
        if (substr($filePath, 0, strlen($basePath)) == $basePath) {
            $filePath = substr($filePath,strlen($basePath));
        }
        return $filePath;
    }
    
    
    
    /**
     * Moves an uploaded file into original file directory and imports it
     *
     * @param string $uploadFilepath Path to uploaded file (temporary file handled by PHP)
     * @return Tx_Yag_Domain_Model_Item Item for imported file
     */
    protected function moveAndImportUploadedFile($uploadFilepath) {
        // Create item for new image
        $item = $this->getNewPersistedItem();
        
        // Move uploaded file to directory for original files
        $origFilePath = $this->getOrigFilePathForFile($item->getUid() . '.jpg');
        move_uploaded_file($uploadFilepath, $origFilePath);
        
        // Run import for original file
        $this->importFileByFilename($origFilePath, $item);
        return $item;
    }
    
        
    
    /**
     * Creates a new item object and persists it
     * so that we have an UID for it.
     *
     * @return Tx_Yag_Domain_Model_Item Persisted item
     */
    protected function getNewPersistedItem() {
        $item = new Tx_Yag_Domain_Model_Item();
        $this->itemRepository->add($item);
        $this->persistenceManager->persistAll(); 
        return $item;
    }
    
    
    
    /**
     * Returns a file path for an image stored to directory with original files
     *
     * @param string $filename Filename of file to get path for
     * @param bool $createDirIfNotExists If true, directory will be created if it doesn't exist
     * @return string Absolute path for filename in directory with original files
     */
    protected function getOrigFilePathForFile($filename, $createDirIfNotExists = true) {
        return $this->getOrigFileDirectoryPathForAlbum($createDirIfNotExists) . '/' . $filename;
    }
    
    
    
    /**
     * Creates path for original files on server.
     * If path does not exist, it will be created if given parameter is true.
     *
     * @param bool $createIfNotExists If set to true, directory will be created if it does not exist
     * @return string Path for original images (absolute)
     */
    protected function getOrigFileDirectoryPathForAlbum($createIfNotExists = true) {
        $path = $this->configurationBuilder->buildExtensionConfiguration()->getOrigFilesRootAbsolute() . '/' . $this->album->getUid() . '/';
        if ($createIfNotExists) Tx_Yag_Domain_FileSystem_Div::checkDir($path);
        return $path;
    }
	
}
 
?>