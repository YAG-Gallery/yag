<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
 *           Daniel Lienert <daniel@lienert.cc>
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
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_FileSystem_Div {

	/**
	 * Returns installation base path of typo3 installation
	 *
	 * @return string  Base path of typo3 installation
	 */
	public static function getT3BasePath() {
		return PATH_site;
	}



	/**
	 * Make the given path absolute under the typo3 path
	 *
	 * @param string $path
	 * @return string absolute path
	 */
	public static function makePathAbsolute($path) {
		if(substr($path,0,strlen(PATH_site)) != PATH_site) {
			$path = self::concatenatePaths(array(PATH_site, $path));
		}

		return $path;
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
	 * @param   $directory   String  The Directory to check
	 * @return  boolean true if it was posible to create the directory
	 */
	public static function checkDir($directory) {
		if ( FALSE === (@opendir($directory)) ) {
			t3lib_div::mkdir( $directory );
		}
		return is_dir($directory);
	}



	/**
	 * Returns the filename part of a file path
	 *
	 * @param string $filePath      File path to extract filename from
	 * @return string filename
	 */
	public static function getFilenameFromFilePath($filePath) {
		if (is_dir($filePath)) return '';
		return basename($filePath);
	}



	/**
	 * Returns an array of files for a directory given by path
	 *
	 * @param string $path Path of directory to search for files in
	 * @param string $pattern  Pattern that files must match
	 * @return array   Array of file paths for given directory matching given pattern
	 * @throws Exception
	 */
	public static function getFilesByPathAndPattern($path, $pattern) {
		$pathHandle = opendir($path);
		if ($pathHandle != FALSE ) {
			$imageFiles = array();
			while (FALSE !== ($filename = readdir($pathHandle))) {
				// TODO make this configurable via TS!
				if (preg_match($pattern, $filename)) {
					$imageFiles[] = $filename;
				}
			}
			return $imageFiles;
		} else {
			throw new Exception('Error when trying to open dir: ' . $path, 1349680912);
		}
	}



	/**
	 * Returns the directory path part of a file path
	 *
	 * @static
	 * @param $filePath
	 * @return string
	 */
	public static function getPathFromFilePath($filePath) {
		$dirInfo = dirname($filePath);
		return $dirInfo;
	}


	/**
	 * @param $fileName
	 * @return string
	 */
	public function cleanFileName($fileName) {
		return t3lib_div::makeInstance('t3lib_basicFileFunctions')->cleanFileName($fileName);
	}


	/**
	 * Creates a temporary directory
	 *
	 * @param string $dir
	 * @param string $prefix
	 * @param integer $mode
	 * @return string  Path to temporary directory
	 */
	public static function tempdir($dir, $prefix='', $mode=0700) {
		if (substr($dir, -1) != '/') $dir .= '/';

		do {
			$path = $dir.$prefix.mt_rand(0, 9999999);
		} while (!mkdir($path, $mode));

		return $path;
	}



	/**
	 * Recursively remove all files and directorys
	 *
	 * @static
	 * @param $dir
	 * @throws Exception
	 */
	public static function rRMDir($dir) {

		if(!trim($dir)) Throw new Exception('Cant delete directory. Directory path was empty!', 1298041824);
		if(!is_dir($dir)) Throw new Exception('Cant delete directory. Directory '.$dir.' not found!', 1298041904);

		if (is_dir($dir)) {
			$objects = scandir($dir);

			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					
					if (filetype($dir."/".$object) == "dir") {
						self::rRMDir($dir."/".$object);
					} else {
						unlink($dir."/".$object);
					}
					
				}
			}
			
			reset($objects);
			rmdir($dir);
		}
	}
	
	
	
	/**
	 * Get size of directory
	 * 
	 * @param string $dir
	 * @return integer
	 */
	public static function getDirSize($dir) {
		if (!is_dir($dir)) return FALSE;
		$size = 0;
		$dh = opendir($dir);

		while(($entry = readdir($dh)) !== FALSE) {
			if($entry == "." || $entry == "..")
			continue;
			if(is_dir( $dir . "/" . $entry))
			$size += self::getDirSize($dir . "/" . $entry);
			else
			$size += filesize($dir . "/" . $entry);
		}

		closedir($dh);
		return $size;
	}



	/**
	 * Expand the EXT to a relative path
	 *
	 * @param string $filename
	 * @return string
	 */
	public function getFileRelFileName($filename) {

		if (substr($filename, 0, 4) == 'EXT:') { // extension
			list($extKey, $local) = explode('/', substr($filename, 4), 2);
			$filename = '';
			if (strcmp($extKey, '') && t3lib_extMgm::isLoaded($extKey) && strcmp($local, '')) {
				if(TYPO3_MODE === 'FE') {
					$filename = t3lib_extMgm::siteRelPath($extKey) . $local;
				} else {
					$filename = t3lib_extMgm::extRelPath($extKey) . $local;
				}
			}
		}

		 return  TYPO3_MODE === 'BE' ?  $filename : $GLOBALS['TSFE']->absRefPrefix . $filename;
	}



	/**
	 * Gets the entries accessible by backend user file mounts
	 *
	 * @param $path
	 * @return array
	 */
	public function getBackendAccessibleDirectoryEntries($path) {

		$basicFileFunctions = t3lib_div::makeInstance('t3lib_basicFileFunctions'); /** @var t3lib_basicFileFunctions $basicFileFunctions */
		$basicFileFunctions->init($this->getVersionIndependableFileMounts(),$GLOBALS['TYPO3_CONF_VARS']['BE']['fileExtensions']);

		$returnArray = array();

		if(is_dir($path)) {

			$entries = scandir($path);
			natcasesort($entries);

			foreach ($entries as $entry) {
				if (!($entry == '.') && !($entry == '..')) {
					if(!is_dir($path.$entry) || $basicFileFunctions->checkPathAgainstMounts($path.$entry . '/') !== NULL) {
						$returnArray[] = $entry;
					}
				}
			}
		}

		return $returnArray;
	}



	/**
	 * Return the filemount paths of the backend user
	 *
	 * @return array
	 */
	public function getBackendFileMountPaths() {
		$returnArray = array();
		$fileMounts = $this->getVersionIndependableFileMounts();

		foreach($fileMounts as $fileMount) {
			$returnArray[] = $fileMount['path'];
		}

		natcasesort($returnArray);

		return $returnArray;
	}



	/**
	 * @return mixed
	 */
	protected function getVersionIndependableFileMounts() {

		if(t3lib_div::compat_version('6.0')) {

			$fileMounts = array();

			if($GLOBALS['BE_USER']->user['admin'] == 1) $fileMounts[]['path'] = $this->getT3BasePath() . 'fileadmin/';

			$fileStorages = $GLOBALS['BE_USER']->getFileStorages();
			foreach($fileStorages as $fileStorage) { /** @var TYPO3\CMS\Core\Resource\ResourceStorage $fileStorage */

				$configuration = $fileStorage->getConfiguration();
				$basePath = $configuration['basePath'];

				foreach($fileStorage->getFileMounts() as $fileMount) {
					$relativeFolder = substr($fileMount['path'],0,1) === '/' ? substr($fileMount['path'],1) : $fileMount['path'];
					$fileMounts[]['path'] = $this->getT3BasePath() . $basePath . $relativeFolder;
				}
			}

			return $fileMounts;

		} else {
			return $GLOBALS['FILEMOUNTS'];
		}
	}


	/**
	 * Originally from the TYPO3 Flow Package!
	 *
	 * Replacing backslashes and double slashes to slashes.
	 * It's needed to compare paths (especially on windows).
	 *
	 * @param string $path Path which should transformed to the Unix Style.
	 * @return string
	 */
	static public function getUnixStylePath($path) {
		if (strpos($path, ':') === FALSE) {
			return str_replace('//', '/', str_replace('\\', '/', $path));
		} else {
			return preg_replace('/^([a-z]{2,}):\//', '$1://', str_replace('//', '/', str_replace('\\', '/', $path)));
		}
	}



	/**
	 * Originally from the TYPO3 Flow Package!
	 *
	 * Properly glues together filepaths / filenames by replacing
	 * backslashes and double slashes of the specified paths.
	 * Note: trailing slashes will be removed, leading slashes won't.
	 * Usage: concatenatePaths(array('dir1/dir2', 'dir3', 'file'))
	 *
	 * @param array $paths the file paths to be combined. Last array element may include the filename.
	 * @return string concatenated path without trailing slash.
	 * @see getUnixStylePath()
	 */
	static public function concatenatePaths(array $paths) {
		$resultingPath = '';
		foreach ($paths as $index => $path) {
			$path = self::getUnixStylePath($path);
			if ($index === 0) {
				$path = rtrim($path, '/');
			} else {
				$path = trim($path, '/');
			}
			if (strlen($path) > 0) {
				$resultingPath .= $path . '/';
			}
		}
		return rtrim($resultingPath, '/');
	}
}

?>