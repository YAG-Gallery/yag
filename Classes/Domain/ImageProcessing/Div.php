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
     * @param   int     $width   The maximum image width
     * @param   int     $height  The maximum image height
     * @param   string  $source  The source file
     * @param   string  $target  The target file
     * @return  void
     */
    public static function resizeImage($width, $height, $quality, $source, $target) {
    	
    	// check for source file to be existing
    	if (!file_exists($source)) {
    		throw new Exception('Source for image conversion does not exist ' . $source . ' 1293395741');
    	}
    	// Check for target path to be existing, create if not exists
    	Tx_Yag_Domain_FileSystem_Div::checkDir(Tx_Yag_Domain_FileSystem_Div::getPathFromFilePath($target));
    	
        if (self::isImageMagickInstalled()) {
            $stdGraphic = self::getStdGraphicObject();
            $info = $stdGraphic->getImageDimensions($source);
<<<<<<< HEAD
            $options = array();
            $options["maxH"] = $height;
            $options["maxW"] = $width;
=======
            #print_r("info: "); print_r($info);
            $options = array();
            $options["maxH"] = $height;
            $options["maxW"] = $width;
            #print_r("options: "); print_r($options);
>>>>>>> 763010c0c4545c3bda2dd9b68f3df4aa15a801c0
            $data = $stdGraphic->getImageScale($info, $width."m", $height."m", $options);   
            $params = '-geometry '.$data[0].'x'.$data[1].'! -quality '.$quality.' ';
            
            $imageMagickCommandString =  $params.' "'.$source.'" "'.$target.'"';
            $cmd = t3lib_div::imageMagickCommand('convert',$imageMagickCommandString);
            
            $im = array();
            $im["string"] = $cmd;
            $im["error"] = shell_exec($cmd.' 2>&1');
            return $im;
        } else {
<<<<<<< HEAD
=======
        	throw new Exception('It seems like you do not have ImageMagick installed or properly configured. Go to install tool and fix this to make YAG working! 1295896595');
        	/*
>>>>>>> 763010c0c4545c3bda2dd9b68f3df4aa15a801c0
            // Get new dimensions
            list($width_orig, $height_orig) = getimagesize($source);
            
            if ($width && ($width_orig < $height_orig)) {
               $width = ($height / $height_orig) * $width_orig;
            } else {
               $height = ($width / $width_orig) * $height_orig;
            }
            
            // Resample
            $image_p = imagecreatetruecolor($width, $height);
            $image = imagecreatefromjpeg($source);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            
            // Output
            imagejpeg($image_p, $target, $quality);
<<<<<<< HEAD
=======
            */
>>>>>>> 763010c0c4545c3bda2dd9b68f3df4aa15a801c0
        }
        
    }
    
    
    
    /**
     * Returns instance of standard typo3 graphics object
     *
     * @return t3lib_stdGraphic
     */
    public function getStdGraphicObject() {
    	return t3lib_div::makeInstance("t3lib_stdGraphic");
    }
    
    
    
    /**
     * Returns instance of Typo3 standard graphics object
     * @return t3lib_stdgraphic
     */
    public static function getGfxObject() {
    	return t3lib_div::makeInstance("t3lib_stdgraphic");
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