<?php
/***************************************************************
* Copyright notice
*
*   2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
* All rights reserved
*
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* Abstract image processor
*
* @package Domain
* @subpackage Processor
* @author Daniel Lienert <daniel@lienert.cc>
*/

abstract class Tx_Yag_Domain_ImageProcessing_AbstractProcessor implements Tx_Yag_Domain_ImageProcessing_ProcessorInterface {

	
	/**
	 * Holds configuration for image processor
	 *
	 * @var Tx_Yag_Domain_Configuration_ImageProcessing_ProcessorConfiguration
	 */
    protected $configuration;
	
    
	
	/**
     * Holds an instance of hash file system for this gallery
     *
     * @var Tx_Yag_Domain_FileSystem_HashFileSystem
     */
    protected $hashFileSystem;
    
    
    /**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 */
	protected $configurationManager;
	
	
	
	/**
	 * @var Tx_Yag_Domain_Repository_ResolutionFileCacheRepository
	 */
	protected $resolutionFileRepository;
	
	
	
	/**
	 * @param Tx_Yag_Domain_Configuration_ImageProcessing_ImageProcessorConfiguration $configuration
	 */
	public function __construct(Tx_Yag_Domain_Configuration_ImageProcessing_ImageProcessorConfiguration $configuration) {
		$this->configuration = $configuration;
	}
	
	
	
	/**
	 * 
	 * Init the concrete image processor
	 */
	public function init() {}
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/ImageProcessing/Tx_Yag_Domain_ImageProcessing_ProcessorInterface::generateResolution()
	 */
	public function generateResolution(Tx_Yag_Domain_Model_Item $origFile, Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration) {
		
		$resolutionFile = new Tx_Yag_Domain_Model_ResolutionFileCache($origFile,'',0,0,0,$resolutionConfiguration->getName());
    	
    	$resolutionFileRepositoty = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionFileCacheRepository'); /* @var $resolutionFileRepositoty Tx_Yag_Domain_Repository_ResolutionFileCacheRepository */
    	$resolutionFileRepositoty->add($resolutionFile);
    	
    	t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager')->persistAll();
    	    	
		$this->processFile($resolutionConfiguration, $origFile, $resolutionFile);
		
		return $resolutionFile;
	}
	
	
	
	/**
	 * Process a file and set the resulting path in the resolution file object
	 * 
	 * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration
	 * @param Tx_Yag_Domain_Model_Item $origFile
	 * @param Tx_Yag_Domain_Model_ResolutionFileCache $resolutionFile
	 */
	abstract protected function processFile(Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration, Tx_Yag_Domain_Model_Item $origFile, Tx_Yag_Domain_Model_ResolutionFileCache $resolutionFile);
	
	
	
	
	/**
	 * Build and return the target file path of the resolution file
	 * 
	 * @param string $fileSuffix
	 * @return string $targetFilePath
	 */
	protected function generateAbsoluteResolutionPathAndFilename($extension = 'jpg') {
		// We need an UID for the item file
    	$nextUid = $this->resolutionFileRepository->getCurrentUid();
    	
    	// Get a path in the hash filesystem
        $resolutionFileName = substr(uniqid($nextUid.'x'),0,16);
    	$targetFilePath = $this->hashFileSystem->createAndGetAbsolutePathById($nextUid) . '/' . $resolutionFileName . '.' . $extension;
    	
    	return $targetFilePath;
	}
	

	
	/**
	 * @param Tx_Extbase_Configuration_ConfigurationManager $configurationManager
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManager $configurationManager) {
		$this->configurationManager = $configurationManager;
	}
	
	
	
	/**
	 * @param Tx_Yag_Domain_FileSystem_HashFileSystem $hashFileSystem
	 */
	public function injectHashFileSystem(Tx_Yag_Domain_FileSystem_HashFileSystem $hashFileSystem) {
		$this->hashFileSystem = $hashFileSystem;
	}
	
	
	
	/**
	 * @param Tx_Yag_Domain_Repository_ResolutionFileCacheRepository $resolutionFileRepository
	 */
	public function injectResolutionFileRepository(Tx_Yag_Domain_Repository_ResolutionFileCacheRepository $resolutionFileRepository) {
		$this->resolutionFileRepository = $resolutionFileRepository;
	}
}
?>