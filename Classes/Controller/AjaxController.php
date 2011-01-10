<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Class implements a controller for YAG ajax requests
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_AjaxController extends Tx_Yag_Controller_AbstractController {
	
	/**
	 * Holds an instance of item repository
	 *
	 * @var Tx_Yag_Domain_Repository_ItemRepository
	 */
	protected $itemRepository;
	
	
	
	/**
     * Holds an instance of album repository
     *
     * @var Tx_Yag_Domain_Repository_AlbumRepository
     */
	protected $albumRepository;
	
	
	
	/**
	 * Holds an instance of persistence manager
	 *
	 * @var Tx_Extbase_Persistence_Manager
	 */
	protected $persistenceManager;
	

	
	/**
	 * Initializes the controller
	 */
	protected function initializeAction() {
		$this->itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
		$this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
		$this->persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
	}
	
	
	
	/**
	 * Returs auto complete data for directory picker
	 *
	 * @param string $directoryStart Beginning of directory to do autocomplete
	 * @return string JSON array of directories
	 */
	public function directoryAutoCompleteAction($directoryStartsWith = '') {
		$directoryStartsWith = urldecode($directoryStartsWith);
		$baseDir = 'fileadmin/';
		$subDir = '';
		if (substr($directoryStartsWith, -1) == '/' && is_dir(Tx_Yag_Domain_FileSystem_Div::getT3BasePath() . $baseDir . '/' . $directoryStartsWith)) {
			$subDir = $directoryStartsWith;
		}
		
		$directories = scandir(Tx_Yag_Domain_FileSystem_Div::getT3BasePath() . $baseDir. $subDir);
		
		$returnArray = array(
		                  array('directoryStartsWith' => $directoryStartsWith),
		                  array('baseDir' => $baseDir),
		                  array('subDir' => $subDir),
		                  array('debug' => $_GET),
		                  array('directories' => $directories)
	                  );

	    foreach($directories as $directory) {
	    	if (is_dir(Tx_Yag_Domain_FileSystem_Div::getT3BasePath() . $baseDir . $subDir . $directory)
	    	      && !($directory == '.') && !($directory == '..')) 
	    	    $returnArray[] = array('value' => $subDir . $directory);
	    }
	                  
		ob_clean();
		header('Content-Type: application/json;charset=UTF-8');
		echo json_encode($returnArray);
		exit();
	}
	
	
	
	/**
	 * Deletes an item
	 *
	 * @param int $itemUid UID of item
	 */
	public function deleteItemAction($itemUid) {
		$item = $this->itemRepository->findByUid(intval($itemUid)); /*@var $item Tx_Yag_Domain_Model_Item */ 
		$item->delete();
		
		// As we cancel ExtBase lifecycle in this action, we have to persist manually!
		$this->persistenceManager->persistAll();
		
		// Do some ajax output
		ob_clean();
		echo "OK";
		exit();
	}
	
	
	
	/**
	 * Updates name of a given item
	 *
	 * @param int $itemUid UID of item to update
	 * @param string $itemTitle New name of item
	 */
	public function updateItemNameAction($itemUid, $itemTitle) {
		$item = $this->itemRepository->findByUid(intval($itemUid)); /*@var $item Tx_Yag_Domain_Model_Item */
		$item->setTitle($itemTitle);
		
		$this->itemRepository->update($item);
		$this->persistenceManager->persistAll();
		
        ob_clean();
        echo "OK";
        exit();
	}
	
	
	
	/**
	 * Sets an item as thumb file for album
	 *
	 * @param int $itemUid UID of item to set as thumb
	 */
	public function setItemAsAlbumThumbAction($itemUid) {
		$item = $this->itemRepository->findByUid(intval($itemUid));
		// This is really brainfuck here... we cannot update album directly via associated object, as ExtBase can't resolve this...
		$query = $this->albumRepository->createQuery();
		$query->statement('UPDATE tx_yag_domain_model_album SET thumb = ' . intval($itemUid) . ' WHERE uid = ' . $item->getAlbum()->getUid())->execute();
		
        ob_clean();
        echo "OK";
        exit();
	}
	
	
	
	/**
	 * Updates description for a given item
	 *
	 * @param int $itemUid UID of item to update
	 * @param string $itemDescription Description of item
	 */
	public function updateItemDescriptionAction($itemUid, $itemDescription) {
		$item = $this->itemRepository->findByUid(intval($itemUid)); /*@var $item Tx_Yag_Domain_Model_Item */
		$item->setDescription($itemDescription);
		
		$this->itemRepository->update($item);
		$this->persistenceManager->persistAll();
		
        ob_clean();
        echo "OK";
        exit();
	}
	
	
	
	/**
	 * Updates sorting of items in an album
	 * 
	 */
	public function updateAlbumSortingAction() {
		// TODO implement me!
		$order = $_POST['imageUid'];
		
		foreach($order as $index => $itemUid) {
			$item = $this->itemRepository->findByUid($itemUid);
			$item->setSorting($index);
			$this->itemRepository->update($item);
		}
		
		$this->persistenceManager->persistAll();
		
		ob_clean();
		echo "OK";
		exit();
	}
	
	
	
	/**
	 * Updates title of album
	 *
	 * @param int $albumUid UID of album to be updated
	 * @param string $albumTitle Title to be set as album title
	 */
	public function updateAlbumTitleAction($albumUid, $albumTitle) {
		// We do this for escaping reasons
		#$album = $this->albumRepository->findByUid(intval($albumUid));
		// Due to ExtBase issues - we have to use ugly SQL
		// see http://forge.typo3.org/issues/9270
		$query = $this->albumRepository->createQuery();
        $query->statement('UPDATE tx_yag_domain_model_album SET name = "' . $albumTitle . '" WHERE uid = ' . $albumUid)->execute();

		ob_clean();
        echo "OK";
        exit();
	}
	
	
	
	/**
	 * Updated description of an album
	 *
	 * @param int $albumUid UID of album to be updated
	 * @param string $albumDescription Description to be set as album description
	 */
	public function updateAlbumDescriptionAction($albumUid, $albumDescription) {
		// TODO implement me!
        ob_clean();
        echo "OK";
        exit();
	}
	
}
 
?>