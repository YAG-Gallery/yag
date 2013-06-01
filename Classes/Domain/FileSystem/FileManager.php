<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2012 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Class implements a file manager for handling file system operations in yag g
 *
 * @author Daniel Lienert
 * @package Domain
 * @subpackage FileSystem
 */
class Tx_Yag_Domain_FileSystem_FileManager implements t3lib_Singleton {


	/**
	 * Remove the file if it is located within its album path.
	 * That means, it does not remove files located in an other directory (like files imported by the directory importer)
	 *
	 * @param Tx_Yag_Domain_Model_Item $item
	 */
	public function removeImageFileFromAlbumDirectory(Tx_Yag_Domain_Model_Item $item) {
		$albumPath = $this->getOrigFileDirectoryPathForAlbum($item->getAlbum());
		$imageFilePath = Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($item->getSourceuri());
		if(t3lib_div::isFirstPartOfStr($imageFilePath, $albumPath) && file_exists($imageFilePath)) {
			unlink($imageFilePath);
		}
	}



	/**
	 * @param Tx_Yag_Domain_Model_Album $album
	 */
	public function removeAlbumDirectory(Tx_Yag_Domain_Model_Album $album) {
		$albumPath = $this->getOrigFileDirectoryPathForAlbum($album);
		Tx_Yag_Domain_FileSystem_Div::rRMDir($albumPath);
	}



	/**
	 * Creates path for original files on server.
	 * If path does not exist, it will be created if given parameter is true.
	 *
	 * @param Tx_Yag_Domain_Model_Album $album
	 * @param bool $createIfNotExists If set to true, directory will be created if it does not exist
	 * @return string Path for original images (absolute)
	 */
	public function getOrigFileDirectoryPathForAlbum(Tx_Yag_Domain_Model_Album $album, $createIfNotExists = TRUE) {
		$path =  Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()->buildExtensionConfiguration()->getOrigFilesRootAbsolute() . '/' . $album->getUid() . '/';
		if ($createIfNotExists) Tx_Yag_Domain_FileSystem_Div::checkDir($path);
		return $path;
	}


}
?>