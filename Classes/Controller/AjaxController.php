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
	 * Initializes the controller
	 */
	protected function initializeAction() {
		$this->itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
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
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		$persistenceManager->persistAll();
		
		// Do some ajax output
		ob_clean();
		echo "OK";
		exit();
	}
	
}
 
?>