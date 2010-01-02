<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de
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
 * Class definition file for a GalleryController testcase.
 * 
 * @version $Id:$
 */



/**
 * Class implements a testcase for a GalleryController
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-01-01
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Controller_GalleryController_testcase extends Tx_Extbase_BaseTestCase {

	/**
	 * Holds TS configuration of yag extension
	 * @var array
	 */
	private $configuration;
	
	
	
	/**
     * @var Tx_Yag_Tests_Mocks_GalleryControllerMock 
     */
	private $galleryController;
	
	
	
	/**
	 * @var Tx_Extbase_Dispatcher
	 */
	private $dispatcher;
	
	
	
	/**
	 * Sets up environment for testing gallery controller
	 * 
	 * @return void
	 * @author Michael Knoll <mimi@kaktusteam.de>
	 */
	public function setUp() {
		// This is needed for some basic initialization!
		$this->dispatcher = new Tx_Extbase_Dispatcher();
		$this->configuration = Tx_Yag_Tests_Mocks_ConfigurationMocks::getBasicConfiguration();
		$this->galleryController = t3lib_div::makeInstance('Tx_Yag_Tests_Mocks_GalleryControllerMock');
		$this->galleryController->injectMockView(new Tx_Fluid_View_TemplateView());
		$this->galleryController->injectMockRepository(new Tx_Yag_Tests_Mocks_GalleryRepositoryMock());
        $this->galleryController->injectSettings($this->configuration['settings']); 
        
        /**
         * IDEA: do not use "normal" view but a mocked version to check for the corresponding contents...
         */
	}
	
	
	
	/**
	 * Tests index action of gallery controller
	 * @test
	 */
	public function indexAction() {
		$this->galleryController->indexAction();
	}
	
	
	
	/**
	 * Tests show action of gallery controller
	 * @test
	 */
	public function showAction() {
		$this->galleryController->showAction(new Tx_Yag_Domain_Model_Gallery());
	}
	
	
	
	/**
	 * Tests edit action of gallery controller
	 * @test
	 */
	public function editAction() {
		$this->galleryController->editAction(new Tx_Yag_Domain_Model_Gallery());
	}
	
	
	
	/**
	 * Tests update action of gallery controller
	 * @test
	 */
	public function updateAction() {
		$this->setUp();
		$this->galleryController->updateAction(new Tx_Yag_Domain_Model_Gallery());
	}
	
	
	
	/**
	 * Tests delete action with given "really delete" flag
	 * @test
	 */
	public function deleteActionWithDelete() {
		$this->setUp();
		$request = new Tx_Extbase_MVC_Web_Request();
		$request->setArgument('reallyDelete', 1);
		$this->galleryController->setRequest($request);
		$this->galleryController->deleteAction(new Tx_Yag_Domain_Model_Gallery());
	}

}
?>
