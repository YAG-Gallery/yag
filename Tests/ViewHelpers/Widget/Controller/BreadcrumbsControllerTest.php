<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Testcase for album content manager
 *
 * @package Tests
 * @subpackage ViewHelpers\Widget\Controller
 * @author Daniel Lienert
 */
class Tx_Yag_Tests_ViewHelpers_Widget_Controller_BreadCrumbsController_testcase extends Tx_Yag_Tests_BaseTestCase {

	/**
	 * @var Tx_Yag_ViewHelpers_Widget_Controller_BreadcrumbsController
	 */
	protected $fixture;
	
	
	
	public function setup() {
		$this->fixture = $this->getAccessibleMock('Tx_Yag_ViewHelpers_Widget_Controller_BreadcrumbsController', array('dummy'), array());
	}
	
	
	
	/**
	 * 
	 * @returns array
	 */
	public static function breadCrumbViewArrayDataProvider() {
		return array(
			'Gallery List Mode :  Gallery Listpage' => array('gallery_list', 'gallery_list', array('gallery_list' => 'gallery_list')),
			'Gallery List Mode :  Album Listpage ' => array('gallery_list', 'gallery_index', array('gallery_list' => 'gallery_list',
																					'gallery_index' => 'gallery_index')),
			'Gallery List Mode :  Image Listpage' => array('gallery_list', 'itemlist_list', array(
																					'gallery_list' => 'gallery_list',
																					'gallery_index' => 'gallery_index',
																					'itemlist_list' => 'itemlist_list',)),
			'Gallery List Mode :  Image' => array('gallery_list', 'item_show', array('gallery_list' => 'gallery_list',
																					'gallery_index' => 'gallery_index',
																					'itemlist_list' => 'itemlist_list',
																					'item_show' => 'item_show')),
			'Gallery showSingle :  Album Listpage ' => array('Gallery_showSingle', 'gallery_index', array('gallery_index' => 'gallery_index')),
			'Album List Mode :  Album Listpage ' => array('gallery_index', 'gallery_index', array('gallery_index' => 'gallery_index')),
			'Album List Mode :  Image Listpage' => array('gallery_index', 'itemlist_list', array('gallery_index' => 'gallery_index',
																					'itemlist_list' => 'itemlist_list',)),
			'Album List Mode :  Image' => array('gallery_index', 'item_show', array('gallery_index' => 'gallery_index',
																					'itemlist_list' => 'itemlist_list',
																					'item_show' => 'item_show')),
			'Album Single :  Image Listpage' => array('Album_showSingle', 'itemlist_list', array('itemlist_list' => 'itemlist_list')),
			'Image List Mode :  Image Listpage' => array('itemlist_list', 'itemlist_list', array('itemlist_list' => 'itemlist_list')),
			'Image List Mode :  Image' => array('itemlist_list', 'item_show', array('itemlist_list' => 'itemlist_list',
																					'item_show' => 'item_show')),
		);
	}
	
	
	/**
	* @test
	* @dataProvider breadCrumbViewArrayDataProvider
	*/
	public function buildBreadsCrumbViewArray($defaultPluginControllerAction, $currentControllerAction, $resultArray) {
		$this->assertEquals($resultArray, $this->fixture->_call('buildBreadsCrumbViewArray', $defaultPluginControllerAction, $currentControllerAction)
							);
	}
	
}
?>