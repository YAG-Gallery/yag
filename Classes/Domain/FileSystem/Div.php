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
 * Class implements some static methods for file handling.
 * 
 * @package Domain
 * @subpackage FileSystem
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_FileSystem_Div {

    /**
     * Returns installation base path of typo3 installation
     *
     * @return string  Base path of typo3 installation
     */
    public static function getT3BasePath() {
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
     * Returns the filename part of a file path
     *
     * @param string $filePath      File path to extract filename from
     */
    public static function getFilenameFromFilePath($filePath) {
        if (is_dir($filePath)) return '';
        $matches = array();
        preg_match('/(.+)\/(.+)/', $filePath, $matches);
        $filename = $matches[2];
        return $filename;
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
     * Creates a temporary directory
     *
     * @param string $dir
     * @param string $prefix
     * @param string $mode
     * @return string  Path to temporary directory
     */
    public static function tempdir($dir, $prefix='', $mode=0700) {
        if (substr($dir, -1) != '/') $dir .= '/';

        do {
            $path = $dir.$prefix.mt_rand(0, 9999999);
        } while (!mkdir($path, $mode));

        return $path;
    }
	
}

?>
