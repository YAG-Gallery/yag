<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <lienert@punkt.de>, Michael Knoll <knoll@punkt.de>
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
     * Constructor for image processor
     *
     * @param Tx_Yag_Domain_Configuration_ImageProcessing_ProcessorConfiguration $configuration
     */
    public function __construct(Tx_Yag_Domain_Configuration_ImageProcessing_ProcessorConfiguration $configuration) {
    	$this->configuration = $configuration;
    }
    
    
    
    /**
     * Resizes a given item file
     *
     * @param Tx_Yag_Domain_Model_ItemFile $origFile Item file to be processed
     * @return Tx_Yag_Domain_Model_ItemFile Processed item file
     */
    public function resizeFile(Tx_Yag_Domain_Model_ItemFile $origFile, Tx_Yag_Domain_Model_Resolution $resolution) {
    	// TODO make this configurable
    	$hashFileSystem = new Tx_Yag_Domain_Filehandling_HashFileSystem('/var/www/kunden/pt_list_dev.centos.localhost/fileadmin/yag/');
    	$newItemFile = new Tx_Yag_Domain_Model_ItemFile();
    	$itemFileRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemFileRepository');
    	$itemFileRepository->add($newItemFile);
    	
    	// We need an UID for the item file, so we have to persist it here
    	$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager'); /* @var $persistenceManager Tx_Extbase_Persistence_Manager */
        $persistenceManager->persistAll();
        
    	$targetFilePath = $hashFileSystem->getAbsolutePathById($newItemFile->getUid()) . '/' . $newItemFile->getUid() . '.jpg';
    	
    	// Create target path, if it does not exist
    	// TODO put this into hash file system
    	$targetDirectory = Tx_Yag_Domain_Filehandling_Div::getPathFromFilePath($targetFilePath);
    	Tx_Yag_Domain_Filehandling_Div::checkDir($targetDirectory);
    	
    	# var_dump('Trying to read ' . $file->getFullFilePath() . ' and write to ' . $targetFilePath . ' with width: ' . $resolution->getWidth() . ' and height: ' . $resolution->getHeight() . '<br />');
    	// TODO get quality from configuration
    	Tx_Yag_Domain_ImageProcessing_Div::resizeImage(
    	    $resolution->getWidth(),     // width
    	    $resolution->getHeight(),    // height
    	    80,                          // quality
    	    $origFile->getPath(),        // sourceFile
    	    $targetFilePath              // destinationFile
    	);

    	return new Tx_Yag_Domain_Model_ItemFile($targetFilePath, $origFile->getName());
    	
    }
	
}

?>