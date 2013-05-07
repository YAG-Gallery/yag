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
 * Remote controller for using yag web services
 * 
 * TODO implement RBAC here. Implement method for user login from within
 * TODO implement user login for remote connections external applications.
 * TODO this controller is currently DEACTIVATED in ext_localconf
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_RemoteController extends Tx_Yag_Controller_AbstractController {

	/**
	 * Holds an instance of album repository
	 *
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;
	
	
	
	/**
	 * Holds an instance of gallery repository
	 *
	 * @var Tx_Yag_Domain_Repository_GalleryRepository
	 */
	protected $galleryRepository;
	
	
	
	/**
	 * Initialize this controller
	 */
	protected function postInitializeAction() {
		$this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
		$this->galleryRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository');
	}
	
	
	
	/**
	 * Action for adding an item to an album
	 *
	 * @param int $albumUid UID of album to add image to
	 */
	public function addItemToAlbumAction($albumUid) {
    	$album = $this->albumRepository->findByUid($albumUid);

		$fileName = $_FILES['Filedata']['name'];

		$fileImporter = Tx_Yag_Domain_Import_FileImporter_ImporterBuilder::getInstance()->getImporterInstanceByAlbum($album);

		$fileImporter->setFilePath($_FILES['Filedata']['tmp_name']);
		$fileImporter->setOriginalFileName($fileName);
		$fileImporter->setItemType($_FILES['Filedata']['type']);

		$fileImporter->runImport();

		// Create response
		$jsonArray = array('status' => 0);
		ob_clean();
		echo json_encode($jsonArray);
		exit();
	}
	
	
	
	/**
	 * Returns a list of galleries
	 * 
	 * @return JSON encoded array of galleries
	 */
	public function galleryListAction() {
		$galleries = $this->galleryRepository->findAll();
		$jsonArray = array();
        foreach ($galleries as $gallery) { /* @var $gallery Tx_Yag_Domain_Model_Gallery */
        	$jsonArray['galleries'][] = array (
        	    'uid' => $gallery->getUid(),
        	    'name' => urlencode($gallery->getName())
        	);		
        }
		$jsonArray['status'] = '0';
        ob_clean();
        echo json_encode($jsonArray);
        exit();
	}
	
	
	
	/**
	 * Returns a list of albums
	 * 
	 * @param int $galleryUid UID of gallery to show albums for
	 * @return string JSON encoded array of albums
	 */
	public function albumListAction($galleryUid = NULL) {
		$albums = array();
		if ($galleryUid != NULL) {
			$query = $this->albumRepository->createQuery();
			$query->matching($query->equals('gallery', $galleryUid));
			$albums = $query->execute();
		} else {
		    $albums = $this->albumRepository->findAll();
		}
		$jsonArray = array();
		foreach ($albums as $album) { /* @var $album Tx_Yag_Domain_Model_Album */
			$jsonArray['albums'][] = array(
			    'uid' => $album->getUid(),
			    'name' => urlencode($album->getName())
			);
		}
		$jsonArray['status'] = '0';
		ob_clean();
		header("Content-Type: text/html; charset=utf-8");
		echo json_encode($jsonArray);
		exit();
	}
	
	
	
	/**
	 * Returns status of connection test
	 * 
	 * @return string JSON encoded array of albums
	 */
	public function testConnectionAction() {
		$jsonArray = array('status' => '0');
        ob_clean();
        echo json_encode($jsonArray);
        exit();
	}
	
}

?>