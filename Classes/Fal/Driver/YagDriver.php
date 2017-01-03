<?php

namespace TYPO3\CMS\Yag\Fal\Driver;

/***************************************************************
*  Copyright notice
*
*  (c) 2010-2012 Daniel Lienert <typo3@lienert.cc>
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

class YagDriver extends \TYPO3\CMS\Core\Resource\Driver\AbstractDriver
{
    /**
     * @var array
     */
    protected $yagDirectoryCache = false;

    /**
     * @var array
     */
    protected $yagDirectoryPathCache = false;

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
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     */
    protected $signalSlotDispatcher;


    /**
     * @var \TYPO3\CMS\Core\Registry
     */
    protected $registry;


    /**
     * Initializes this object. This is called by the storage after the driver
     * has been attached.
     *
     * @return void
     */
    public function initialize()
    {
        $this->capabilities = \TYPO3\CMS\Core\Resource\ResourceStorage::CAPABILITY_BROWSABLE | \TYPO3\CMS\Core\Resource\ResourceStorage::CAPABILITY_PUBLIC; // | \TYPO3\CMS\Core\Resource\ResourceStorage::CAPABILITY_WRITABLE;

        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        $this->galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
        $this->albumRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_AlbumRepository');
        $this->itemRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository');
        $this->signalSlotDispatcher = $this->objectManager->get('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');

        $this->yagFileSystemDiv = $this->objectManager->get('Tx_Yag_Domain_FileSystem_Div');
        $this->pidDetector = $this->objectManager->get('Tx_Yag_Utility_PidDetector');
        $this->registry = $this->objectManager->get('TYPO3\\CMS\\Core\\Registry');
    }



    /**
     * Checks if a configuration is valid for this driver.
     * Throws an exception if a configuration will not work.
     *
     * @param array $configuration
     * @return void
     */
    public static function verifyConfiguration(array $configuration)
    {
        // TODO: Implement verifyConfiguration() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }



    /**
     * processes the configuration, should be overridden by subclasses
     *
     * @return void
     */
    public function processConfiguration()
    {
    }


    public function processImage($fileProcessingService, $driver, \TYPO3\CMS\Core\Resource\ProcessedFile $processedFile, $file, $context, $configuration)
    {
        error_log('FAL DRIVER ' . __FUNCTION__);
    }



    /**
     * Returns the public URL to a file.
     *
     * @param \TYPO3\CMS\Core\Resource\ResourceInterface $resource
     * @param bool  $relativeToCurrentScript    Determines whether the URL returned should be relative to the current script, in case it is relative at all (only for the LocalDriver)
     * @return string
     */
    public function getPublicUrl(\TYPO3\CMS\Core\Resource\ResourceInterface $resource, $relativeToCurrentScript = false)
    {
        if (\TYPO3\CMS\Core\Utility\GeneralUtility::isFirstPartOfStr($resource->getIdentifier(), '/_processed_/')) {
            $publicUrl =  '../typo3temp/yag' . $resource->getIdentifier(); // TODO: ....!!!!
        } else {
            $item = $resource->getProperty('yagItem');

            if (!$item instanceof \Tx_Yag_Domain_Model_Item) {
                $pathInfo = new PathInfo($resource->getIdentifier());
                $item = $this->getItem($pathInfo);
            }

            $publicUrl =  $this->yagFileSystemDiv->getFileRelFileName($item->getSourceuri());
        }


        if ($relativeToCurrentScript) {
            $publicUrl = PathUtility::getRelativePathTo(PathUtility::dirname((PATH_site . $publicUrl))) . PathUtility::basename($publicUrl);
        }
        return $publicUrl;
    }



    /**
     * Creates a (cryptographic) hash for a file.
     *
     * @param \TYPO3\CMS\Core\Resource\FileInterface $file
     * @param string $hashAlgorithm The hash algorithm to use
     * @return string
     */
    public function hash(\TYPO3\CMS\Core\Resource\FileInterface $file, $hashAlgorithm)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);

        $pathInfo = new PathInfo();
        $pathInfo->setFromFalPath($file->getIdentifier());

        switch ($hashAlgorithm) {
            case 'sha1':
                return sha1($file->getIdentifier());
                break;
        }
    }



    /**
     * Creates a new file and returns the matching file object for it.
     *
     * @param string $fileName
     * @param \TYPO3\CMS\Core\Resource\Folder $parentFolder
     * @return \TYPO3\CMS\Core\Resource\File
     */
    public function createFile($fileName, \TYPO3\CMS\Core\Resource\Folder $parentFolder)
    {
        // TODO: Implement createFile() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
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
    public function getFileContents(\TYPO3\CMS\Core\Resource\FileInterface $file)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);
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
    public function setFileContents(\TYPO3\CMS\Core\Resource\FileInterface $file, $contents)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);
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
    public function addFile($localFilePath, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $fileName, \TYPO3\CMS\Core\Resource\AbstractFile $updateFileObject = null)
    {
        // TODO: Implement addFile() method.

        error_log('FAL DRIVER: ' . __FUNCTION__ . ' Folder: ' . $targetFolder->getCombinedIdentifier() . ' FileName ' . $fileName) . 'FileObject ';



        if ($targetFolder == $this->storage->getProcessingFolder()) {
            $yagTempFolder = 'typo3temp/yag'; // TODO: use configured value

            $falTempFolder = $this->yagFileSystemDiv->makePathAbsolute($yagTempFolder . $targetFolder->getIdentifier());
            $this->yagFileSystemDiv->checkDirAndCreateIfMissing($falTempFolder);
            $falTempFilePath = \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($falTempFolder, $fileName));

            rename($localFilePath, $falTempFilePath);
        }

        return $this->getFile($falTempFilePath);
    }



    /**
     * Checks if a resource exists - does not care for the type (file or folder).
     *
     * @param $identifier
     * @return boolean
     */
    public function resourceExists($identifier)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);
        // TODO: Implement resourceExists() method.
    }



    /**
     * Checks if a file exists.
     *
     * @param string $identifier
     * @return boolean
     */
    public function fileExists($identifier)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__ . ' Identifier: ' . $identifier);

        if (\TYPO3\CMS\Core\Utility\GeneralUtility::isFirstPartOfStr($identifier, '/_processed_/')) {
            $absolutePath = $this->yagFileSystemDiv->makePathAbsolute('fileadmin' . $identifier);
            $fileExists = file_exists($absolutePath);
            return $fileExists;
        } else {
            $pathInfo = new PathInfo();
            if ($pathInfo->setFromFalPath($identifier) && $pathInfo->getPathType() === PathInfo::INFO_ITEM) {
                return $this->traversePath($pathInfo);
            }
        }

        return false;
    }



    /**
     * Checks if a folder exists
     *
     * @param string $identifier
     * @return boolean
     */
    public function folderExists($identifier)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);

        if (!$identifier) {
            return true;
        }

        if ($identifier === '/' || $identifier === '/_processed_/') {
            return true;
        } else {
            $pathInfo = $this->buildPathInfo($identifier);
        }
        if ($pathInfo->getPathType() === PathInfo::INFO_ITEM) {
            return false;
        }

        return $this->traversePath($pathInfo);
    }



    /**
     * Checks if a file inside a storage folder exists.
     *
     * @param string $fileName
     * @param \TYPO3\CMS\Core\Resource\Folder $folder
     * @return boolean
     */
    public function fileExistsInFolder($fileName, \TYPO3\CMS\Core\Resource\Folder $folder)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);
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
    public function getFileForLocalProcessing(\TYPO3\CMS\Core\Resource\FileInterface $file, $writable = true)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);

        if (!$file->isIndexed() || !($file->getProperty('yagItem') instanceof \Tx_Yag_Domain_Model_Item)) {
            $identifier = $file->getIdentifier();
            $fileInfo = $this->getFileInfoByIdentifier($identifier);

            $sourceUri =  $this->yagFileSystemDiv->makePathAbsolute($fileInfo['sourceUri']);
        } else {
            $item = $file->getProperty('yagItem');
            $sourceUri =  $this->yagFileSystemDiv->makePathAbsolute($item->getSourceuri());
        }

        return $sourceUri;
    }



    /**
     * Returns the permissions of a file as an array (keys r, w) of boolean flags
     *
     * @param \TYPO3\CMS\Core\Resource\FileInterface $file
     * @return array
     */
    public function getFilePermissions(\TYPO3\CMS\Core\Resource\FileInterface $file)
    {
        return array(
            'r' => true,
            'w' => false,
        );
    }

    /**
     * Returns the permissions of a folder as an array (keys r, w) of boolean flags
     *
     * @param \TYPO3\CMS\Core\Resource\Folder $folder
     * @return array
     */
    public function getFolderPermissions(\TYPO3\CMS\Core\Resource\Folder $folder)
    {
        return array(
            'r' => true,
            'w' => false,
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
    public function renameFile(\TYPO3\CMS\Core\Resource\FileInterface $file, $newName)
    {
        // TODO: Implement renameFile() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }

    /**
     * Replaces the contents (and file-specific metadata) of a file object with a local file.
     *
     * @param \TYPO3\CMS\Core\Resource\AbstractFile $file
     * @param string $localFilePath
     * @return boolean
     */
    public function replaceFile(\TYPO3\CMS\Core\Resource\AbstractFile $file, $localFilePath)
    {
        // TODO: Implement replaceFile() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }





    protected function getProcessedFileByIdentifier($identifier)
    {
        $isTempFile = stristr($identifier, $this->storage->getProcessingFolder()->getIdentifier());

        if ($isTempFile) {
            return array(
                'mimetype' => 'JPG',
                'name' => 'name',
                'identifier' => 'falTemp|' . $identifier,
                'storage' => $this->storage->getUid(),
            );
        }

        return false;
    }


    /**
     * Returns a folder within the given folder. Use this method instead of doing your own string manipulation magic
     * on the identifiers because non-hierarchical storages might fail otherwise.
     *
     * @param $name
     * @param \TYPO3\CMS\Core\Resource\Folder $parentFolder
     * @return \TYPO3\CMS\Core\Resource\Folder
     */
    public function getFolderInFolder($name, \TYPO3\CMS\Core\Resource\Folder $parentFolder)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);
        die('FIF');
        // TODO: Implement getFolderInFolder() method.
    }

    /**
     * Copies a file to a temporary path and returns that path.
     *
     * @param \TYPO3\CMS\Core\Resource\FileInterface $file
     * @return string The temporary path
     */
    public function copyFileToTemporaryPath(\TYPO3\CMS\Core\Resource\FileInterface $file)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);
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
    public function moveFileWithinStorage(\TYPO3\CMS\Core\Resource\FileInterface $file, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $fileName)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);
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
    public function copyFileWithinStorage(\TYPO3\CMS\Core\Resource\FileInterface $file, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $fileName)
    {
        error_log('FAL DRIVER: ' . __FUNCTION__);
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
    public function moveFolderWithinStorage(\TYPO3\CMS\Core\Resource\Folder $folderToMove, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $newFolderName)
    {
        // TODO: Implement moveFolderWithinStorage() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }

    /**
     * Folder equivalent to copyFileWithinStorage().
     *
     * @param \TYPO3\CMS\Core\Resource\Folder $folderToMove
     * @param \TYPO3\CMS\Core\Resource\Folder $targetFolder
     * @param string $newFileName
     * @return boolean
     */
    public function copyFolderWithinStorage(\TYPO3\CMS\Core\Resource\Folder $folderToMove, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $newFileName)
    {
        // TODO: Implement copyFolderWithinStorage() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }

    /**
     * Removes a file from this storage. This does not check if the file is
     * still used or if it is a bad idea to delete it for some other reason
     * this has to be taken care of in the upper layers (e.g. the Storage)!
     *
     * @param \TYPO3\CMS\Core\Resource\FileInterface $file
     * @return boolean TRUE if deleting the file succeeded
     */
    public function deleteFile(\TYPO3\CMS\Core\Resource\FileInterface $file)
    {
        // TODO: Implement deleteFile() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }

    /**
     * Removes a folder from this storage.
     *
     * @param \TYPO3\CMS\Core\Resource\Folder $folder
     * @param boolean $deleteRecursively
     * @return boolean
     */
    public function deleteFolder(\TYPO3\CMS\Core\Resource\Folder $folder, $deleteRecursively = false)
    {
        // TODO: Implement deleteFolder() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }

    /**
     * Adds a file at the specified location. This should only be used internally.
     *
     * @param string $localFilePath
     * @param \TYPO3\CMS\Core\Resource\Folder $targetFolder
     * @param string $targetFileName
     * @return string The new identifier of the file
     */
    public function addFileRaw($localFilePath, \TYPO3\CMS\Core\Resource\Folder $targetFolder, $targetFileName)
    {
        // TODO: Implement addFileRaw() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
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
    public function deleteFileRaw($identifier)
    {
        // TODO: Implement deleteFileRaw() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }

    /**
     * Returns the root level folder of the storage.
     *
     * @return \TYPO3\CMS\Core\Resource\Folder
     */
    public function getRootLevelFolder()
    {
        if (!$this->rootLevelFolder) {
            $this->rootLevelFolder = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->createFolderObject($this->storage, '/', '');
        }
        return $this->rootLevelFolder;
    }



    /**
     * Returns a folder by its identifier.
     *
     * @param string $identifier
     * @return \TYPO3\CMS\Core\Resource\Folder
     */
    public function getFolder($identifier)
    {
        if ($identifier === '/' || $identifier === '/_processed_/') {
            return parent::getFOlder($identifier);
        }

        $pathInfo = $this->buildPathInfo($identifier);
        $identifier = $pathInfo->getFalPath();

        $name = $this->getNameFromIdentifier($identifier);
        return \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->createFolderObject($this->storage, $identifier, $name);
    }



    protected function getDirectoryItemList($path, $start, $numberOfItems, array $filterMethods, $itemHandlerMethod, $itemRows = array(), $recursive = false)
    {
        error_log('------------> FAL DRIVER: ' . __FUNCTION__ . ' with Mode ' . $itemHandlerMethod . ' with Identifier '. $path);

        $items = array();

        $pathInfo = $this->buildPathInfo($path);
        $this->initDriver($pathInfo);

        if ($itemHandlerMethod == $this->folderListCallbackMethod && $pathInfo->getPathType() !== PathInfo::INFO_ALBUM) {
            $items = $this->getFolderList_itemCallback($pathInfo);
        }

        if ($itemHandlerMethod == $this->fileListCallbackMethod && $pathInfo->getPathType() === PathInfo::INFO_ALBUM) {
            $items = $this->getFileList_itemCallback($pathInfo);
        }

        return $items;
    }



    /**
     * @param $path
     * @return \TYPO3\CMS\Yag\Fal\Driver\PathInfo
     */
    protected function buildPathInfo($path)
    {
        if ($path == './' || $path == '.') {
            $path = $this->retrieveLastAccessedFalPath();
        }

        $pathInfo = new PathInfo($path);

        $this->storeLastAccessedFalPath($path);

        return $pathInfo;
    }



    /**
     * Returns information about a file for a given file identifier.
     *
     * @param string $identifier The (relative) path to the file.
     * @param array $propertiesToExtract Array of properties which should be extracted, if empty all will be extracted
     * @return array
     */
    public function getFileInfoByIdentifier($identifier, array $propertiesToExtract = array())
    {
        error_log('------------> FAL DRIVER: ' . __FUNCTION__ . ' with Identifier '. $identifier);

        $pathInfo = $this->buildPathInfo($identifier);

        $fileInfo = $this->getProcessedFileByIdentifier($identifier);

        if ($fileInfo !== false) {
            return $fileInfo;
        } else {
            $pathInfo->setFromFalPath($identifier);
        }

        $fileInfo = $this->getYAGObjectInfoByPathInfo($pathInfo);

        return $fileInfo;
    }


    /**
     * @param string $identifier
     * @return string|void
     */
    protected function getNameFromIdentifier($identifier)
    {
        $pathInfo = new PathInfo();

        error_log('------------> FAL DRIVER: ' . __FUNCTION__ . ' with Identifier '. $identifier);

        if ($identifier === '/_processed_/') {
            return 'Processed';
        }

        if ($pathInfo->setFromFalPath($identifier) !== false) {
            return $pathInfo->getDisplayName();
        }
    }



    protected function getFileList_itemCallback(PathInfo $pathInfo)
    {
        error_log('-> ' . __FUNCTION__ . ' PathType: ' . $pathInfo->getPathType());

        if ($pathInfo->getPathType() === PathInfo::INFO_ALBUM) {
            $items = $this->getItems($pathInfo);
            return $items;
        }
    }



    protected function traversePath(PathInfo $pathInfo)
    {
        $pathInfo = $pathInfo;
        if (array_key_exists($pathInfo->getYagDirectoryPath(), $this->yagDirectoryPathCache)) {
            return true;
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
     * @param PathInfo $pathInfo
     * @return array
     */
    protected function getFolderList_itemCallback(PathInfo $pathInfo)
    {
        switch ($pathInfo->getPathType()) {
            case PathInfo::INFO_ROOT:
                $items =  $this->getPages($pathInfo);
                break;

            case PathInfo::INFO_PID:
                $items = $this->getGalleries($pathInfo);
                break;

            case PathInfo::INFO_GALLERY:
                $items = $this->getAlbums($pathInfo);
                break;
        }

        return $items;
    }


    /**
     * @param PathInfo $pathInfo
     */
    protected function initDriver(PathInfo $pathInfo)
    {
        error_log('-> ' . __FUNCTION__);

        $this->determinePidFromPathInfo($pathInfo);
        $this->initializePidDetector($pathInfo);
    }


    protected function initializePidDetector(PathInfo $pathInfo)
    {
        $this->pidDetector->setMode(\Tx_Yag_Utility_PidDetector::MANUAL_MODE);

        if ($pathInfo->getPid()) {
            $this->pidDetector->setPids(array($pathInfo->getPid()));
            $this->initializeRepositories();
        }
    }


    public function determinePidFromPathInfo(PathInfo $pathInfo)
    {
        $connection = $GLOBALS['TYPO3_DB']; /** @var \t3lib_DB $connection */

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


    protected function initializeRepositories()
    {
        $this->galleryRepository->injectPidDetector($this->pidDetector);
        $this->galleryRepository->initializeObject();

        $this->albumRepository->injectPidDetector($this->pidDetector);
        $this->albumRepository->initializeObject();

        $this->itemRepository->injectPidDetector($this->pidDetector);
        $this->itemRepository->initializeObject();
    }



    /**
     * @return mixed
     */
    protected function getPages()
    {
        $pathInfo = new PathInfo();

        if (!array_key_exists('/', $this->yagDirectoryCache)) {
            $this->yagDirectoryCache['/'] = array();
            $pageRecordList = $this->pidDetector->getPageRecords();

            foreach ($pageRecordList as $pageRecord) {
                $pathInfo->setDisplayName($pageRecord['title'])
                    ->setPid($pageRecord['uid'])
                    ->setPathType(PathInfo::INFO_PID);

                $this->yagDirectoryCache['/'][$pageRecord['uid']] = array(
                    'ctime' => $pageRecord['crdate'],
                    'mtime' => $pageRecord['tstamp'],
                    'name' =>  $pageRecord['title'] . ' |' . $pageRecord['uid'],
                    'identifier' => $pageRecord['title'] . ' |' . $pageRecord['uid'],
                    'storage' => $this->storage->getUid(),
                );

                $this->yagDirectoryPathCache['/' . $pageRecord['uid']] = true;
            }
        }

        return $this->yagDirectoryCache['/'];
    }



    protected function getGalleries(PathInfo $pathInfo)
    {
        $this->initializePidDetector($pathInfo);

        $pagePath = '/' . $pathInfo->getPid();

        if (!array_key_exists($pagePath, $this->yagDirectoryCache)) {
            $this->yagDirectoryCache[$pagePath] = array();
            $galleries = $this->galleryRepository->findAll();

            foreach ($galleries as $gallery) { /** @var \Tx_Yag_Domain_Model_Gallery $gallery */
                $this->yagDirectoryCache[$pagePath][$gallery->getUid()] = $this->buildGalleryObjectInfo($pathInfo, $gallery);
                $this->yagDirectoryPathCache[$pagePath . '/' . $gallery->getUid()] = true;
            }
        }

        return $this->yagDirectoryCache[$pagePath];
    }



    protected function buildGalleryObjectInfo(PathInfo $pathInfo, \Tx_Yag_Domain_Model_Gallery $gallery)
    {
        return array(
            'name' => $gallery->getName() . ' |' . $gallery->getUid(),
            'identifier' => \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($pathInfo->getPagePath(), $gallery->getName() . ' |' . $gallery->getUid())),
            'storage' => $this->storage->getUid(),
        );
    }



    protected function getAlbums(PathInfo $pathInfo)
    {
        $galleryPath = '/' . implode('/', array($pathInfo->getPid(), $pathInfo->getGalleryUId()));

        if (!array_key_exists($galleryPath, $this->yagDirectoryCache)) {
            $this->yagDirectoryCache[$galleryPath] = array();

            $albums = $this->albumRepository->findByGallery($pathInfo->getGalleryUId());

            foreach ($albums as $album) {
                $this->yagDirectoryCache[$galleryPath][$album->getUid()] = $this->buildAlbumObjectInfo($pathInfo, $album);
                $this->yagDirectoryPathCache[$galleryPath . '/' . $album->getUid()] = true;
            }
        }

        return $this->yagDirectoryCache[$galleryPath];
    }


    /**
     * @param PathInfo $pathInfo
     * @param \Tx_Yag_Domain_Model_Album $album
     * @return array
     */
    protected function buildAlbumObjectInfo(PathInfo $pathInfo, \Tx_Yag_Domain_Model_Album $album)
    {
        return array(
            'name' => $album->getName() . ' |' . $album->getUid(),
            'identifier' => \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($pathInfo->getGalleryPath(), $album->getName() . ' |' . $album->getUid())) . '/',
            'storage' => $this->storage->getUid(),
        );
    }


    /**
     * @param PathInfo $pathInfo
     * @return object
     */
    protected function getItem(PathInfo $pathInfo)
    {
        $this->initializePidDetector($pathInfo);
        return $this->itemRepository->findByUid($pathInfo->getItemUid());
    }


    protected function getItems(PathInfo $pathInfo)
    {
        $albumPath = '/' . implode('/', array($pathInfo->getPid(), $pathInfo->getGalleryUId(), $pathInfo->getAlbumUid()));

        if (!array_key_exists($albumPath, $this->yagDirectoryCache)) {
            $items = $this->itemRepository->findByAlbum($pathInfo->getAlbumUid());
            $this->yagDirectoryCache[$albumPath] = array();

            foreach ($items as $item) {
                $this->yagDirectoryCache[$albumPath][$item->getUid()] = $this->buildItemObjectInfo($pathInfo, $item);
                $this->yagDirectoryPathCache[$albumPath . '/' . $item->getUid()] = true;
            }
        }

        return $this->yagDirectoryCache[$albumPath];
    }



    protected function buildItemObjectInfo(PathInfo $pathInfo, \Tx_Yag_Domain_Model_Item $item)
    {
        return array(
            'size' => $item->getFilesize(),
            'atime' => $item->getTstamp()->getTimestamp(),
            'mtime' => $item->getTstamp()->getTimestamp(),
            'ctime' => $item->getCrdate()->getTimestamp(),
            'mimetype' => 'image/jpeg',
            'yagItem' => $item,
            'name' => $item->getOriginalFilename(),
            'identifier' =>  \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($pathInfo->getAlbumPath(), $item->getTitle() . ' |' . $item->getUid())),
            'storage' => $this->storage->getUid(),
            'description' => $item->getDescription(),
            'title' => $item->getTitle(),
            'href' => $item->getHref(),
            'hrefTarget' => $item->getHrefTarget(),
            'height' => $item->getHeight(),
            'width' => $item->getWidth(),
            'sourceUri' => $item->getSourceuri(),
        );
    }


    /**
     * Returns the default folder new files should be put into.
     *
     * @return \TYPO3\CMS\Core\Resource\Folder
     */
    public function getDefaultFolder()
    {
        // TODO: Implement getDefaultFolder() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }

    /**
     * Creates a folder.
     *
     * @param string $newFolderName
     * @param \TYPO3\CMS\Core\Resource\Folder $parentFolder
     * @return \TYPO3\CMS\Core\Resource\Folder The new (created) folder object
     */
    public function createFolder($newFolderName, \TYPO3\CMS\Core\Resource\Folder $parentFolder)
    {
        // TODO: Implement createFolder() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }


    /**
     * Checks if a file inside a storage folder exists.
     *
     * @param string $folderName
     * @param \TYPO3\CMS\Core\Resource\Folder $folder
     * @return boolean
     */
    public function folderExistsInFolder($folderName, \TYPO3\CMS\Core\Resource\Folder $folder)
    {
        // TODO: Implement folderExistsInFolder() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
    }

    /**
     * Renames a folder in this storage.
     *
     * @param \TYPO3\CMS\Core\Resource\Folder $folder
     * @param string $newName The target path (including the file name!)
     * @return array A map of old to new file identifiers
     * @throws \RuntimeException if renaming the folder failed
     */
    public function renameFolder(\TYPO3\CMS\Core\Resource\Folder $folder, $newName)
    {
        // TODO: Implement renameFolder() method.
        error_log('FAL DRIVER: ' . __FUNCTION__);
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
    public function isWithin(\TYPO3\CMS\Core\Resource\Folder $container, $content)
    {
        // TODO: Implement isWithin() method.
        error_log('CALLED: ' . __FUNCTION__ . ' with ' . $content . ' in folder ' . $container->getCombinedIdentifier());
    }

    /**
     * Checks if a folder contains files and (if supported) other folders.
     *
     * @param \TYPO3\CMS\Core\Resource\Folder $folder
     * @return boolean TRUE if there are no files and folders within $folder
     */
    public function isFolderEmpty(\TYPO3\CMS\Core\Resource\Folder $folder)
    {
        // TODO: Implement isFolderEmpty() method.
        error_log('CALLED: ' . __FUNCTION__);
    }



    protected function getYAGObjectInfoByPathInfo(PathInfo $pathInfo)
    {
        switch ($pathInfo->getPathType()) {

            case PathInfo::INFO_PID:
                return array(
                    'name' => $pathInfo->getDisplayName() . '|' . $pathInfo->getPid(),
                    'identifier' => $pathInfo->getIdentifier(),
                    'storage' => $this->storage->getUid(),
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


        return false;
    }




    protected function storeLastAccessedFalPath($falPath)
    {
        $this->registry->set('tx_yag', 'lastAccessedFalPath', $falPath);
    }


    protected function retrieveLastAccessedFalPath()
    {
        return $this->registry->get('tx_yag', 'lastAccessedFalPath');
    }
}
