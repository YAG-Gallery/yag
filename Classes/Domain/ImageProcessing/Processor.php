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
 * Class implements image processor
 *
 * @package Domain
 * @subpackage ImageProcessing
 * @author Michael Knoll <knoll@punkt.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_ImageProcessing_Processor {
	
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
     * Constructor for image processor
     *
     * @param Tx_Yag_Domain_Configuration_ImageProcessing_ImageProcessorConfiguration $configuration
     */
    public function __construct(Tx_Yag_Domain_Configuration_ImageProcessing_ImageProcessorConfiguration $configuration) {
    	$this->configuration = $configuration;
    	$this->init();
    }
    
    
    
    /**
     * Initialize Processor
     *
     */
    protected function init() {
    	$this->hashFileSystem = Tx_Yag_Domain_FileSystem_HashFileSystemFactory::getInstance();
    }
    
    
    
    /**
     * Resizes a given item file
     *
     * @param Tx_Yag_Domain_Model_Item $origFile Item file to be processed
     * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration
     * @return Tx_Yag_Domain_Model_ResolutionFileCache Path to the generated resolution
     */
    public function resizeFile(Tx_Yag_Domain_Model_Item $origFile, Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration) {
    	
    	$resolutionFile = new Tx_Yag_Domain_Model_ResolutionFileCache($origFile,'',0,0,$resolutionConfiguration->getQuality());
    	
    	$resolutionFileRepositoty = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionFileCacheRepository');
    	$resolutionFileRepositoty->add($resolutionFile);
    	
    	// We need an UID for the item file, so we have to persist it here
    	$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager'); /* @var $persistenceManager Tx_Extbase_Persistence_Manager */
        $persistenceManager->persistAll();
        
        // Get a path in hash filesystem
    	$targetFilePath = $this->hashFileSystem->createAndGetAbsolutePathById($resolutionFile->getUid()) . '/' . $resolutionFile->getUid() . '.jpg';
    	
    	$result = Tx_Yag_Domain_ImageProcessing_Div::resizeImage(
    	    $resolutionConfiguration->getWidth(),     // width
    	    $resolutionConfiguration->getHeight(),    // height
    	    $resolutionConfiguration->getQuality(),   // quality
    	    $origFile->getSourceUri(),        // sourceFile
    	    $targetFilePath              // destinationFile
    	);

    	$resolutionFile->setPath($targetFilePath);
		$this->setImageDimensionsInResolutionFile($resolutionFile);
    	
    	return $resolutionFile;
    }
    
    
    
    /**
     * Set the resulting resolutio to the object
     * 
     * @param Tx_Yag_Domain_Model_ResolutionFileCache $resolutionFile
     */
    protected function setImageDimensionsInResolutionFile(Tx_Yag_Domain_Model_ResolutionFileCache $resolutionFile) {
    	list($width, $height, $type, $attr) = getimagesize($resolutionFile->getPath());
    	
    	$resolutionFile->setHeight($height);
    	$resolutionFile->setWidth($width);
    }   
}
?>