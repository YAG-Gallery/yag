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
 * Testcase for album content manager
 *
 * @package yag
 * @subpackage Tests\Performance
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Tests_Performance_YagPerformanceTest extends Tx_Yag_Tests_BaseTestCase {

	
	protected $galleryCount = 10;
	
	protected $albumsPerGalleryCount = 20;
	
	protected $itemsPerGalleryCount = 30;
	
	
	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;
	
	
	public function setup() {
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
	}
	
	
	/**
	 * @test
	 */
	public function testPerformance() {
		// $this->createGalleries();

		$this->objectManager->get('Tx_Extbase_Persistence_Manager')->persistAll();
		echo 'Note: This test creates multiple galleries / albums /images. You have to activate this test manually in the sourcecode.';
	}

	
	protected function createGalleries() {

		$galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository'); /* @var $galleryRepository Tx_Yag_Domain_Repository_GalleryRepository */
		
		for($i=1; $i<=$this->galleryCount;$i++) {
			$gallery = new Tx_Yag_Domain_Model_Gallery();
			$gallery->setName('TestGallery ' . $i);
			$galleryRepository->add($gallery);
			
			$this->createAlbums($gallery);
		}
	}
	
	
	protected function createAlbums(Tx_Yag_Domain_Model_Gallery $gallery) {
		
		$albumRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_AlbumRepository'); /* @var $albumRepository Tx_Yag_Domain_Repository_AlbumRepository */
		
		for($i=1; $i<=$this->albumsPerGalleryCount;$i++) {
			$album = new Tx_Yag_Domain_Model_Album();
			$album->setName('TestAlbum ' . $i);
			$album->setDescription('Created on ' . date('d.m.Y H:i:s'));
			$album->setGallery($gallery);
			$albumRepository->add($album);
			
			$this->createItems($album);
		}
	}
	
	protected function createItems(Tx_Yag_Domain_Model_Album $album) {
		
		$itemRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository'); /* @var $itemRepository Tx_Yag_Domain_Repository_ItemRepository */ 
		
		for($i=1; $i<=$this->itemsPerGalleryCount;$i++) {
			$item = new Tx_Yag_Domain_Model_Item();
			$item->setTitle('TestItem ' . $i);
			$item->setAlbum($album);
			$item->setSourceuri('typo3conf/ext/yag/Tests/Performance/testImage.jpg');
			
			$itemRepository->add($item);
		}
	}
}
?>