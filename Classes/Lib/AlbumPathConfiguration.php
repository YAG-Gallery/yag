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
 * Class definition file for a album path class.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

/**
 * Class holds information about all path configurations for a album
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Typo3
 * @subpackage yag
 * @since 2009-12-22
 */
class Tx_Yag_Lib_AlbumPathConfiguration {
	
	/**
	 * Holds the base path to the directory where the gallery images are stored in
	 * @var string
	 */
	protected $basePath;
	
	
	
	/**
	 * Holds the path of the sub dir where the thumbs are stored inside the album directory (relative to basePath)
	 * @var string
	 */
	protected $thumbsPath;
	
	
	
	/**
	 * Holds the path of the sub dir, where the singles are stored inside the album directory (relative to basePath)
	 * @var string
	 */
	protected $singlesPath;
	
	
	
	/**
	 * Holds the path of the sub dir, where the original images are stored inside the album directory (relative to basePath)
	 * @var string
	 */
	protected $origsPath;
	
	
	
	/**
	 * Returns an instance of this class
	 *
	 * @param string $basePath
	 * @param string $thumbsPath
	 * @param string $singlesPath
	 * @param string $origsPath
	 * @return Tx_Yag_Domain_Lib_AlbumPathConfiguration    Instance of this class
	 */
	public static function getInstanceByPaths($basePath, $thumbsPath, $singlesPath, $origsPath) {
		return new Tx_Yag_Lib_AlbumPathConfiguration($basePath, $thumbsPath, $singlesPath, $origsPath);
	}
	
	
	
	/**
	 * Returns an instance of this class for a given albumPathObject
	 *
	 * @param Tx_Yag_Lib_AlbumPathSettingsInterface $albumPathObject   Object holding album paths
	 * @return Tx_Yag_Domain_Lib_AlbumPathConfiguration    Instance of this class
	 */
	public static function getInstanceByAlbumPathObject(Tx_Yag_Lib_AlbumPathSettingsInterface $albumPathObject) {
		return new Tx_Yag_Lib_AlbumPathConfiguration(
		  $albumPathObject->getBasePath(),
		  $albumPathObject->getThumbsPath(),
		  $albumPathObject->getSinglesPath(),
		  $albumPathObject->getOrigsPath()
		);
	}
	
	
	
	/**
	 * Constructor for this class (protected) use "getInstance" methods instead!
	 *
	 * @param string $basePath
	 * @param string $thumbsPath
	 * @param string $singlesPath
	 * @param string $origsPath
	 */
	protected function __construct($basePath, $thumbsPath, $singlesPath, $origsPath) {
		if (is_dir(Tx_Yag_Div_YagDiv::getBasePath() . Tx_Yag_Div_YagDiv::getFileadminPath() . $basePath)) {
			$this->basePath = $basePath;
		} else {
			throw new Exception('Given base path is not a directory: ' . Tx_Yag_Div_YagDiv::getBasePath() . Tx_Yag_Div_YagDiv::getFileadminPath() . $basePath);
		}
		
		$this->basePath = $this->addPrependingSlash($basePath); 
		
		$this->addAsSubPathOrThrowException($thumbsPath);
		$this->addAsSinglesPathOrThrowException($singlesPath);
		$this->addAsOrigsPathOrThrowException($origsPath);
		
	}
	
	
	
	/**
	 * Adds a '/' at the end of the given path, if there isn't one already
	 *
	 * @param string $path
	 * @return string
	 */
	protected function addPrependingSlash($path) {
		if ($path != '' && substr($path, -1) != '/')
		    return $path . '/';
		else 
		    return $path;
	}
	
	
	
	/**
	 * Adds given path as thumbs path if path is correct
	 *
	 * @param string $thumbsPath
	 * @param bool   $throwExceptionIfNotExists  Should method throw an exception if path does not exist?
	 */
    protected function addAsSubPathOrThrowException($thumbsPath, $throwExceptionIfNotExists = false) {
        if (!$this->isSubDirPath($thumbsPath) && $throwExceptionIfNotExists) {
            throw new Exception('Given thumbs path is not a directory inside base path: ' . $this->basePath . $thumbsPath);
        }
        $this->thumbsPath = $this->addPrependingSlash($thumbsPath);
    }
    
    
    
    /**
     * Adds given path as singles path if path is correct
     *
     * @param string $singlesPath
     * @param bool   $throwExceptionIfNotExists  Should method throw an exception if path does not exist?
     */
    protected function addAsSinglesPathOrThrowException($singlesPath, $throwExceptionIfNotExists = false) {
        if (!$this->isSubDirPath($singlesPath) && $throwExceptionIfNotExists) {
            throw new Exception('Given singles path is not a directory inside base path: ' . $this->basePath . $singlesPath);
        }
        $this->singlesPath = $this->addPrependingSlash($singlesPath);
    }
    
    
    
    /**
     * Adds given path as origs path if path is correct
     *
     * @param string $origsPath
     * @param bool   $throwExceptionIfNotExists  Should method throw an exception if path does not exist?
     */
    protected function addAsOrigsPathOrThrowException($origsPath, $throwExceptionIfNotExists = false) {
    	if (!$this->isSubDirPath($origsPath) && $throwExceptionIfNotExists) {
            throw new Exception('Given singles path is not a directory inside base path: ' . $this->basePath . $origsPath);
        }
        $this->origsPath = $this->addPrependingSlash($origsPath);
    }
	
	
	
    /**
     * Returns true if given subdirectory path is a correct path inside base path
     *
     * @param string $subDirPath    Path inside base path to check for whether it exists
     * @return boolean  True, if path exists inside base path
     */
	protected function isSubDirPath($subDirPath) {
		return is_dir(Tx_Yag_Div_YagDiv::getBasePath() . Tx_Yag_Div_YagDiv::getFileadminPath() . $this->basePath . $subDirPath);
	}
	
	
	
	/**
	 * Returns base path relative to Typo3 fileadmin
	 *
	 * @return unknown
	 */
	public function getBasePath() {
		return $this->basePath;
	}
	
	
	
	/**
	 * Returns absolute path to base path including Typo3 installation path and fileadmin path
	 *
	 * @return string
	 */
	public function getFullTypo3BasePath() {
		return Tx_Yag_Div_YagDiv::getBasePath() . Tx_Yag_Div_YagDiv::getFileadminPath() . $this->getBasePath();
	}
	
	
	
	/**
	 * Returns absolute path to original files no matter whether origsPath has been set or not
	 *
	 * @return string
	 */
	public function getFullTypo3OrigsPath() {
		if ($this->origsPath != '')
		    return $this->getFullTypo3BasePath() . $this->origsPath;
		else 
		    return $this->getFullTypo3BasePath(); 
	}
	
	
	
	/**
	 * Returns thumbs path relative to base path
	 *
	 * @return string
	 */
	public function getThumbsPath() {
		return $this->thumbsPath;
	}
	
	
	
	/**
	 * Returns singles path relative to base path
	 *
	 * @return string
	 */
	public function getSinglesPath() {
		return $this->singlesPath;
	}
	
	
	
	/**
	 * Returns original images path relative to base path
	 *
	 * @return string
	 */
	public function getOrigsPath() {
		return $this->origsPath;
	}
	
	
	
	/**
	 * Returns thumbs path relative to typo3 installation root
	 *
	 * @return string
	 */
	public function getThumbsPathRelativeToTypo3Root() {
		return Tx_Yag_Div_YagDiv::getFileadminPath() . $this->getBasePath() . $this->getThumbsPath();
	}

	
	
	/**
	 * Returns singles path relative to typo3 installation root
	 *
	 * @return string
	 */
	public function getSinglesPathRelativeToTypo3Root() {
		return Tx_Yag_Div_YagDiv::getFileadminPath() . $this->getBasePath() . $this->getSinglesPath();
	}
	
	
	
	/**
	 * Returns origs path relative to typo3 installation root
	 *
	 * @return unknown
	 */
	public function getOrigsPathRelativeToTypo3Root() {
		return Tx_Yag_Div_YagDiv::getFileadminPath() . $this->getBasePath() . $this->getOrigsPath();
	}
}

?>
