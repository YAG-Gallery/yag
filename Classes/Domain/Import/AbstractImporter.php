<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * @author Daniel Lienert <daniel@lienert.cc>
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
	 * Holds an instance of the importer configuraation
	 *
	 * @var Tx_Yag_Domain_Configuration_Import_ImporterConfiguration
	 */
	protected $importerConfiguration;



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
	 * @var Tx_Yag_Domain_ImageProcessing_AbstractProcessor
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
	 * @var Tx_Yag_Domain_Import_MetaData_ItemMetaFactory
	 */
	protected $itemMetaDataFactory;


	/**
	 * If set to true, files found in the directory
	 * are moved to the directory of original files for
	 * the album before they are processed
	 *
	 * @var bool
	 */
	protected $moveFilesToOrigsDirectory = FALSE;


	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;


	/**
	 * Holds fe_user
	 *
	 * @var Tx_Extbase_Domain_Model_FrontendUser
	 */
	protected $feUser = NULL;


	/**
	 * @var Tx_Yag_Domain_FileSystem_FileManager
	 */
	protected $fileManager;


	/**
	 * @var Tx_Yag_Domain_FileSystem_Div
	 */
	protected $fileSystemDiv;




	/**
	 * @param Tx_Extbase_Object_ObjectManager $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}


	/**
	 * Injector for persistence manager
	 *
	 * @param Tx_Extbase_Persistence_Manager $persistenceManager
	 */
	public function injectPersistenceManager(Tx_Extbase_Persistence_Manager $persistenceManager) {
		$this->persistenceManager = $persistenceManager;
	}


	/**
	 * @param Tx_Yag_Domain_FileSystem_FileManager $fileManager
	 */
	public function injectFileManager(Tx_Yag_Domain_FileSystem_FileManager $fileManager) {
		$this->fileManager = $fileManager;
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
	 * @param Tx_Yag_Domain_Repository_ItemMetaRepository $itemMetaRepository
	 */
	public function injectItemMetaRepository(Tx_Yag_Domain_Repository_ItemMetaRepository $itemMetaRepository) {
		$this->itemMetaRepository = $itemMetaRepository;
	}


	/**
	 * @param Tx_Yag_Domain_FileSystem_Div $fileSystemDiv
	 */
	public function injectResolutionFileSystemDiv(Tx_Yag_Domain_FileSystem_Div $fileSystemDiv) {
		$this->fileSystemDiv = $fileSystemDiv;
	}


	/**
	 * @param Tx_Yag_Domain_Import_MetaData_ItemMetaFactory $itemMetaDataFactory
	 */
	public function injectItemMetaDataFactory(Tx_Yag_Domain_Import_MetaData_ItemMetaFactory $itemMetaDataFactory) {
		$this->itemMetaDataFactory = $itemMetaDataFactory;
	}



	/**
	 * Injector for image processor
	 *
	 * @param Tx_Yag_Domain_ImageProcessing_AbstractProcessor $imageProcessor
	 */
	public function setImageProcessor(Tx_Yag_Domain_ImageProcessing_AbstractProcessor $imageProcessor) {
		$this->imageProcessor = $imageProcessor;
	}



	/**
	 * Injector for album content manager
	 *
	 * @param Tx_Yag_Domain_AlbumContentManager $albumContentManager
	 */
	public function setAlbumManager(Tx_Yag_Domain_AlbumContentManager $albumContentManager) {
		$this->albumContentManager = $albumContentManager;
	}



	/**
	 * Injector for configuration builder
	 *
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 */
	public function setConfigurationBuilder(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		$this->configurationBuilder = $configurationBuilder;
	}



	/**
	 * Injector for importer Configuration
	 *
	 * @param $importerConfiguration
	 */
	public function setImporterConfiguration(Tx_Yag_Domain_Configuration_Import_ImporterConfiguration $importerConfiguration) {
		$this->importerConfiguration = $importerConfiguration;
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
	 * Setter for fe_user object
	 *
	 * @abstract
	 * @param Tx_Extbase_Domain_Model_FrontendUser $feUser
	 */
	public function setFeUser(Tx_Extbase_Domain_Model_FrontendUser $feUser) {
		$this->feUser = $feUser;
	}



	/**
	 * Imports a file given by its filepath. If an item object
	 * is given, this one is used. Otherwise a new one is created.
	 *
	 * @param string $filePath Absolute file path to file on server
	 * @param Tx_Yag_Domain_Model_Item $item Item to attach file to
	 * @return Tx_Yag_Domain_Model_Item Item created or used for import
	 */
	protected function importFileByFilename($filePath, $item = NULL) {

		// Create new item if none is given
		if ($item === NULL) {
			$item = $this->objectManager->create('Tx_Yag_Domain_Model_Item');
			$item->setFeUserUid($this->feUser->getUid());
		}

		// Set sorting of item, if not yet given
		if (!$item->getSorting() > 0) {
			$item->setSorting($this->album->getMaxSorting() + 1);
		}

		$fileSizes = getimagesize($filePath);
		$relativeFilePath = $this->getRelativeFilePath($filePath);

		$item->setSourceuri($relativeFilePath);
		$item->setFilename(Tx_Yag_Domain_FileSystem_Div::getFilenameFromFilePath($relativeFilePath));

		$item->setWidth($fileSizes[0]);
		$item->setHeight($fileSizes[1]);
		$item->setItemType($fileSizes['mime']);

		// Metadata
		if ($this->importerConfiguration->getParseItemMeta()) {

			try {
				$item->setItemMeta($this->itemMetaDataFactory->createItemMetaForFile($filePath));
			} catch (Exception $e) {
				t3lib_div::sysLog('Error while extracting MetaData from "' . $filePath . '". Error was: ' . $e->getMessage(), 'yag', 2);
			}

			if ($this->importerConfiguration->getGenerateTagsFromMetaData() && is_a($item->getItemMeta(), 'Tx_Yag_Domain_Model_ItemMeta')) {
				try {
					$item->addTagsFromCSV($item->getItemMeta()->getKeywords());
				} catch (Exception $e) {
					t3lib_div::sysLog('Error while saving KeyWords from"' . $filePath . '". Error was: ' . $e->getMessage(), 'yag', 2);
				}
			}

			$item->setTitle($this->processStringFromMetaData($item, $this->importerConfiguration->getTitleFormat()));
			$item->setDescription($this->processStringFromMetaData($item, $this->importerConfiguration->getDescriptionFormat()));
		}

		$item->setAlbum($this->album);

		$item->setFilesize(filesize($filePath));
		$item->setItemAsAlbumThumbIfNotExisting();
		$item->setFilehash(md5_file($filePath));
		$this->albumContentManager->addItem($item);
		$this->itemRepository->add($item);

		return $item;
	}



	/**
	 * Replace the variables in the given format string with fileName or properties of the
	 * itemMeta object.
	 *
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @param string $format
	 * @param array $additionalVars
	 * @return Tx_Yag_Domain_Model_Item $item;
	 */
	protected function processStringFromMetaData(Tx_Yag_Domain_Model_Item $item, $format, $additionalVars = array()) {

		if($item->getItemMeta() instanceof Tx_Yag_Domain_Model_ItemMeta) {
			$vars = $item->getItemMeta()->getAttributeArray();
		} else {
			$vars = array();
		}

		$vars['origFileName'] = $item->getOriginalFilename();
		$vars['fileName'] = $this->processTitleFromFileName($item->getOriginalFilename());

		$vars = t3lib_div::array_merge_recursive_overrule($vars, $additionalVars);
		$formattedString = Tx_PtExtlist_Utility_RenderValue::renderDataByConfigArray($vars, $format);

		return $formattedString;
	}



	/**
	 * Returns relative base path of image
	 *
	 * if image resides in /var/www/htdocs/your_site_root/images/img001.jpg
	 * this function will return images/img001.jpg
	 *
	 * @param string $filePath
	 * @return string
	 */
	protected function getRelativeFilePath($filePath) {
		$basePath = Tx_Yag_Domain_FileSystem_Div::getT3BasePath();
		if (substr($filePath, 0, strlen($basePath)) == $basePath) {
			$filePath = substr($filePath, strlen($basePath));
		}
		return $filePath;
	}



	/**
	 * Creates a new item object and persists it
	 * so that we have an UID for it.
	 *
	 * @return Tx_Yag_Domain_Model_Item Persisted item
	 */
	protected function getNewPersistedItem() {
		$item = $this->objectManager->create('Tx_Yag_Domain_Model_Item');

		if ($this->feUser) {
			$item->setFeUserUid($this->feUser->getUid());
		}

		$this->itemRepository->add($item);
		$this->persistenceManager->persistAll();

		return $item;
	}



	/**
	 * Sets file mask to configured value for given file.
	 *
	 * Does not do anything if running on windows
	 *
	 * @param string $path Path to file to set mask for
	 */
	protected function setFileMask($path) {
		// we cannot do this on windows
		if (!(strtoupper(substr(PHP_OS, 0, 3)) == "WIN")) {
			chmod($path, $this->importerConfiguration->getImportFileMask());
		}
	}



	/**
	 * Returns a file path for an image stored to directory with original files
	 *
	 * @param string $filename Filename of file to get path for
	 * @param bool $createDirIfNotExists If true, directory will be created if it doesn't exist
	 * @return string Absolute path for filename in directory with original files
	 */
	protected function getOrigFilePathForFile($filename, $createDirIfNotExists = TRUE) {
		return $this->fileManager->getOrigFileDirectoryPathForAlbum($this->album, $createDirIfNotExists)  . $filename;
	}



	/**
	 * Moves a file from given filepath to directory for original images for album
	 *
	 * If an item is given, UID of item is used as filename for item in original items directory
	 *
	 * @param string $filePath Full qualified filepath of file to move
	 * @param Tx_Yag_Domain_Model_Item $item Item that should hold file (not modified, make sure to set sourceuri manually!
	 * @return string
	 * @throws Exception
	 */
	protected function moveFileToOrigsDirectory($filePath, Tx_Yag_Domain_Model_Item $item = NULL) {

		// Create path to move file to
		$origsFilePath = $this->fileManager->getOrigFileDirectoryPathForAlbum($this->album);
		$fileSuffix = pathinfo($filePath, PATHINFO_EXTENSION);

		if ($item !== NULL) {

			if($item->getOriginalFilename()) {
				$origsFilePath .= $item->getUid() . '_' . $this->fileSystemDiv->cleanFileName($item->getOriginalFilename());
			} else {
				$origsFilePath .= $item->getUid() . '.' . $fileSuffix; // if we get an item, we use UID of item as a part of the filename
			}

		} else {

			$origsFilePath .= Tx_Yag_Domain_FileSystem_Div::getFilenameFromFilePath($filePath); // if we do not get one, we use filename of given filepart
		}

		if (!rename($filePath, $origsFilePath)) {
			throw new Exception('Could not move file ' . $filePath . ' to ' . $origsFilePath, 1294176900);
		}

		// Set appropriate file mask
		$this->setFileMask($origsFilePath);

		return $origsFilePath;
	}



	/**
	 * Extract an image title from the file name
	 *
	 * @param $fileName
	 * @return string
	 */
	protected function processTitleFromFileName($fileName) {
		$title = implode('.', array_slice(explode('.', $fileName),0,-1));
		$title = ucfirst($title);
		$title = str_replace(array('.', '_'), ' ', $title);
		return $title;
	}



	/**
	 * Files will be moved to a directory containing original files
	 * for album before they are processed
	 */
	public function setMoveFilesToOrigsDirectoryToTrue() {
		$this->moveFilesToOrigsDirectory = TRUE;
	}



	/**
	 * Files won't be moved to a directory containing original files
	 * for album before they are processed
	 */
	public function setMoveFilesToOrigsDirectoryToFalse() {
		$this->moveFilesToOrigsDirectory = FALSE;
	}



	/**
	 * Runs everything, that should be done after import
	 * is finished.
	 */
	protected function runPostImportAction() {
		$this->albumContentManager->setAlbumAsGalleryThumbIfNotExisting();
		$this->persistenceManager->persistAll();
	}

}
?>