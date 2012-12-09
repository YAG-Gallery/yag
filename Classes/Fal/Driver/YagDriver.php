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


class YagDriver  extends \TYPO3\CMS\Core\Resource\Driver\AbstractDriver {
	/**
	 * Initializes this object. This is called by the storage after the driver
	 * has been attached.
	 *
	 * @return void
	 */
	public function initialize() {
		// TODO: Implement initialize() method.
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
		// TODO: Implement getPublicUrl() method.
	}

	/**
	 * Creates a (cryptographic) hash for a file.
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @param string $hashAlgorithm The hash algorithm to use
	 * @return string
	 */
	public function hash(\TYPO3\CMS\Core\Resource\FileInterface $file, $hashAlgorithm) {
		// TODO: Implement hash() method.
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
	}

	/**
	 * Checks if a resource exists - does not care for the type (file or folder).
	 *
	 * @param $identifier
	 * @return boolean
	 */
	public function resourceExists($identifier) {
		// TODO: Implement resourceExists() method.
	}

	/**
	 * Checks if a file exists.
	 *
	 * @param string $identifier
	 * @return boolean
	 */
	public function fileExists($identifier) {
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
		// TODO: Implement getFileForLocalProcessing() method.
	}

	/**
	 * Returns the permissions of a file as an array (keys r, w) of boolean flags
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @return array
	 */
	public function getFilePermissions(\TYPO3\CMS\Core\Resource\FileInterface $file) {
		// TODO: Implement getFilePermissions() method.
	}

	/**
	 * Returns the permissions of a folder as an array (keys r, w) of boolean flags
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $folder
	 * @return array
	 */
	public function getFolderPermissions(\TYPO3\CMS\Core\Resource\Folder $folder) {
		// TODO: Implement getFolderPermissions() method.
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
	}

	/**
	 * Returns information about a file for a given file identifier.
	 *
	 * @param string $identifier The (relative) path to the file.
	 * @return array
	 */
	public function getFileInfoByIdentifier($identifier) {
		// TODO: Implement getFileInfoByIdentifier() method.
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
		// TODO: Implement getFolderInFolder() method.
	}

	/**
	 * Copies a file to a temporary path and returns that path.
	 *
	 * @param \TYPO3\CMS\Core\Resource\FileInterface $file
	 * @return string The temporary path
	 */
	public function copyFileToTemporaryPath(\TYPO3\CMS\Core\Resource\FileInterface $file) {
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
	}

	/**
	 * Returns the root level folder of the storage.
	 *
	 * @return \TYPO3\CMS\Core\Resource\Folder
	 */
	public function getRootLevelFolder() {
		// TODO: Implement getRootLevelFolder() method.
	}

	/**
	 * Returns the default folder new files should be put into.
	 *
	 * @return \TYPO3\CMS\Core\Resource\Folder
	 */
	public function getDefaultFolder() {
		// TODO: Implement getDefaultFolder() method.
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
	}

	/**
	 * Checks if a folder exists
	 *
	 * @param string $identifier
	 * @return boolean
	 */
	public function folderExists($identifier) {
		// TODO: Implement folderExists() method.
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
	}

	/**
	 * Checks if a folder contains files and (if supported) other folders.
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $folder
	 * @return boolean TRUE if there are no files and folders within $folder
	 */
	public function isFolderEmpty(\TYPO3\CMS\Core\Resource\Folder $folder) {
		// TODO: Implement isFolderEmpty() method.
	}


}

?>
