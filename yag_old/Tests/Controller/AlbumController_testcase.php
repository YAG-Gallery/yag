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
 * Class definition file for a AlbumController testcase.
 * 
 * @version $Id:$
 */



/**
 * Class implements a testcase for an AlbumController
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-31
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Controller_AlbumController_testcase extends Tx_Extbase_BaseTestCase {

	/**
	 * Simple setup test
	 * @test
	 */
	public function testTest() {
		$this->assertEquals(1,1);
	}
	
	
	
	/**
	 * Tests index action of album controller
	 * @test
	 */
	public function indexAction() {
		$dispatcher = t3lib_div::makeInstance('Tx_Extbase_Dispatcher'); /* @var $dispatcher Tx_Extbase_Dispatcher */
		$configuration = Array (
			    'userFunc' => 'tx_extbase_dispatcher->dispatch',
			    'pluginName' => 'Pi1',
			    'extensionName' => 'Yag',
			    'controller' => 'Gallery',
			    'action' => 'index',
			    'switchableControllerActions.' => Array
			        (
			            '1.' => Array
			                (
			                    'controller' => 'Gallery',
			                    'actions' => 'index,show,edit,new,create,delete,update,removeAlbum,addAlbum'
			                ),
			
			            '2.' => Array
			                (
			                    'controller' => 'Album',
			                    'actions' => 'index,show,new,create,delete,edit,update,editImages,updateImages,rss'
			                ),
			
			            '3.' => Array
			                (
			                    'controller' => 'AlbumContent',
			                    'actions' => 'index,addImagesByPath,addImagesByFile'
			                ),
			
			            '4.' => Array
			                (
			                    'controller' => 'Image',
			                    'actions' => 'single,delete,edit,update'
			                )
			
			        ),
			    'settings' => array
			        (
	                    'adminGroups' => 1,
				        'album' => array
			                 (
					            'rssPid' => 5,
					            'itemsPerPage' => 12        
			                 )
                    ),
			    'persistence' => array
                    (
                        'storagePid' => 6
                    ),
			    'view' => array
                    (
	                    'templateRootPath' => 'EXT:yag/Resources/Private/Templates/',
	                    'partialRootPath' => 'EXT:yag/Resources/Private/Partials/',
	                    'layoutRootPath' => 'EXT:yag/Resources/Private/Layouts/'
                    )
			);
			
		//$dispatcher->dispatch('', $configuration);
		
	}
	

}
?>
