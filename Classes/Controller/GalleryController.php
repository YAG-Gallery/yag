<?php

/***************************************************************
*  Copyright notice
*
*  (c) "now" could not be parsed by DateTime constructor. Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
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
 * Controller for the Gallery object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


class Tx_Yag_Controller_GalleryController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * Holds a reference to a gallery repository
	 *
	 * @var Tx_Yag_Domain_Repository_galleryRepository
	 */
	private $galleryRepository;
	
	
	
	/**
	 * Initialize Controller
	 * 
	 * @return void
	 */
	public function initializeAction() {
		$this->galleryRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository');
	}
	
	
	
	/**
	 * Action that is run, whenever a list of galleries should be displayed
	 * 
	 * @return string  The rendered index action
	 */
	public function indexAction() {
		#print_r($this->galleryRepository->findAll());
		#print_r($this->galleryRepository->findByPageId(6));
		$this->view->assign('galleries', $this->galleryRepository->findByPageId(6));
		#$this->view->assign('galleries',$this->galleryRepository->findAll());
	}
	
	
	
	/**
	 * Action that is run, whenever a single galery should be displayed
	 *
	 * @return string The rendered show action
	 */
	public function showAction(Tx_Yag_Domain_Model_Gallery  $gallery) {
		$this->view->assign('gallery', $gallery);
	}
	
	/**
	 * edit action
	 *
	 * @return string The rendered edit action
	 */
	public function editAction() {
	}
	
	/**
	 * create action
	 *
	 * @return string The rendered create action
	 */
	public function createAction() {
		return 'CreateAction()';
	}
	
}
?>
