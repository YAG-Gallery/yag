<?php

namespace TYPO3\CMS\Yag\Fal\Driver;

/***************************************************************
*  Copyright notice
*
*  (c) 2010-2012 Daniel Lienert <daniel@lienert.cc>
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


class YagDriver extends \TYPO3\CMS\Core\Resource\Driver\AbstractDriver {

	/**
	 * Extbase Object Manager
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;


	/**
	 * @var \Tx_Yag_Utility_PidDetector
	 */
	protected $pidDetector;

	/**
	 * @var \Tx_Yag_Domain_FileSystem_Div
	 */
	protected $yagFileSystemDiv;


	/**
	 * Initializes this object. This is called by the storage after the driver
	 * has been attached.
	 *
	 * @return void
	 */
	public function initialize() {
		$this->capabilities = \TYPO3\CMS\Core\Resource\ResourceStorage::CAPABILITY_BROWSABLE | \TYPO3\CMS\Core\Resource\ResourceStorage::CAPABILITY_PUBLIC; // | \TYPO3\CMS\Core\Resource\ResourceStorage::CAPABILITY_WRITABLE;

		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Extbase_Object_ObjectManager');
	}


	/**
	 * Checks if a configuration is valid for this driver.
	 * Throws an exception if a configuration will not work.
	 *
	 * @param array $configuration
	 * @return void
	 */
	static public function verifyConfiguration(array $configuration) {
		// TODO: Implement verifyConfiguration() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * processes the configuration, should be overridden by subclasses
	 *
	 * @return void
	 */
	public function processConfiguration() {
		// TODO: Implement processConfiguration() method.
	}

	/**
	 * Returns the public URL to a file.
	 *
	 * @param \TYPO3\CMS\Core\Resource\ResourceInterface $resource
	 * @param bool  $relativeToCurrentScript    Determines whether the URL returned should be relative to the current script, in case it is relative at all (only for the LocalDriver)
	 * @return string
	 */
	public function getPublicUrl(\TYPO3\CMS\Core\Resource\ResourceInterface $resource, $relativeToCurrentScript = FALSE) {
		$item = $resource->getProperty('yagItem');
		if($item instanceof Tx_Yag_Domain_Model_Item) {
			return $item->getSourceuri();
		}
	}

	/**
	 * Creates a (cryptographic) hash for a file.
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @param string $hashAlgorithm The hash algorithm to use
	 * @return string
	 */
	public function hash(\TYPO3\CMS\Core\Resource\FileInterface $file, $hashAlgorithm) {
		return $file->getProperty('yagItem')->getFileHash();
	}

	/**
	 * Creates a new file and returns the matching file object for it.
	 *
	 * @param string $fileName
	 * @param \TYPO3\CMS\Core\Resource\Folder $parentFolder
	 * @return \TYPO3\CMS\Core\Resource\File
	 */
	public function createFile($fileName, \TYPO3\CMS\Core\Resource\Folder $parentFolder) {
		// TODO: Implement createFile() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Returns the contents of a file. Beware that this requires to load the
	 * complete file into memory and also may require fetching the file from an
	 * external location. So this might be an expensive operation (both in terms
	 * of processing resources and money) for large files.
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @return string The file contents
	 */
	public function getFileContents(\TYPO3\CMS\Core\Resource\FileInterface $file) {
		die('CALLED: ' . __FUNCTION__);
		// TODO: Implement getFileContents() method.
	}

	/**
	 * Sets the contents of a file to the specified value.
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @param string $contents
	 * @return integer The number of bytes written to the file
	 * @throws \RuntimeException if the operation failed
	 */
	public function setFileContents(\TYPO3\CMS\Core\Resource\FileInterface $file, $contents) {
		die('CALLED: ' . __FUNCTION__);
		// TODO: Implement setFileContents() method.
	}

	/**
	 * Adds a file from the local server hard disk to a given path in TYPO3s virtual file system.
	 *
	 * This assumes that the local file exists, so no further check is done here!
	 *
	 * @param string $localFilePath
	 * @param \TYPO3\CMS\Core\Resource\Folder $targetFolder
	 * @param string $fileName The name to add the file under
	 * @param \TYPO3\CMS\Core\Resource\AbstractFile $updateFileObject Optional file object to update (instead of creating a new object). With this parameter, this function can be used to "populate" a dummy file object with a real file underneath.
	 * @return \TYPO3\CMS\Core\Resource\FileInterface
	 */
	public function addFile($localFilePath, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $fileName, \TYPO3\CMS\Core\Resource\AbstractFile $updateFileObject = NULL) {
		// TODO: Implement addFile() method.
		//die('CALLED: ' . __FUNCTION__ . " with localFilePath : $localFilePath, targetFolder " . $targetFolder->getName() . ' FILENAME '. $fileName);
	}

	/**
	 * Checks if a resource exists - does not care for the type (file or folder).
	 *
	 * @param $identifier
	 * @return boolean
	 */
	public function resourceExists($identifier) {
		die('CALLED: ' . __FUNCTION__);
		// TODO: Implement resourceExists() method.
	}

	/**
	 * Checks if a file exists.
	 *
	 * @param string $identifier
	 * @return boolean
	 */
	public function fileExists($identifier) {
		return true;
		die('CALLED: ' . __FUNCTION__);
		// TODO: Implement fileExists() method.
	}

	/**
	 * Checks if a file inside a storage folder exists.
	 *
	 * @param string $fileName
	 * @param \TYPO3\CMS\Core\Resource\Folder $folder
	 * @return boolean
	 */
	public function fileExistsInFolder($fileName, \TYPO3\CMS\Core\Resource\Folder $folder) {
		die('CALLED: ' . __FUNCTION__);
		// TODO: Implement fileExistsInFolder() method.
	}

	/**
	 * Returns a (local copy of) a file for processing it. When changing the
	 * file, you have to take care of replacing the current version yourself!
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @param bool $writable Set this to FALSE if you only need the file for read operations. This might speed up things, e.g. by using a cached local version. Never modify the file if you have set this flag!
	 * @return string The path to the file on the local disk
	 */
	public function getFileForLocalProcessing(\TYPO3\CMS\Core\Resource\FileInterface $file, $writable = TRUE) {
		$this->yagFileSystemDiv = $this->objectManager->get('Tx_Yag_Domain_FileSystem_Div');

		$item = $file->getProperty('yagItem');
		if($item instanceof \Tx_Yag_Domain_Model_Item) {
			return $this->yagFileSystemDiv->makePathAbsolute($item->getSourceuri());
		}
	}

	/**
	 * Returns the permissions of a file as an array (keys r, w) of boolean flags
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @return array
	 */
	public function getFilePermissions(\TYPO3\CMS\Core\Resource\FileInterface $file) {
		return array(
			'r' => TRUE,
			'w' => FALSE,
		);
	}

	/**
	 * Returns the permissions of a folder as an array (keys r, w) of boolean flags
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $folder
	 * @return array
	 */
	public function getFolderPermissions(\TYPO3\CMS\Core\Resource\Folder $folder) {
		return array(
			'r' => TRUE,
			'w' => FALSE,
		);
	}

	/**
	 * Renames a file
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @param string $newName
	 * @return string The new identifier of the file if the operation succeeds
	 * @throws \RuntimeException if renaming the file failed
	 */
	public function renameFile(\TYPO3\CMS\Core\Resource\FileInterface $file, $newName) {
		// TODO: Implement renameFile() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Replaces the contents (and file-specific metadata) of a file object with a local file.
	 *
	 * @param \TYPO3\CMS\Core\Resource\AbstractFile $file
	 * @param string $localFilePath
	 * @return boolean
	 */
	public function replaceFile(\TYPO3\CMS\Core\Resource\AbstractFile $file, $localFilePath) {
		// TODO: Implement replaceFile() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Returns information about a file for a given file identifier.
	 *
	 * @param string $identifier The (relative) path to the file.
	 * @return array
	 */
	public function getFileInfoByIdentifier($identifier) {

		error_log('FAL DRIVER: ' . __FUNCTION__ . ' with Identifier '. $identifier);

		$chunks = explode('/', $identifier);
		$itemId = end($chunks);

		$itemRepository = $this->objectManager->get('\Tx_Yag_Domain_Repository_ItemRepository');
		$item = $itemRepository->findByUid($itemId); /** @var \Tx_Yag_Domain_Model_Item $item  */

		$fileInformation = array();


		if($item instanceof \Tx_Yag_Domain_Model_Item) {
			$fileInformation = array(
				'size' => $item->getFilesize(),
				'atime' => $item->getTstamp()->getTimestamp(),
				'mtime' => $item->getTstamp()->getTimestamp(),
				'ctime' => $item->getCrdate()->getTimestamp(),
				'mimetype' => 'JPG',
				'yagItem' => $item,
				'name' => $item->getOriginalFilename(),
				'identifier' => $identifier,
				'storage' => $this->storage->getUid()
			);
		}

		return $fileInformation;
	}

	/**
	 * Returns a folder within the given folder. Use this method instead of doing your own string manipulation magic
	 * on the identifiers because non-hierarchical storages might fail otherwise.
	 *
	 * @param $name
	 * @param \TYPO3\CMS\Core\Resource\Folder $parentFolder
	 * @return \TYPO3\CMS\Core\Resource\Folder
	 */
	public function getFolderInFolder($name, \TYPO3\CMS\Core\Resource\Folder $parentFolder) {
		die('CALLED: ' . __FUNCTION__);
		// TODO: Implement getFolderInFolder() method.
	}

	/**
	 * Copies a file to a temporary path and returns that path.
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @return string The temporary path
	 */
	public function copyFileToTemporaryPath(\TYPO3\CMS\Core\Resource\FileInterface $file) {
		die('CALLED: ' . __FUNCTION__);
		// TODO: Implement copyFileToTemporaryPath() method.
	}

	/**
	 * Moves a file *within* the current storage.
	 * Note that this is only about an intra-storage move action, where a file is just
	 * moved to another folder in the same storage.
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @param \TYPO3\CMS\Core\Resource\Folder $targetFolder
	 * @param string $fileName
	 * @return string The new identifier of the file
	 */
	public function moveFileWithinStorage(\TYPO3\CMS\Core\Resource\FileInterface $file, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $fileName) {
		die('CALLED: ' . __FUNCTION__);
		// TODO: Implement moveFileWithinStorage() method.
	}

	/**
	 * Copies a file *within* the current storage.
	 * Note that this is only about an intra-storage copy action, where a file is just
	 * copied to another folder in the same storage.
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @param \TYPO3\CMS\Core\Resource\Folder $targetFolder
	 * @param string $fileName
	 * @return \TYPO3\CMS\Core\Resource\FileInterface The new (copied) file object.
	 */
	public function copyFileWithinStorage(\TYPO3\CMS\Core\Resource\FileInterface $file, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $fileName) {
		die('CALLED: ' . __FUNCTION__);
		// TODO: Implement copyFileWithinStorage() method.
	}

	/**
	 * Folder equivalent to moveFileWithinStorage().
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $folderToMove
	 * @param \TYPO3\CMS\Core\Resource\Folder $targetFolder
	 * @param string $newFolderName
	 * @return array A map of old to new file identifiers
	 */
	public function moveFolderWithinStorage(\TYPO3\CMS\Core\Resource\Folder $folderToMove, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $newFolderName) {
		// TODO: Implement moveFolderWithinStorage() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Folder equivalent to copyFileWithinStorage().
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $folderToMove
	 * @param \TYPO3\CMS\Core\Resource\Folder $targetFolder
	 * @param string $newFileName
	 * @return boolean
	 */
	public function copyFolderWithinStorage(\TYPO3\CMS\Core\Resource\Folder $folderToMove, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $newFileName) {
		// TODO: Implement copyFolderWithinStorage() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Removes a file from this storage. This does not check if the file is
	 * still used or if it is a bad idea to delete it for some other reason
	 * this has to be taken care of in the upper layers (e.g. the Storage)!
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @return boolean TRUE if deleting the file succeeded
	 */
	public function deleteFile(\TYPO3\CMS\Core\Resource\FileInterface $file) {
		// TODO: Implement deleteFile() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Removes a folder from this storage.
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $folder
	 * @param boolean $deleteRecursively
	 * @return boolean
	 */
	public function deleteFolder(\TYPO3\CMS\Core\Resource\Folder $folder, $deleteRecursively = FALSE) {
		// TODO: Implement deleteFolder() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Adds a file at the specified location. This should only be used internally.
	 *
	 * @param string $localFilePath
	 * @param \TYPO3\CMS\Core\Resource\Folder $targetFolder
	 * @param string $targetFileName
	 * @return string The new identifier of the file
	 */
	public function addFileRaw($localFilePath, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $targetFileName) {
		// TODO: Implement addFileRaw() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Deletes a file without access and usage checks.
	 * This should only be used internally.
	 *
	 * This accepts an identifier instead of an object because we might want to
	 * delete files that have no object associated with (or we don't want to
	 * create an object for) them - e.g. when moving a file to another storage.
	 *
	 * @param string $identifier
	 * @return boolean TRUE if removing the file succeeded
	 */
	public function deleteFileRaw($identifier) {
		// TODO: Implement deleteFileRaw() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Returns the root level folder of the storage.
	 *
	 * @return \TYPO3\CMS\Core\Resource\Folder
	 */
	public function getRootLevelFolder() {
		if (!$this->rootLevelFolder) {
			$this->rootLevelFolder = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->createFolderObject($this->storage, '/', '');
		}
		return $this->rootLevelFolder;
	}


	protected function getDirectoryItemList($path, $start, $numberOfItems, array $filterMethods, $itemHandlerMethod, $itemRows = array(), $recursive = FALSE) {
		$yagPath = $this->checkAndConvertPath($path);

		if($itemHandlerMethod == $this->fileListCallbackMethod) {
			if($yagPath['album']) {
				$items = $this->getFileList_itemCallback($yagPath, $path);
			} else {
				$items = array();
			}
		}

		if($yagPath['album'] == 0 && $itemHandlerMethod == $this->folderListCallbackMethod) {
			$items =  $this->getFolderList_itemCallback($yagPath, $path);
		}

		return $items;
	}


	protected function getFileList_itemCallback($yagPath, $path, array $fileRow = array()) {
		$yagPath = $this->checkAndConvertPath($path);

		if($yagPath['album']) {
			$items =  $this->getItems($yagPath, $yagPath['album']);
			return $items;
		}
	}



	protected function getFolderList_itemCallback($yagPath, $path, array $folderRow = array()) {

		$page = $yagPath['page'];
		$gallery = $yagPath['gallery'];
		$album = $yagPath['album'];

		//echo print_r($yagPath,1) . "<br>--> PATH: $path PAGE: $page: GALLERY: $gallery : ALBUM: $album<br><br>";

		if($path === '/') {
			return $this->getPages($yagPath);
		}


		if($album) {
			return;
		}


		if($gallery) {
			return $this->getAlbums($yagPath, $gallery);
		}

		if($page) {
			$galleries = $this->getGalleries($yagPath, $page);
			return $galleries;
		}
	}


	protected function checkAndConvertPath($path) {

		$this->pidDetector = $this->objectManager->get('\\Tx_Yag_Utility_PidDetector');
		$this->pidDetector->setMode(\Tx_Yag_Utility_PidDetector::MANUAL_MODE);

		$path = substr($path,0,1) == '/' ? substr($path, 1) : $path;

		list($page, $gallery, $album, $item) = explode('/', $path);

		if($page) {
			list($name, $pageId) = explode('|', $page);
			$returnArray['page'] = (int) $pageId;

			$this->pidDetector->setPids(array($pageId));
		}

		if($gallery) {
			list($name, $id) = explode('|', $gallery);
			$returnArray['gallery'] = (int) $id;
		}


		if($album) {
			list($name, $id) = explode('|', $album);
			$returnArray['album'] = (int) $id;
		}


		if($item) {
			list($name, $id) = explode('|', $item);
			$returnArray['item'] = (int) $id;
		}


		$returnArray['idPath'] = '/' . implode('/', $returnArray) . '/';

		return $returnArray;
	}


	protected function getPages() {
		$filteredPageList = array();
		$pageRecordList = $this->pidDetector->getPageRecords();

		foreach($pageRecordList as $key => $pageRecord) {
			$filteredPageList[$pageRecord['title']] = array(
				'ctime' => $pageRecord['crdate'],
				'mtime' => $pageRecord['tstamp'],
				'name' =>  $pageRecord['title'] . ' |'.  $pageRecord['uid'],
				'identifier' => '/'. $pageRecord['uid'] .'/',
				'storage' => $this->storage->getUid(),
			);
		}

		return $filteredPageList;
	}



	protected function getGalleries($yagPath, $page) {

		$filteredGalleryList = array();

		$galleryRepository = $this->objectManager->get('\Tx_Yag_Domain_Repository_GalleryRepository');
		$galleryRepository->injectPidDetector($this->pidDetector);
		$galleryRepository->initializeObject();
		$galleries = $galleryRepository->findAll();

		foreach ($galleries as $gallery) { /** @var \Tx_Yag_Domain_Model_Gallery $gallery */
			$filteredGalleryList[$gallery->getName()] = array (
				'name' => $gallery->getName() . ' |' . $gallery->getUid(),
				'identifier' =>  $yagPath['idPath'] .  $gallery->getUid() . '/',
				'storage' => $this->storage->getUid(),
			);
		}

		return $filteredGalleryList;
	}



	protected function getAlbums($yagPath, $gallery) {
		$filteredAlbumList = array();

		$albumRepository = $this->objectManager->get('\Tx_Yag_Domain_Repository_AlbumRepository');
		$albumRepository->injectPidDetector($this->pidDetector);
		$albumRepository->initializeObject();
		$albums = $albumRepository->findByGallery($gallery);

		foreach($albums as $album) {
			$filteredAlbumList[$album->getName()] = array(
				'name' => $album->getName() . ' |' . $album->getUid(),
				'identifier' =>  $yagPath['idPath'] .  $album->getUid(),
				'storage' => $this->storage->getUid(),
			);
		}

		return $filteredAlbumList;
	}


	protected function getItems($yagPath, $album) {
		$filteredItemList = array();

		$itemRepository = $this->objectManager->get('\Tx_Yag_Domain_Repository_ItemRepository');
		$itemRepository->injectPidDetector($this->pidDetector);
		$itemRepository->initializeObject();
		$items = $itemRepository->findByAlbum($album);

		foreach($items as $item) {
			$filteredItemList[$item->getTitle()] = array(
				'name' => $item->getTitle() . ' |' . $item->getUid(),
				'identifier' =>  $yagPath['idPath'] . $item->getUid(),
				'storage' => $this->storage->getUid(),
			);
		}

		return $filteredItemList;
	}



	/**
	 * Returns the default folder new files should be put into.
	 *
	 * @return \TYPO3\CMS\Core\Resource\Folder
	 */
	public function getDefaultFolder() {
		// TODO: Implement getDefaultFolder() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Creates a folder.
	 *
	 * @param string $newFolderName
	 * @param \TYPO3\CMS\Core\Resource\Folder $parentFolder
	 * @return \TYPO3\CMS\Core\Resource\Folder The new (created) folder object
	 */
	public function createFolder($newFolderName, \TYPO3\CMS\Core\Resource\Folder $parentFolder) {
		// TODO: Implement createFolder() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Checks if a folder exists
	 *
	 * @param string $identifier
	 * @return boolean
	 */
	public function folderExists($identifier) {
		// TODO: Implement folderExists() method.
		return true;
	}

	/**
	 * Checks if a file inside a storage folder exists.
	 *
	 * @param string $folderName
	 * @param \TYPO3\CMS\Core\Resource\Folder $folder
	 * @return boolean
	 */
	public function folderExistsInFolder($folderName, \TYPO3\CMS\Core\Resource\Folder $folder) {
		// TODO: Implement folderExistsInFolder() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Renames a folder in this storage.
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $folder
	 * @param string $newName The target path (including the file name!)
	 * @return array A map of old to new file identifiers
	 * @throws \RuntimeException if renaming the folder failed
	 */
	public function renameFolder(\TYPO3\CMS\Core\Resource\Folder $folder, $newName) {
		// TODO: Implement renameFolder() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Checks if a given object or identifier is within a container, e.g. if
	 * a file or folder is within another folder.
	 * This can e.g. be used to check for webmounts.
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $container
	 * @param mixed $content An object or an identifier to check
	 * @return boolean TRUE if $content is within $container
	 */
	public function isWithin(\TYPO3\CMS\Core\Resource\Folder $container, $content) {
		// TODO: Implement isWithin() method.
		die('CALLED: ' . __FUNCTION__);
	}

	/**
	 * Checks if a folder contains files and (if supported) other folders.
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $folder
	 * @return boolean TRUE if there are no files and folders within $folder
	 */
	public function isFolderEmpty(\TYPO3\CMS\Core\Resource\Folder $folder) {
		// TODO: Implement isFolderEmpty() method.
		die('CALLED: ' . __FUNCTION__);
	}




}

?>
