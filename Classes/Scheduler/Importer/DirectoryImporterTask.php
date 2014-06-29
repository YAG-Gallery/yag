<?php
namespace YAG\Yag\Scheduler\Importer;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Daniel Lienert <daniel@lienert.cc>
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
 * YAG Scheduler Task
 *
 * @package YAG
 * @subpackage Scheduler
 */
class DirectoryImporterTask extends \YAG\Yag\Scheduler\AbstractTask {


	/**
	 * @var string
	 */
	protected $importDirectoryRoot;


	/**
	 * @var \Tx_Yag_Utility_PidDetector
	 */
	protected $pidDetector;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 */
	protected $persistenceManager;

	/**
	 * @var integer
	 */
	protected $storageSysFolder;

	/**
	 * @var \Tx_Yag_Domain_Repository_GalleryRepository
	 */
	protected $galleryRepository;

	/**
	 * @var \Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;

	/**
	 * @var \Tx_Yag_Domain_Repository_ItemRepository
	 */
	protected $itemRepository;

	/**
	 * @var array
	 */
	protected $galleryStructureCache = array();


	protected function initializeScheduler() {
		$this->pidDetector = $this->objectManager->get('\\Tx_Yag_Utility_PidDetector');
		$this->pidDetector->setPids(array($this->storageSysFolder));

		$this->persistenceManager = $this->objectManager->get('\\TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
		$this->galleryRepository = $this->objectManager->get('\\Tx_Yag_Domain_Repository_GalleryRepository');
	}



	public function execute() {

	}


	protected function import() {
		$directoryEntries = \Tx_Yag_Domain_FileSystem_Div::readDirectoryRecursively($this->importDirectoryRoot);

		

	}


	protected function convertPathToGalleryStructur($path) {
		list($galleryName, $albumName, $itemFileName) = explode('/', $path);

	}


	protected function selectOrCreateGallery($galleryName) {
		$gallery = $this->galleryRepository->findOneByName($galleryName);
		
		if($gallery === NULL) {
			$gallery = new \Tx_Yag_Domain_Model_Gallery();
			$gallery->setName($galleryName);
			$gallery->setPid($this->storageSysFolder);
			$this->galleryRepository->add($gallery);
			$this->persistenceManager->persistAll();
		}
		
		return $gallery;
	}


	/**
	 * @param string $importDirectoryRoot
	 */
	public function setImportDirectoryRoot($importDirectoryRoot) {
		$this->importDirectoryRoot = $importDirectoryRoot;
	}

	/**
	 * @return string
	 */
	public function getImportDirectoryRoot() {
		return $this->importDirectoryRoot;
	}

	/**
	 * @param int $storageSysFolder
	 */
	public function setStorageSysFolder($storageSysFolder) {
		$this->storageSysFolder = $storageSysFolder;
	}

	/**
	 * @return int
	 */
	public function getStorageSysFolder() {
		return $this->storageSysFolder;
	}

}