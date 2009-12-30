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
 * Library with static methods for YAG Gallery extension
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


/**
 * Class implements some static methods for YAG gallery
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Div_YagDiv {
	
	/**
	 * Returns installation base path of typo3 installation
	 *
	 * @return string  Base path of typo3 installation
	 */
	public static function getBasePath() {
		$scriptPath = PATH_thisScript;
		$scriptPathStripped = str_replace('index.php', '', $scriptPath);
		return $scriptPathStripped;
	}
	
	
	
	/**
	 * Returns path of directory that is configured as fileadmin
	 *
	 * @return string  Path to fileadmin
	 */
	public static function getFileadminPath() {
		return 'fileadmin/';
	}
	
	
	
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
    	
    	// check for directories to be existing
    	self::checkDir(self::getPathFromFilePath($source));
    	self::checkDir(self::getPathFromFilePath($target));
    	
        // seems to be non-used $gfxObj = self::getGfxObject();
        if (self::isImageMagickInstalled()) {
            $stdGraphic = self::getStdGraphicObject();
            $info = $stdGraphic->getImageDimensions($source);
            $options = array();
            $options["maxH"] = $height;
            $options["maxW"] = $width;
            $data = $stdGraphic->getImageScale($info, $width."m", $height."m", $options);   
            $params = '-geometry '.$data[0].'x'.$data[1].'! -quality '.$quality.' ';
            
            $cmd = t3lib_div::imageMagickCommand('convert', $params.' "'.$source.'" "'.$target.'"');
            
            $im = array();
            $im["string"] = $cmd;
            $im["error"] = shell_exec($cmd.' 2>&1');
            
            return $im;
        } else {
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
    
    
    /**
     * function checkDir($directory)
     * Checks if a directory exists, and if not creates it
     * 
     * @param   directory   String  The Directory to check
     * 
     * @return  void
     */
    public static function checkDir($directory) {
        if ( false === (@opendir($directory)) ) {
            t3lib_div::mkdir( $directory );
        }
    }
    
    
    
    /**
     * Returns the directory path part of a file path
     *
     * @param string $filePath      File path to extract directory path from
     */
    public static function getPathFromFilePath($filePath) {
    	$matches = array();
    	preg_match('/(.+)\//', $filePath, $matches);
    	$pathPart = $matches[1];
    	return $pathPart;
    }
    
    
    
    /**
     * Returns an array of files for a directory given by path
     *
     * @param string $path Path of directory to search for files in
     * @param string $pattern  Pattern that files must match
     * @return array   Array of file paths for given directory matching given pattern
     */
    public static function getFilesByPathAndPattern($path, $pattern) {
        $pathHandle = opendir($path);
        if ($pathHandle != false ) {
            $imageFiles = array();
            while (false !== ($filename = readdir($pathHandle))) {
                // TODO make this configurable via TS!
                if (preg_match($pattern, $filename)) {
                    $imageFiles[] = $filename;
                }
            }
            return $imageFiles;
        } else {
            throw new Exception('Error when trying to open dir: ' . $path);
        }
    }
    
    
    
    /**
     * Returns a fe user domain object for a currently logged in user 
     * or NULL if no user is logged in.
     *
     * @return Tx_Extbase_Domain_Model_FrontendUser  FE user object
     */
    public static function getLoggedInUserObject() {
    	$feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
    	if ($feUserUid > 0) {
	    	$feUserRepository = t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository'); /* @var $feUserRepository Tx_Extbase_Domain_Repository_FrontendUserRepository */
	    	return $feUserRepository->findByUid(intval($feUserUid));
    	} else {
    		return NULL;
    	}
    }
    
    
    
    /**
     * Returns groups of currently logged in frontend user or null if no fe user is logged in.
     *
     * @return Tx_Extbase_Persistence_ObjectStorage     Object storage with fe user groups for currently logged in user
     */
    public static function getLoggedInUserGroups() {
    	$feUserObject = self::getLoggedInUserObject(); /* @var $feUserObject Tx_Extbase_Domain_Model_FrontendUser */
    	if (!is_null($feUserObject)) {
    		return $feUserObject->getUsergroups();
    	} else {
    		return NULL;
    	}
    }
    
    
    
    /**
     * Returns true, if currently logged in user is in given fe user group
     *
     * @param int   $groupId   The group UID for in which we want to know wheter the user belongs to
     * @return bool     True, if currently logged in fe user belongs to given group
     */
    public static function isLoggedInUserInGroup($groupId) {
    	 $loggedInFeUserGroups = self::getLoggedInUserGroups();
    	 if (!is_null($loggedInFeUserGroups)) {
    	 	foreach($loggedInFeUserGroups as $feUserGroup) { /* @var $feUserGroup Tx_Extbase_Domain_Model_FrontendUserGroup */
    	 		if ($feUserGroup->getUid() == $groupId) {
    	 			return true; 
    	 		}
    	 	}
    	 }
    	 return false;
    }
    
    
    
    /**
     * Returns true, if the currently logged in user is in one of the 
     * given fe groups
     *
     * @param array $feUserGroupUids
     * @return unknown
     */
    public static function isLoggedInUserInGroups($feUserGroupUids) {
    	foreach($feUserGroupUids as $feUserGroupUid) {
    		if (self::isLoggedInUserInGroup($feUserGroupUid))
    		    return true;
    	}
    	return false;
    }
	
}

?>