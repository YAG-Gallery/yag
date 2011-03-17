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
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 */
	protected $configurationManager;
    
    
	
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
    	$this->configurationManager = t3lib_div::makeInstance('Tx_Extbase_Configuration_ConfigurationManager');
    }
    
    
    /**
	 * @var t3lib_fe contains a backup of the current $GLOBALS['TSFE'] if used in BE mode
	 */
	protected $tsfeBackup;

	
	/**
	 * @var string
	 */
	protected $workingDirectoryBackup;
    
    
    
    /**
     * Resizes a given item file
     *
     * @param Tx_Yag_Domain_Model_Item $origFile Item file to be processed
     * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration
     * @return Tx_Yag_Domain_Model_ResolutionFileCache Path to the generated resolution
     */
    public function resizeFile(Tx_Yag_Domain_Model_Item $origFile, Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration) {
    	
    	$resolutionFile = new Tx_Yag_Domain_Model_ResolutionFileCache($origFile,'',0,0,$resolutionConfiguration->getQuality(), $resolutionConfiguration->getName());
    	
    	$resolutionFileRepositoty = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ResolutionFileCacheRepository'); /* @var $resolutionFileRepositoty Tx_Yag_Domain_Repository_ResolutionFileCacheRepository */
    	$resolutionFileRepositoty->add($resolutionFile);
    	
    	// We need an UID for the item file
    	$nextUid = $resolutionFileRepositoty->getCurrentUid();
		
        
        // Get a path in hash filesystem
        $resolutionFileName = substr(uniqid($nextUid.'x'),0,16);
    	$targetFilePath = $this->hashFileSystem->createAndGetAbsolutePathById($nextUid) . '/' . $resolutionFileName . '.jpg';

    	$result = $this->resizeImage(
    	    $resolutionConfiguration,
    	    $origFile->getSourceUri(), // sourceFile
    	    Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($targetFilePath)	// destinationFile
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
    	list($width, $height, $type, $attr) = getimagesize(Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($resolutionFile->getPath()));
  
    	$resolutionFile->setHeight($height);
    	$resolutionFile->setWidth($width);
    }

    
    
	/**
     * Resizes an image to the given values
     * 
     * @param   Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration
     * @param   string  $source  The source file
     * @param   string  $target  The target file
     * @return  void
     */
    protected function resizeImage(Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration, $source, $target) {
    	
    	if (TYPO3_MODE === 'BE') $this->simulateFrontendEnvironment();
    	    	
    	$contentObject = t3lib_div::makeInstance('Tx_Extbase_Configuration_ConfigurationManager')->getContentObject();
    	$typoscriptSettings = Tx_Extbase_Utility_TypoScript::convertPlainArrayToTypoScriptArray($resolutionConfiguration->getSettings());
    	
    	// check for source file to be existing
    	if (!file_exists(Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($source))) {
    		throw new Exception('Source for image conversion does not exist ' . Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($source) . ' 1293395741');
    	}
    	
    	// Check for target path to be existing, create if not exists
    	Tx_Yag_Domain_FileSystem_Div::checkDir(Tx_Yag_Domain_FileSystem_Div::getPathFromFilePath($target));
    	
		if($resolutionConfiguration->getMode() == 'GIFBUILDER') {
			$contentObject->start(array('yagImage' => $source));
			$imageResource = $contentObject->getImgResource('GIFBUILDER', $typoscriptSettings);
		} else {
			$imageResource = $contentObject->getImgResource($source, $typoscriptSettings);
		}

    	if (TYPO3_MODE === 'BE') $this->resetFrontendEnvironment();
		
		$resultImageAbsolute = Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($imageResource[3]);
		
		// check if we have a file
    	if (!file_exists($resultImageAbsolute)) {
    		throw new Exception('Resulting image does not exist ' . $resultImageAbsolute . ' 1300205628');
    	}
		
		if($imageResource[3] == $imageResource['origFile']) {
			// the image was not proccessed, take the original file
			copy($resultImageAbsolute, $target);	
		} else {
			rename($resultImageAbsolute, $target);
		}
		
		return $imageResource;
    }
    
    
    
	/**
	 * Prepares $GLOBALS['TSFE'] for Backend mode
	 * This somewhat hacky work around is currently needed because the getImgResource() function of tslib_cObj relies on those variables to be set
	 *
	 * @return void
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	protected function simulateFrontendEnvironment() {
		$this->tsfeBackup = isset($GLOBALS['TSFE']) ? $GLOBALS['TSFE'] : NULL;
			// set the working directory to the site root
		$this->workingDirectoryBackup = getcwd();
		chdir(PATH_site);

		$typoScriptSetup = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
		$GLOBALS['TSFE'] = new stdClass();
		$template = t3lib_div::makeInstance('t3lib_TStemplate');
		$template->tt_track = 0;
		$template->init();
		$template->getFileName_backPath = PATH_site;
		$GLOBALS['TSFE']->tmpl = $template;
		$GLOBALS['TSFE']->tmpl->setup = $typoScriptSetup;
		$GLOBALS['TSFE']->config = $typoScriptSetup;
	}
	
	
	

	/**
	 * Resets $GLOBALS['TSFE'] if it was previously changed by simulateFrontendEnvironment()
	 *
	 * @return void
	 * @author Bastian Waidelich <bastian@typo3.org>
	 * @see simulateFrontendEnvironment()
	 */
	protected function resetFrontendEnvironment() {
		$GLOBALS['TSFE'] = $this->tsfeBackup;
		chdir($this->workingDirectoryBackup);
	}
}
?>