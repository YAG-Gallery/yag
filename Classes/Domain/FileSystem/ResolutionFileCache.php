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
 * @package Domain
 * @subpackage FileSystem
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_FileSystem_ResolutionFileCache {

	/**
	 * @var Tx_Yag_Domain_Repository_ResolutionFileCacheRepository
	 */
	protected $resolutionFileCacheRepository;
	
	
	/**
	 * @var Tx_Yag_Domain_FileSystem_HashFileSystem
	 */
	protected $hashFileSystem;
	
	
	/**
	 * @var Tx_Yag_Domain_ImageProcessing_AbstractProcessor
	 */
	protected $imageProcessor;
	
	
	
	/**
	 *  Configurationbuilder
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder;
	
	
	
	/**
	 * Acts as 1st level cache to avoid rendering the same
	 * image (eg the file-not-found image) multiple times in one run
	 * without saving it to the database
	 * 
	 * @var array of Tx_Yag_Domain_Model_ResolutionFileCache
	 */
	protected $localResolutionFileCache = array();


	/**
	 * Inject resolution file cache
	 * @param Tx_Yag_Domain_Repository_ResolutionFileCacheRepository $resolutionFileCacheRepository
	 */
	public function injectResolutionFileCacheRepository(Tx_Yag_Domain_Repository_ResolutionFileCacheRepository $resolutionFileCacheRepository) {
		$this->resolutionFileCacheRepository = $resolutionFileCacheRepository;
	}


	/**
	 * Inject hash file system
	 * @param Tx_Yag_Domain_FileSystem_HashFileSystem $hashFileSystem
	 */
	public function _injectHashFileSystem(Tx_Yag_Domain_FileSystem_HashFileSystem $hashFileSystem) {
		$this->hashFileSystem = $hashFileSystem;
	}


	/**
	 * Inject resolution file cache
	 * @param Tx_Yag_Domain_ImageProcessing_AbstractProcessor $imageProcessor
	 */
	public function _injectImageProcessor(Tx_Yag_Domain_ImageProcessing_AbstractProcessor $imageProcessor) {
		$this->imageProcessor = $imageProcessor;
	}



	/**
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 */
	public function _injectConfigurationBuilder(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		$this->configurationBuilder = $configurationBuilder;
	}


	
	/**
	 * Get a file resolution 
	 * 
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration
	 * 
	 * @return Tx_Yag_Domain_Model_ResolutionFileCache
	 */
	public function getItemFileResolutionPathByConfiguration(Tx_Yag_Domain_Model_Item $item, Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration) {
		
		$resolutionFile = $this->getResolutionFileFromLocalCache($resolutionConfiguration, $item);
		
		if($resolutionFile == NULL) {
			$resolutionFile = $this->resolutionFileCacheRepository->getResolutionByItem($item, $resolutionConfiguration);
		}
		
		if($resolutionFile == NULL) {
			$resolutionFile = $this->imageProcessor->generateResolution($item, $resolutionConfiguration);
		}
	
		$this->addResolutionFiletoLocalCache($resolutionFile);
		
		return $resolutionFile; 
	}


	/**
	 * @param $itemArray
	 * @return void
	 */
	public function preloadCacheForItemsAndTheme($itemArray, Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration $themeConfiguration) {
		$imageArray = array();
		$parameterHashArray = array();

		foreach($itemArray as $item) {
			if(is_a($item, 'Tx_PtExtlist_Domain_Model_List_Row') && is_a($item['image']->getValue(), 'Tx_Yag_Domain_Model_Item')) {
				$item = $item['image']->getValue();
				$imageArray[$item->getUid()] = $item;
			}
		}

		foreach($themeConfiguration->getResolutionConfigCollection() as $resolutionConfig) { /** @var $resolutionConfig Tx_Yag_Domain_Configuration_Image_ResolutionConfig */
			$parameterHashArray[] = $resolutionConfig->getParameterHash();
		}

		$resolutions = $this->resolutionFileCacheRepository->getResolutionsByItems($imageArray,$parameterHashArray);
		foreach($resolutions as $resolution) { /** @var $resolution Tx_Yag_Domain_Model_ResolutionFileCache */
			if(is_a($resolution, 'Tx_Yag_Domain_Model_ResolutionFileCache')) {
				$this->addResolutionFiletoLocalCache($resolution);
			}
		}
	}
	
	
	/**
	 * Retrieve a resolution file from local cache
	 * 
	 * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration
	 * @param Tx_Yag_Domain_Model_Item $item
	 */
	protected function getResolutionFileFromLocalCache(Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration, Tx_Yag_Domain_Model_Item $item) {
		$objectIdentifier = md5($resolutionConfiguration->getParameterHash() . $item->getSourceuri());
	
		if(array_key_exists($objectIdentifier, $this->localResolutionFileCache)) {
			return $this->localResolutionFileCache[$objectIdentifier];
		}
		
		return NULL;
	}
	
	
	
	/**
	 * Add cachefileobjrct to local cache
	 * 
	 * @param Tx_Yag_Domain_Model_ResolutionFileCache $cacheFileObject
	 */
	protected function addResolutionFiletoLocalCache(Tx_Yag_Domain_Model_ResolutionFileCache $cacheFileObject) {
		$objectIdentifier = md5($cacheFileObject->getParamhash() . $cacheFileObject->getItem()->getSourceuri());
		$this->localResolutionFileCache[$objectIdentifier] = $cacheFileObject;
	}


	
	/**
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @param $resolutionConfigs Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection
	 */
	public function buildResolutionFilesForItem(Tx_Yag_Domain_Model_Item $item, Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection $resolutionConfigs = NULL) {

		if($resolutionConfigs == NULL) {
			$resolutionConfigs = Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollectionFactory::getInstanceOfAllThemes($this->configurationBuilder);
		}

		foreach($resolutionConfigs as $resolutionConfig) {
			$this->getItemFileResolutionPathByConfiguration($item, $resolutionConfig);
		}
	}

	
	/** 
	 * Clear the whole resolutionFileCache
	 * - Truncate the cache table
	 * - Remove alle files from the cache directory
	 */
	public function clear() {
		
		$GLOBALS['TYPO3_DB']->sql_query('TRUNCATE tx_yag_domain_model_resolutionfilecache');
		
		$cacheDirectoryRoot = $this->configurationBuilder->buildExtensionConfiguration()->getHashFilesystemRootAbsolute();
		Tx_Yag_Domain_FileSystem_Div::rRMDir($cacheDirectoryRoot);
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
		return Tx_Yag_Domain_FileSystem_Div::getDirSize($cacheDirectoryRoot);
	}

}
?>