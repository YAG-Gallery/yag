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
 * @package yag
 * @subpackage Domain\ImageProcessing
 * @author Michael Knoll <knoll@punkt.de>
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
     * @param Tx_Yag_Domain_Model_ItemFile $origFile Item file to be processed
     * @return Tx_Yag_Domain_Model_ItemFile Processed item file
     */
    public function resizeFile(Tx_Yag_Domain_Model_ItemFile $origFile, Tx_Yag_Domain_Model_Resolution $resolution) {
    	$newItemFile = new Tx_Yag_Domain_Model_ItemFile();
    	$itemFileRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemFileRepository');
    	$itemFileRepository->add($newItemFile);
    	
    	// We need an UID for the item file, so we have to persist it here
    	$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager'); /* @var $persistenceManager Tx_Extbase_Persistence_Manager */
        $persistenceManager->persistAll();
        
        // Get a path in hash filesystem
    	$targetFilePath = $this->hashFileSystem->createAndGetAbsolutePathById($newItemFile->getUid()) . '/' . $newItemFile->getUid() . '.jpg';
    	
    	# var_dump('Trying to read ' . $file->getFullFilePath() . ' and write to ' . $targetFilePath . ' with width: ' . $resolution->getWidth() . ' and height: ' . $resolution->getHeight() . '<br />');
    	// TODO get quality from configuration
    	Tx_Yag_Domain_ImageProcessing_Div::resizeImage(
    	    $resolution->getWidth(),     // width
    	    $resolution->getHeight(),    // height
    	    80,                          // quality
    	    $origFile->getPath(),        // sourceFile
    	    $targetFilePath              // destinationFile
    	);

    	return new Tx_Yag_Domain_Model_ItemFile($targetFilePath, 'resizedFile');
    	
    }
	
}

?>