<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <knoll@punkt.de>
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
 * Directory based importer importing files for a given directory on the server
 *
 * @package Domain
 * @subpackage Import\LightroomImporter
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Domain_Import_LightroomImporter_Importer extends Tx_Yag_Domain_Import_AbstractImporter {
	
	/**
	 * Implementing interface method for import
	 * 
	 * TODO add error handling here
	 */
	public function runImport() {
		// Create item for new image
		$item = new Tx_Yag_Domain_Model_Item();
		$this->itemRepository->add($item);
		$this->persistenceManager->persistAll(); // This is required so that we get an UID for item which we need here!
		
		// Save original file
		$origFileDirectoryPath = $this->configurationBuilder->buildGeneralConfiguration()->getOrigFilesRootAbsolute() . '/' . $this->album->getUid() . '/';
		error_log('Orig file path: ' . $origFileDirectoryPath);
		Tx_Yag_Domain_FileSystem_Div::checkDir($origFileDirectoryPath);
		// TODO what about file ending here?
		$origFilePath = $origFileDirectoryPath . '/' . $item->getUid() . '.jpg';
		move_uploaded_file($_FILES['file']['tmp_name'], $origFilePath);
		
		// add item to album
		$this->albumContentManager->addItem($item);
	}

}

?>
