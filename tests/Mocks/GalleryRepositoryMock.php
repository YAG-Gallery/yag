<?php

class Tx_Yag_Tests_Mocks_GalleryRepositoryMock implements Tx_Extbase_Persistence_RepositoryInterface {
	
	public function add($object) {
	
	}
	
	public function findAll() {
	
	}
	
	public function findByUid($uid) {
	
	}
	
	public function getAddedObjects() {
	
	}
	
	public function getRemovedObjects() {
	
	}
	
	public function remove($object) {
	
	}
	
	public function findByPageId($pageId) {
		$gallery = new Tx_Yag_Domain_Model_Gallery();
		$gallery->setName('Testgallery');
		$galleryCollection = new Tx_Extbase_Persistence_ObjectStorage();
		$galleryCollection->attach($gallery);
		return $galleryCollection;
	}
	
	public function update($object) {
		
	}
}

?>
