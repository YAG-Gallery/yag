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

use TYPO3\CMS\Core\Utility\PathUtility;

class YagDriver extends \TYPO3\CMS\Core\Resource\Driver\AbstractDriver {

	/**
	 * @var \Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;

	/**
	 * @var \Tx_Yag_Domain_Repository_GalleryRepository
	 */
	protected $galleryRepository;

	/**
	 * @var \Tx_Yag_Domain_Repository_ItemRepository
	 */
	protected $itemRepository;

	/**
	 * Extbase Object Manager
	 *
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var \Tx_Yag_Utility_PidDetector
	 */
	protected $pidDetector;

	/**
	 * @var \TYPO3\CMS\Core\Registry
	 */
	protected $registry;

	/**
	 * @var \TYPO3\CMS\Core\Resource\Folder
	 */
	protected $rootLevelFolder;

	/**
	 * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
	 */
	protected $signalSlotDispatcher;

	/**
	 * @var \TYPO3\CMS\Core\Resource\ResourceStorage
	 */
	protected $storage;

	/**
	 * @var array
	 */
	protected $yagDirectoryCache = array();

	/**
	 * @var array
	 */
	protected $yagDirectoryPathCache = array();

	/**
	 * @var \Tx_Yag_Domain_FileSystem_Div
	 */
	protected $yagFileSystemDiv;

	/**
	 * @var array
	 */
	protected $yagIdentifierCache = array();

	/**
	 * Adds a file from the local server hard disk to a given path in TYPO3s
	 * virtual file system. This assumes that the local file exists, so no
	 * further check is done here! After a successful the original file must
	 * not exist anymore.
	 *
	 * @param string $localFilePath (within PATH_site)
	 * @param string $targetFolderIdentifier
	 * @param string $newFileName optional, if not given original name is used
	 * @param boolean $removeOriginal if set the original file will be removed
	 *                                after successful operation
	 * @return string the identifier of the new file
	 */
	public function addFile($localFilePath, $targetFolderIdentifier, $newFileName = '', $removeOriginal = TRUE) {
		if ($targetFolderIdentifier == $this->getStorage()->getProcessingFolder()->getIdentifier()) {
			$yagTempFolder = 'typo3temp/yag/'; // TODO: use configured value
			$falTempFolder = $this->yagFileSystemDiv->makePathAbsolute($yagTempFolder . $targetFolderIdentifier);
			$this->yagFileSystemDiv->checkDir($falTempFolder);
			$newFileName = ($newFileName) ? $newFileName : PathUtility::basename($localFilePath);
			$falTempFilePath = \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($falTempFolder, $newFileName));

			rename($localFilePath, $falTempFilePath);
		}

		return $targetFolderIdentifier . $newFileName;
	}

	/**
	 * Checks if a file exists.
	 *
	 * @param string $fileIdentifier
	 * @return boolean
	 */
	public function fileExists($fileIdentifier) {
		if (\t3lib_div::isFirstPartOfStr($fileIdentifier, $this->getStorage()->getProcessingFolder()->getIdentifier())) {
			$absolutePath = $this->yagFileSystemDiv->makePathAbsolute('fileadmin' . $fileIdentifier);

			return file_exists($absolutePath);
		} else {
			$pathInfo = new PathInfo();
			if ($pathInfo->setFromFalPath($fileIdentifier) && $pathInfo->getPathType() === PathInfo::INFO_ITEM) {
				return $this->traversePath($pathInfo);
			}
		}

		return FALSE;
	}

	/**
	 * @param PathInfo $pathInfo
	 * @return boolean
	 */
	protected function traversePath(PathInfo $pathInfo) {
		if (array_key_exists($pathInfo->getYagDirectoryPath(), $this->yagDirectoryPathCache)) {
			return TRUE;
		}

		if ($pathInfo->getPathType() === PathInfo::INFO_ROOT) {
			$this->getPages($pathInfo);
		}
		if ($pathInfo->getPathType() === PathInfo::INFO_PID) {
			$this->getPages();
			$this->getGalleries($pathInfo);
		}

		if ($pathInfo->getPathType() === PathInfo::INFO_GALLERY) {
			$this->getPages($pathInfo);
			$this->getGalleries($pathInfo);
			$this->getAlbums($pathInfo);
		}

		if ($pathInfo->getPathType() === PathInfo::INFO_ALBUM) {
			$this->getPages($pathInfo);
			$this->getGalleries($pathInfo);
			$this->getAlbums($pathInfo);
			$this->getItems($pathInfo);
		}

		return array_key_exists($pathInfo->getYagDirectoryPath(), $this->yagDirectoryPathCache);
	}

	/**
	 * @return array
	 */
	protected function getPages() {
		$pathInfo = new PathInfo();

		if (!array_key_exists('/', $this->yagDirectoryCache)) {
			$this->yagDirectoryCache['/'] = array();
			$pageRecordList = $this->pidDetector->getPageRecords();

			foreach ($pageRecordList as $pageRecord) {

				$pathInfo->setDisplayName($pageRecord['title'])
					->setPid($pageRecord['uid'])
					->setPathType(PathInfo::INFO_PID);

				$this->yagDirectoryCache['/'][$pageRecord['uid']] = $pageRecord['title'] . ' |' . $pageRecord['uid'];

				$this->yagDirectoryPathCache['/' . $pageRecord['uid']] = TRUE;
			}

		}

		return $this->yagDirectoryCache['/'];
	}

	/**
	 * @param PathInfo $pathInfo
	 * @return array
	 */
	protected function getGalleries(PathInfo $pathInfo) {
		$this->initializePidDetector($pathInfo);

		$pagePath = '/' . $pathInfo->getPid();

		if (!array_key_exists($pagePath, $this->yagDirectoryCache)) {
			$this->yagDirectoryCache[$pagePath] = array();
			$galleries = $this->galleryRepository->findAll();

			foreach ($galleries as $gallery) {
				/** @var \Tx_Yag_Domain_Model_Gallery $gallery */
				$this->yagDirectoryCache[$pagePath][$gallery->getUid()] = \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($pathInfo->getPagePath(), $gallery->getName() . ' |' . $gallery->getUid()));
				$this->yagDirectoryPathCache[$pagePath . '/' . $gallery->getUid()] = TRUE;
			}
		}

		return $this->yagDirectoryCache[$pagePath];
	}

	/**
	 * @param PathInfo $pathInfo
	 * @return void
	 */
	protected function initializePidDetector(PathInfo $pathInfo) {
		$this->pidDetector->setMode(\Tx_Yag_Utility_PidDetector::MANUAL_MODE);

		if ($pathInfo->getPid()) {
			$this->pidDetector->setPids(array($pathInfo->getPid()));
			$this->initializeRepositories();
		}
	}

	/**
	 * @return void
	 */
	protected function initializeRepositories() {
		$this->galleryRepository->injectPidDetector($this->pidDetector);
		$this->galleryRepository->initializeObject();

		$this->albumRepository->injectPidDetector($this->pidDetector);
		$this->albumRepository->initializeObject();

		$this->itemRepository->injectPidDetector($this->pidDetector);
		$this->itemRepository->initializeObject();
	}

	/**
	 * @param PathInfo $pathInfo
	 * @return array
	 */
	protected function getAlbums(PathInfo $pathInfo) {
		$galleryPath = '/' . implode('/', array($pathInfo->getPid(), $pathInfo->getGalleryUId()));

		if (!array_key_exists($galleryPath, $this->yagDirectoryCache)) {
			$this->yagDirectoryCache[$galleryPath] = array();

			$albums = $this->albumRepository->findByGallery($pathInfo->getGalleryUId());

			foreach ($albums as $album) {
				$this->yagDirectoryCache[$galleryPath][$album->getUid()] = \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($pathInfo->getGalleryPath(), $album->getName() . ' |' . $album->getUid())) . '/';
				$this->yagDirectoryPathCache[$galleryPath . '/' . $album->getUid()] = TRUE;
			}
		}

		return $this->yagDirectoryCache[$galleryPath];
	}

	/**
	 * @param PathInfo $pathInfo
	 * @return array
	 */
	protected function getItems(PathInfo $pathInfo) {
		$albumPath = '/' . implode('/', array($pathInfo->getPid(), $pathInfo->getGalleryUId(), $pathInfo->getAlbumUid()));

		if (!array_key_exists($albumPath, $this->yagDirectoryCache)) {
			$items = $this->itemRepository->findByAlbum($pathInfo->getAlbumUid());
			$this->yagDirectoryCache[$albumPath] = array();

			foreach ($items as $item) {
				$this->yagDirectoryCache[$albumPath][$item->getUid()] = \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($pathInfo->getAlbumPath(), $item->getTitle() . ' |' . $item->getUid()));
				$this->yagDirectoryPathCache[$albumPath . '/' . $item->getUid()] = TRUE;
			}
		}

		return $this->yagDirectoryCache[$albumPath];
	}

	/**
	 * Returns information about a file.
	 *
	 * @param string $fileIdentifier
	 * @param array $propertiesToExtract Array of properties which are be extracted
	 *                                   If empty all will be extracted
	 * @return array
	 */
	public function getFileInfoByIdentifier($fileIdentifier, array $propertiesToExtract = array()) {
		$pathInfo = $this->buildPathInfo($fileIdentifier);
		$fileInfo = $this->getProcessedFileByIdentifier($fileIdentifier);

		if (!empty($fileInfo)) {
			return $fileInfo;
		} else {
			$pathInfo->setFromFalPath($fileIdentifier);
		}

		$fileInfo = $this->getYAGObjectInfoByPathInfo($pathInfo);

		return $fileInfo;
	}

	/**
	 * @param string $path
	 * @return \TYPO3\CMS\Yag\Fal\Driver\PathInfo
	 */
	protected function buildPathInfo($path) {
		if ($path == './' || $path == '.') {
			$path = $this->retrieveLastAccessedFalPath();
		}

		$pathInfo = new PathInfo($path);

		$this->storeLastAccessedFalPath($path);

		return $pathInfo;
	}

	/**
	 * @return string
	 */
	protected function retrieveLastAccessedFalPath() {
		return $this->registry->get('tx_yag', 'lastAccessedFalPath');
	}

	/**
	 * @param string $falPath
	 * @return void
	 */
	protected function storeLastAccessedFalPath($falPath) {
		$this->registry->set('tx_yag', 'lastAccessedFalPath', $falPath);
	}

	/**
	 * @param string $identifier
	 * @return array
	 */
	protected function getProcessedFileByIdentifier($identifier) {
		$isTempFile = stristr($identifier, $this->getStorage()->getProcessingFolder()->getIdentifier());
		if ($isTempFile) {
			return array(
				'mimetype' => 'JPG',
				'name' => 'name',
				'identifier' => 'falTemp|' . $identifier,
				'storage' => $this->storageUid,
			);
		}

		return array();
	}

	/**
	 * @param PathInfo $pathInfo
	 * @return array
	 */
	protected function getYAGObjectInfoByPathInfo(PathInfo $pathInfo) {
		switch ($pathInfo->getPathType()) {
			case PathInfo::INFO_PID:
				return array(
					'name' => $pathInfo->getDisplayName() . '|' . $pathInfo->getPid(),
					'identifier' => $pathInfo->getIdentifier(),
					'storage' => $this->storageUid,
				);
				break;

			case PathInfo::INFO_GALLERY:
				$gallery = $this->galleryRepository->findByUid($pathInfo->getGalleryUId());
				if ($gallery instanceof \Tx_Yag_Domain_Model_Gallery) {
					return $this->buildGalleryObjectInfo($pathInfo, $gallery);
				}
				break;

			case PathInfo::INFO_ALBUM:
				$album = $this->albumRepository->findByUid($pathInfo->getAlbumUid());
				if ($album instanceof \Tx_Yag_Domain_Model_Album) {
					return $this->buildAlbumObjectInfo($pathInfo, $album);
				}
				break;

			case PathInfo::INFO_ITEM:
				$item = $this->itemRepository->findByUid($pathInfo->getItemUid());
				if ($item instanceof \Tx_Yag_Domain_Model_Item) {
					return $this->buildItemObjectInfo($pathInfo, $item);
				}
				break;
		}

		return array();
	}

	/**
	 * @param PathInfo $pathInfo
	 * @param \Tx_Yag_Domain_Model_Item $item
	 * @return array
	 */
	protected function buildItemObjectInfo(PathInfo $pathInfo, \Tx_Yag_Domain_Model_Item $item) {
		$folderIdentifier = \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($pathInfo->getAlbumPath())) . '/';
		$identifier = \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($folderIdentifier, $item->getTitle() . ' |' . $item->getUid()));
		return array(
			'size' => $item->getFilesize(),
			'atime' => $item->getTstamp()->getTimestamp(),
			'mtime' => $item->getTstamp()->getTimestamp(),
			'ctime' => $item->getCrdate()->getTimestamp(),
			'mimetype' => 'image/jpeg',
			'yagItem' => $item,
			'name' => $item->getOriginalFilename(),
			'identifier' => $identifier,
			'storage' => $this->storageUid,
			'description' => $item->getDescription(),
			'title' => $item->getTitle(),
			'height' => $item->getHeight(),
			'width' => $item->getWidth(),
			'sourceUri' => $item->getSourceuri(),
			'sha1' => $this->hashIdentifier($identifier),
			'identifier_hash' => $this->hashIdentifier($identifier),
			'folder_hash' => $this->hashIdentifier($folderIdentifier),
		);
	}

	/**
	 * Copies a file *within* the current storage.
	 * Note that this is only about an inner storage copy action,
	 * where a file is just copied to another folder in the same storage.
	 *
	 * @param string $fileIdentifier
	 * @param string $targetFolderIdentifier
	 * @param string $fileName
	 * @return string the Identifier of the new file
	 */
	public function copyFileWithinStorage($fileIdentifier, $targetFolderIdentifier, $fileName) {
		// TODO: Implement copyFileWithinStorage() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Folder equivalent to copyFileWithinStorage().
	 *
	 * @param string $sourceFolderIdentifier
	 * @param string $targetFolderIdentifier
	 * @param string $newFolderName
	 * @return boolean
	 */
	public function copyFolderWithinStorage($sourceFolderIdentifier, $targetFolderIdentifier, $newFolderName) {
		// TODO: Implement copyFolderWithinStorage() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Creates a new (empty) file and returns the identifier.
	 *
	 * @param string $fileName
	 * @param string $parentFolderIdentifier
	 * @return string
	 */
	public function createFile($fileName, $parentFolderIdentifier) {
		// TODO: Implement createFile() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Creates a folder, within a parent folder.
	 * If no parent folder is given, a root level folder will be created
	 *
	 * @param string $newFolderName
	 * @param string $parentFolderIdentifier
	 * @param boolean $recursive
	 * @return string the Identifier of the new folder
	 */
	public function createFolder($newFolderName, $parentFolderIdentifier = '', $recursive = FALSE) {
		// TODO: Implement createFolder() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Removes a file from the filesystem. This does not check if the file is
	 * still used or if it is a bad idea to delete it for some other reason
	 * this has to be taken care of in the upper layers (e.g. the Storage)!
	 *
	 * @param string $fileIdentifier
	 * @return boolean TRUE if deleting the file succeeded
	 */
	public function deleteFile($fileIdentifier) {
		// TODO: Implement deleteFile() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Removes a folder in filesystem.
	 *
	 * @param string $folderIdentifier
	 * @param boolean $deleteRecursively
	 * @return boolean
	 */
	public function deleteFolder($folderIdentifier, $deleteRecursively = FALSE) {
		// TODO: Implement deleteFolder() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Directly output the contents of the file to the output
	 * buffer. Should not take care of header files or flushing
	 * buffer before. Will be taken care of by the Storage.
	 *
	 * @param string $identifier
	 * @return void
	 */
	public function dumpFileContents($identifier) {
		// TODO: Implement dumpFileContents() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Checks if a file inside a folder exists
	 *
	 * @param string $fileName
	 * @param string $folderIdentifier
	 * @return boolean
	 */
	public function fileExistsInFolder($fileName, $folderIdentifier) {
		// TODO: Implement fileExistsInFolder() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Checks if a folder exists.
	 *
	 * @param string $folderIdentifier
	 * @return boolean
	 */
	public function folderExists($folderIdentifier) {
		if (!$folderIdentifier) {
			return TRUE;
		}

		if ($folderIdentifier === $this->getRootLevelFolder() || $folderIdentifier === '_processed_') {
			return TRUE;
		} else {
			$pathInfo = $this->buildPathInfo($folderIdentifier);
		}

		if ($pathInfo->getPathType() === PathInfo::INFO_ITEM) {
			return FALSE;
		}

		return $this->traversePath($pathInfo);
	}

	/**
	 * Checks if a folder inside a folder exists.
	 *
	 * @param string $folderName
	 * @param string $folderIdentifier
	 * @return boolean
	 */
	public function folderExistsInFolder($folderName, $folderIdentifier) {
		// TODO: Implement folderExistsInFolder() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Returns the identifier of the default folder new files should be put into.
	 *
	 * @return string
	 */
	public function getDefaultFolder() {
		// TODO: Implement getDefaultFolder() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Returns the contents of a file. Beware that this requires to load the
	 * complete file into memory and also may require fetching the file from an
	 * external location. So this might be an expensive operation (both in terms
	 * of processing resources and money) for large files.
	 *
	 * @param string $fileIdentifier
	 * @return string The file contents
	 */
	public function getFileContents($fileIdentifier) {
		// TODO: Implement getFileContents() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Returns a path to a local copy of a file for processing it. When changing the
	 * file, you have to take care of replacing the current version yourself!
	 *
	 * @param string $fileIdentifier
	 * @param bool $writable Set this to FALSE if you only need the file for read
	 *                       operations. This might speed up things, e.g. by using
	 *                       a cached local version. Never modify the file if you
	 *                       have set this flag!
	 * @return string The path to the file on the local disk
	 */
	public function getFileForLocalProcessing($fileIdentifier, $writable = TRUE) {
		$fileInfo = $this->getFileInfoByIdentifier($fileIdentifier);
		$sourceUri =  $this->yagFileSystemDiv->makePathAbsolute($fileInfo['sourceUri']);

		return $sourceUri;
	}

	/**
	 * Returns a list of files inside the specified path
	 *
	 * @param string $folderIdentifier
	 * @param integer $start
	 * @param integer $numberOfItems
	 * @param boolean $recursive
	 * @param array $filenameFilterCallbacks callbacks for filtering the items
	 * @return array of FileIdentifiers
	 */
	public function getFilesInFolder($folderIdentifier, $start = 0, $numberOfItems = 0, $recursive = FALSE, array $filenameFilterCallbacks = array()) {
		$items = array();
		$pathInfo = $this->buildPathInfo($folderIdentifier);
		$this->initDriver($pathInfo);

		if ($pathInfo->getPathType() === PathInfo::INFO_ALBUM) {
			$items = $this->getItems($pathInfo);
		}

		return $items;
	}

	/**
	 * @param PathInfo $pathInfo
	 * @return void
	 */
	protected function initDriver(PathInfo $pathInfo) {
		$this->determinePidFromPathInfo($pathInfo);
		$this->initializePidDetector($pathInfo);
	}

	/**
	 * @param PathInfo $pathInfo
	 * @return integer
	 */
	public function determinePidFromPathInfo(PathInfo $pathInfo) {
		$connection = $GLOBALS['TYPO3_DB'];
		/** @var \t3lib_DB $connection */

		if ($pathInfo->getPid()) {
			return $pathInfo->getPid();
		}

		if ($pathInfo->getGalleryUId()) {
			$result = $connection->exec_SELECTgetSingleRow('pid', 'tx_yag_domain_model_gallery', 'uid = ' . $pathInfo->getGalleryUId());
			$pathInfo->setPid($result['pid']);
		}

		if ($pathInfo->getAlbumUid()) {
			$result = $connection->exec_SELECTgetSingleRow('pid', 'tx_yag_domain_model_album', 'uid = ' . $pathInfo->getAlbumUid());
			$pathInfo->setPid($result['pid']);
		}

		return $pathInfo->getPid();
	}

	/**
	 * Returns information about a file.
	 *
	 * @param string $folderIdentifier
	 * @return array
	 */
	public function getFolderInfoByIdentifier($folderIdentifier) {
		return array(
			'identifier' => $folderIdentifier,
			'name' => PathUtility::basename($folderIdentifier),
			'storage' => $this->storageUid
		);
	}

	/**
	 * Returns a list of folders inside the specified path
	 *
	 * @param string $folderIdentifier
	 * @param integer $start
	 * @param integer $numberOfItems
	 * @param boolean $recursive
	 * @param array $folderNameFilterCallbacks callbacks for filtering the items
	 * @return array of Folder Identifier
	 */
	public function getFoldersInFolder($folderIdentifier, $start = 0, $numberOfItems = 0, $recursive = FALSE, array $folderNameFilterCallbacks = array()) {
		$items = array();
		$pathInfo = $this->buildPathInfo($folderIdentifier);
		$this->initDriver($pathInfo);

		if ($pathInfo->getPathType() !== PathInfo::INFO_ALBUM) {
			switch ($pathInfo->getPathType()) {
				case PathInfo::INFO_ROOT:
					$items = $this->getPages($pathInfo);
					break;

				case PathInfo::INFO_PID:
					$items = $this->getGalleries($pathInfo);
					break;

				case PathInfo::INFO_GALLERY:
					$items = $this->getAlbums($pathInfo);
					break;
			}
		}

		return $items;
	}

	/**
	 * Returns the identifier of the folder the file resides in
	 *
	 * @param string $fileIdentifier
	 * @return string
	 */
	public function getParentFolderIdentifierOfIdentifier($fileIdentifier) {
		// TODO: Implement getParentFolderIdentifierOfIdentifier() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Returns the permissions of a file/folder as an array
	 * (keys r, w) of boolean flags
	 *
	 * @param string $identifier
	 * @return array
	 */
	public function getPermissions($identifier) {
		return array(
			'r' => TRUE,
			'w' => FALSE,
		);
	}

	/**
	 * Returns the public URL to a file.
	 *
	 * @param string $identifier
	 * @param boolean $relativeToCurrentScript Determines whether the URL
	 *                                         returned should be relative
	 *                                         to the current script, in case
	 *                                         it is relative at all (only
	 *                                         for the LocalDriver)
	 * @return string
	 */
	public function getPublicUrl($identifier, $relativeToCurrentScript = FALSE) {
		if (\TYPO3\CMS\Core\Utility\GeneralUtility::isFirstPartOfStr($identifier, $this->getStorage()->getProcessingFolder()->getIdentifier())) {
			$publicUrl = 'typo3temp/yag/' . $identifier; // TODO: ....!!!!
		} else {
			$pathInfo = new PathInfo($identifier);
			$item = $this->getItem($pathInfo);
			$publicUrl = $item->getSourceuri();
		}

		if ($relativeToCurrentScript) {
			$publicUrl = PathUtility::getRelativePathTo(PathUtility::dirname((PATH_site . $publicUrl))) . PathUtility::basename($publicUrl);
		}

		return $publicUrl;
	}

	/**
	 * @param PathInfo $pathInfo
	 * @return object
	 */
	protected function getItem(PathInfo $pathInfo) {
		$this->initializePidDetector($pathInfo);

		return $this->itemRepository->findByUid($pathInfo->getItemUid());
	}

	/**
	 * Returns the identifier of the root level folder of the storage.
	 *
	 * @return string
	 */
	public function getRootLevelFolder() {
		return '/';
	}

	/**
	 * Creates a hash for a file.
	 *
	 * @param string $fileIdentifier
	 * @param string $hashAlgorithm The hash algorithm to use
	 * @return string
	 */
	public function hash($fileIdentifier, $hashAlgorithm) {
		return $this->hashIdentifier($fileIdentifier);
	}

	/**
	 * Initializes this object. This is called by the storage after the driver
	 * has been attached.
	 *
	 * @return void
	 */
	public function initialize() {
		$this->capabilities = \TYPO3\CMS\Core\Resource\ResourceStorage::CAPABILITY_BROWSABLE | \TYPO3\CMS\Core\Resource\ResourceStorage::CAPABILITY_PUBLIC; // | \TYPO3\CMS\Core\Resource\ResourceStorage::CAPABILITY_WRITABLE;

		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Extbase_Object_ObjectManager');
		$this->galleryRepository = $this->objectManager->get('\Tx_Yag_Domain_Repository_GalleryRepository');
		$this->albumRepository = $this->objectManager->get('\Tx_Yag_Domain_Repository_AlbumRepository');
		$this->itemRepository = $this->objectManager->get('\Tx_Yag_Domain_Repository_ItemRepository');
		$this->signalSlotDispatcher = $this->objectManager->get('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');

		$this->yagFileSystemDiv = $this->objectManager->get('Tx_Yag_Domain_FileSystem_Div');
		$this->pidDetector = $this->objectManager->get('Tx_Yag_Utility_PidDetector');
		$this->registry = $this->objectManager->get('TYPO3\\CMS\\Core\\Registry');
	}

	/**
	 * Checks if a folder contains files and (if supported) other folders.
	 *
	 * @param string $folderIdentifier
	 * @return boolean TRUE if there are no files and folders within $folder
	 */
	public function isFolderEmpty($folderIdentifier) {
		// TODO: Implement isFolderEmpty() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Checks if a given identifier is within a container, e.g. if
	 * a file or folder is within another folder.
	 * This can e.g. be used to check for web-mounts.
	 * Hint: this also needs to return TRUE if the given identifier
	 * matches the container identifier to allow access to the root
	 * folder of a filemount.
	 *
	 * @param string $folderIdentifier
	 * @param string $identifier identifier to be checked against $folderIdentifier
	 * @return boolean TRUE if $content is within or matches $folderIdentifier
	 */
	public function isWithin($folderIdentifier, $identifier) {
		// TODO: Implement isWithin() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Moves a file *within* the current storage.
	 * Note that this is only about an inner-storage move action,
	 * where a file is just moved to another folder in the same storage.
	 *
	 * @param string $fileIdentifier
	 * @param string $targetFolderIdentifier
	 * @param string $newFileName
	 * @return string
	 */
	public function moveFileWithinStorage($fileIdentifier, $targetFolderIdentifier, $newFileName) {
		// TODO: Implement moveFileWithinStorage() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Folder equivalent to moveFileWithinStorage().
	 *
	 * @param string $sourceFolderIdentifier
	 * @param string $targetFolderIdentifier
	 * @param string $newFolderName
	 * @return array All files which are affected, map of old => new file identifiers
	 */
	public function moveFolderWithinStorage($sourceFolderIdentifier, $targetFolderIdentifier, $newFolderName) {
		// TODO: Implement moveFolderWithinStorage() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Processes the configuration for this driver.
	 *
	 * @return void
	 */
	public function processConfiguration() {
	}

	/**
	 * Renames a file in this storage.
	 *
	 * @param string $fileIdentifier
	 * @param string $newName The target path (including the file name!)
	 * @return string The identifier of the file after renaming
	 */
	public function renameFile($fileIdentifier, $newName) {
		// TODO: Implement renameFile() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Renames a folder in this storage.
	 *
	 * @param string $folderIdentifier
	 * @param string $newName
	 * @return array A map of old to new file identifiers of all affected resources
	 */
	public function renameFolder($folderIdentifier, $newName) {
		// TODO: Implement renameFolder() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Replaces a file with file in local file system.
	 *
	 * @param string $fileIdentifier
	 * @param string $localFilePath
	 * @return boolean TRUE if the operation succeeded
	 */
	public function replaceFile($fileIdentifier, $localFilePath) {
		// TODO: Implement replaceFile() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Sets the contents of a file to the specified value.
	 *
	 * @param string $fileIdentifier
	 * @param string $contents
	 * @return integer The number of bytes written to the file
	 */
	public function setFileContents($fileIdentifier, $contents) {
		// TODO: Implement setFileContents() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * Makes sure the identifier given as parameter is valid
	 *
	 * @param string $fileIdentifier The file Identifier
	 * @return string
	 * @throws \TYPO3\CMS\Core\Resource\Exception\InvalidPathException
	 */
	protected function canonicalizeAndCheckFileIdentifier($fileIdentifier) {
		return $fileIdentifier;
	}

	/**
	 * Makes sure the path given as parameter is valid
	 *
	 * @param string $filePath The file path (most times filePath)
	 * @return string
	 */
	protected function canonicalizeAndCheckFilePath($filePath) {
		return $filePath;
	}

	/**
	 * Makes sure the identifier given as parameter is valid
	 *
	 * @param string $folderIdentifier The folder identifier
	 * @return string
	 */
	protected function canonicalizeAndCheckFolderIdentifier($folderIdentifier) {
		// TODO: Implement canonicalizeAndCheckFolderIdentifier() method.
		error_log('FAL DRIVER: ' . __FUNCTION__);
	}

	/**
	 * @param string $identifier
	 * @return string
	 */
	protected function getNameFromIdentifier($identifier) {
		$pathInfo = new PathInfo();

		if ($identifier === '_processed_') {
			return 'Processed';
		}

		if ($pathInfo->setFromFalPath($identifier) !== FALSE) {
			return $pathInfo->getDisplayName();
		}

		return '';
	}

	/**
	 * Returns the storage object
	 *
	 * @return \TYPO3\CMS\Core\Resource\ResourceStorage
	 */
	protected function getStorage() {
		if (!$this->storage instanceof \TYPO3\CMS\Core\Resource\ResourceStorage) {
			$storageRepository = $this->objectManager->get('TYPO3\\CMS\\Core\\Resource\\StorageRepository');
			$this->storage = $storageRepository->findByUid($this->storageUid);
		}

		return $this->storage;
	}
}

?>
