<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*            
*           
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
 * Class implements some static methods for image processing
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Domain
 * @subpackage ImageProcessing
 */
class Tx_Yag_Domain_ImageProcessing_Div {
	
    /**
     * Resizes an image to the given values
     * 
     * @param   Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration
     * @param   string  $source  The source file
     * @param   string  $target  The target file
     * @return  void
     */
    public static function resizeImage(Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration, $source, $target) {
    	
    	$contentObject = t3lib_div::makeInstance('Tx_Extbase_Configuration_ConfigurationManager')->getContentObject();
    	$typoscriptSettings = Tx_Extbase_Utility_TypoScript::convertPlainArrayToTypoScriptArray($resolutionConfiguration->getSettings());
    	
    	// check for source file to be existing
    	if (!file_exists(Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($source))) {
    		throw new Exception('Source for image conversion does not exist ' . Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($source) . ' 1293395741');
    	}
    	
    	// Check for target path to be existing, create if not exists
    	Tx_Yag_Domain_FileSystem_Div::checkDir(Tx_Yag_Domain_FileSystem_Div::getPathFromFilePath($target));
    	
		if($resolutionConfiguration->getMode() == 'GIFBUILDER') {
			$imageResource = $contentObject->getImgResource('GIFBUILDER', $typoscriptSettings);
		} else {
			$imageResource = $contentObject->getImgResource($source, $typoscriptSettings);
		}

		$resultImage = $imageResource[3] ? $imageResource[3] : $imageResource['origFile'];
		$resultImageAsbolute = Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($resultImage);
		
		// check if we have a file
    	if (!file_exists($resultImageAsbolute)) {
    		throw new Exception('Resulting image does not exist ' . $resultImageAsbolute . ' 1300205628');
    	}
		
		if($imageResource[3]) {
			// the image was proccessed
			rename($resultImageAsbolute, $target);	
		} else {
			copy($resultImageAsbolute, $target);
		}
		
		return $imageResource;
    }
    
    
    /**
     * Returns true, if Image Magick is installed on this typo3 installation
     *
     * @return boolean  True, if Image Magick is installed
     */
    public static function isImageMagickInstalled() {
    	return ($GLOBALS['TYPO3_CONF_VARS']['GFX']['im'] == 1);
    }
}

?>