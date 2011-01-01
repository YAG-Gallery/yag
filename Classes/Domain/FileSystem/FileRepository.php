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
 * @package Domain
 * @subpackage FileSystem
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_FileSystem_FileRepository {

	/**
	 * @var Tx_Yag_Domain_Repository_ResolutionFileCacheRepository
	 */
	protected $resolutionFileCacheRepository;
	
	
	/**
	 * @var Tx_Yag_Domain_FileSystem_HashFileSystem
	 */
	protected $hashFileSystem;
	
	
	/**
	 * @var Tx_Yag_Domain_ImageProcessing_Processor
	 */
	protected $imageProcessor;
	
	
	
	/**
	 *  Configurationbuilder
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder;
	

	
	/**
	 * Get a file resolution 
	 * 
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfiguration $resolutionConfiguration
	 */
	public function getItemFileResolutionPathByConfiguration(Tx_Yag_Domain_Model_Item $item, Tx_Yag_Domain_Configuration_Image_ResolutionConfiguration $resolutionConfiguration) {
		$resolutionFile = $this->resolutionFileCacheRepository->getItemFilePathByConfiguration($item, $resolutionConfiguration);
		
		if($resolutionFile == NULL) {
			$resolutionFile = $this->imageProcessor->resizeFile($item, $resolutionConfiguration);
		}
	
		$hfsPath = $this->hashFileSystem->getRelativePathById($resolutionFile->getUid());
		$rootPath = $this->configurationBuilder->buildExtensionConfiguration()->getHashFilesystemRoot();
		
		return $rootPath . '/' . $hfsPath . '/' . $item->getUid() .'.jpg';
	}
	
	
	
	/**
	 * Inject hash file system
	 * @param Tx_Yag_Domain_FileSystem_HashFileSystem $hashFileSystem
	 */
	public function injectHashFileSystem(Tx_Yag_Domain_FileSystem_HashFileSystem $hashFileSystem) {
		$this->hashFileSystem = $hashFileSystem;
	}
	
	
	
	/**
	 * Inject resolution file cache
	 * @param Tx_Yag_Domain_Repository_ResolutionFileCacheRepository $resolutionCachRepository
	 */
	public function injectResolutionFileCacheRepository(Tx_Yag_Domain_Repository_ResolutionFileCacheRepository $resolutionFileCachRepository) {
		$this->resolutionFileCacheRepository = $resolutionFileCachRepository;
	}
	
	
	
	/**
	 * Inject resolution file cache
	 * @param Tx_Yag_Domain_ImageProcessing_Processor $imageProcessor
	 */
	public function injectImageProcessor(Tx_Yag_Domain_ImageProcessing_Processor $imageProcessor) {
		$this->imageProcessor = $imageProcessor;
	}
		
	
	
	public function injectConfigurationBuilder(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		$this->configurationBuilder = $configurationBuilder;
	}
	
}
?>