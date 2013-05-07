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
 * Class implements image processor
 *
 * @package Domain
 * @subpackage ImageProcessing
 * @author Michael Knoll <mimi@kaktsuteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_ImageProcessing_Typo3Processor extends Tx_Yag_Domain_ImageProcessing_AbstractProcessor {

    /**
	 * @var t3lib_fe contains a backup of the current $GLOBALS['TSFE'] if used in BE mode
	 */
	protected $tsfeBackup;
	

	
	/**
	 * @var string
	 */
	protected $workingDirectoryBackup;
	
    
    
    /**
     * (non-PHPdoc)
     * @see Classes/Domain/ImageProcessing/Tx_Yag_Domain_ImageProcessing_AbstractProcessor::processFile()
     */
	protected function processFile(Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration, Tx_Yag_Domain_Model_Item $origFile, Tx_Yag_Domain_Model_ResolutionFileCache $resolutionFile) {

		if (TYPO3_MODE === 'BE') {
			$this->simulateFrontendEnvironment();
		}

		// check if the item has a source uri set
		if(trim($origFile->getSourceuri()) == '') {
			throw new Tx_Yag_Exception_InvalidPath('No Source URI set for Item ' . $origFile->getUid(), 1357896895);
		}

		$expectedDirectoryForOrigImage = Tx_Yag_Domain_FileSystem_Div::makePathAbsolute(Tx_Yag_Domain_FileSystem_Div::getPathFromFilePath($origFile->getSourceuri()));

		// check for source directory to be existing
		if (!file_exists($expectedDirectoryForOrigImage)) {
			// we "re-create" missing directory so that file-not-found can be handled correctly
			// even if the directory has been deleted (by accident) and we can display
			// a file-not-found image instead of an Exception
			if (!mkdir($expectedDirectoryForOrigImage)) {
				throw new Exception('Tried to create new directory ' . $expectedDirectoryForOrigImage . ' but could not create this directory! 1345272425');
			}
		}


		// check for source file to be existing
		if (!file_exists(Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($origFile->getSourceuri()))) {
			// if the original image for processed image is missing, we copy file-not-found file as source
			$fileNotFoundImageSourceUri = $this->processorConfiguration->getConfigurationBuilder()->buildSysImageConfiguration()->getSysImageConfig('imageNotFound')->getSourceUri();
			copy($fileNotFoundImageSourceUri, $origFile->getSourceuri());
		}

		$imageResource = $this->getImageResource($origFile->getSourceuri(), $resolutionConfiguration);
		$resultImagePath = $imageResource[3];
		$resultImagePathAbsolute = Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($resultImagePath);

		$imageTarget = $this->generateAbsoluteResolutionPathAndFilename(end(explode(".", $resultImagePathAbsolute)), $origFile->getTitle());

		// check if we have a file
		if (!file_exists($resultImagePathAbsolute) || !is_file($resultImagePathAbsolute)) {
			throw new Exception(sprintf('No result image was created. SourceImagePath: %s, ResultImagePath: %s', $origFile->getSourceuri(), $resultImagePathAbsolute), 1300205628);
		}
		
		if ($imageResource[3] == $imageResource['origFile']) {
			// the image was not processed, take the original file
			copy($resultImagePathAbsolute, $imageTarget);
		} else {
			rename($resultImagePathAbsolute, $imageTarget);
		}
		
		// set resolutionFileObject
		$resolutionFile->setPath($imageTarget);
		$resolutionFile->setWidth($imageResource[0]);
		$resolutionFile->setHeight($imageResource[1]);
		
		//$this->typo3CleanUp($imageResource);
		
		if (TYPO3_MODE === 'BE') $this->resetFrontendEnvironment();
		
		return $imageResource;
    }
    
    
    
    /**
     * Wrapper for cObj->getImageResource in FE and BE
     * 
     * @param string $imageSource path to image resource
     * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration
     * @return array $imageData
     */
    protected function getImageResource($imageSource, Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration) {
    	
    	$typoScriptSettings = t3lib_div::makeInstance('Tx_Extbase_Service_TypoScriptService')->convertPlainArrayToTypoScriptArray($resolutionConfiguration->getSettings());
    	
    	$contentObject = t3lib_div::makeInstance('Tx_Extbase_Configuration_ConfigurationManager')->getContentObject(); /** @var $contentObject tslib_cObj */

    	if($resolutionConfiguration->getMode() == 'GIFBUILDER') {
			$contentObject->start(array('yagImage' => $imageSource));
			$imageResource = $contentObject->getImgResource('GIFBUILDER', $typoScriptSettings);
		} else {
			$imageResource = $contentObject->getImgResource($imageSource, $typoScriptSettings);
		}
   
    	return $imageResource;
    }

    
    
    /**
     * As we have our own resolution file cache system
     * we dont want to polute the TYPO3 cache_imagesizes table.
     * So we remove the generated image (messy, but the only way ...)
     * 
     * @param $imageResource filename to remove from table
     */
    protected function typo3CleanUp($imageResource) {
    	$GLOBALS['TYPO3_DB']->exec_DELETEquery(
			'cache_imagesizes',
			'filename=' . $GLOBALS['TYPO3_DB']->fullQuoteStr($imageResource[3], 'cache_imagesizes')
    	);
    	
    	unset($GLOBALS['TSFE']->tmpl->fileCache[$imageResource['fileCacheHash']]);
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