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


class PathInfo implements \TYPO3\CMS\Core\SingletonInterface {

	const INFO_PID = 0;
	const INFO_GALLERY = 1;
	const INFO_ALBUM = 2;
	const INFO_ITEM = 3;
	const INFO_ROOT = 4;


	/**
	 * @var string
	 */
	protected $falPath;

	/**
	 * @var integer
	 */
	protected $pid = 0;


	/**
	 * @var Integer
	 */
	protected $galleryUId = 0;


	/**
	 * @var Integer
	 */
	protected $albumUid = 0;


	/**
	 * @var Integer
	 */
	protected $itemUid = 0;


	/**
	 * @var string
	 */
	protected $displayName;


	/**
	 * @var string
	 */
	protected $pathType;



	/**
	 * Set from YAG Path Identifier
	 *
	 * @param $identifier
	 * @return bool
	 */
	public function setFromIdentifier($identifier) {

		error_log('=================== Parsing ' . base64_decode($identifier));

		$this->reset();

		$identifierArray = unserialize(base64_decode($identifier));

		if($identifierArray === FALSE) {
			return FALSE;
		}

		foreach($identifierArray as $key => $value) {
			$setter = 'set' . ucfirst($key);
			if(method_exists($this, $setter)) {
				$this->$setter($value);
			}
		}

		$this->debug();

		return TRUE;
	}



	public function setFromFalPath($falPath) {

		error_log('=================== Parsing ' . $falPath);

		$this->reset();

		$this->falPath = $falPath;

		if($falPath === '/') {
			$this->pathType = self::INFO_ROOT;
			return $this;
		}

		$falPath = trim($falPath, '/');
		$pathParts = explode('/', $falPath);

		if(isset($pathParts[0])) {
			list($name, $key) = explode('|', $pathParts[0]);
			$this->setPid((int) $key);
			$this->pathType = self::INFO_PID;
		}

		if(isset($pathParts[1])) {
			list($name, $key) = explode('|', $pathParts[1]);
			$this->setGalleryUId((int) $key);
			$this->pathType = self::INFO_GALLERY;
		}


		if(isset($pathParts[2])) {
			list($name, $key) = explode('|', $pathParts[2]);
			$this->setAlbumUid((int) $key);
			$this->pathType = self::INFO_ALBUM;
		}


		if(isset($pathParts[3])) {
			list($name, $key) = explode('|', $pathParts[3]);
			$this->setItemUid((int) $key);
			$this->pathType = self::INFO_ITEM;
		}

		$this->setDisplayName($name);

		$this->debug();

		return $this;
	}


	public function debug() {
		$infoArray = array(
			'pathType' => $this->pathType,
			'displayName' => $this->displayName,
			'falPath' => $this->falPath,
			'pid' => $this->pid,
			'galleryUid' => $this->galleryUId,
			'albumUid' => $this->albumUid,
			'itemUid' => $this->itemUid
		);

		foreach($infoArray as $key => $value) {
			error_log($key . ':' . $value);
		}
	}


	public function getIdentifier() {
		$infoArray = array(
			'pathType' => $this->pathType,
			'displayName' => $this->displayName,
			'falPath' => $this->falPath,
			'pid' => $this->pid,
			'galleryUid' => $this->galleryUId,
			'albumUid' => $this->albumUid,
			'itemUid' => $this->itemUid
		);

		return base64_encode(serialize(array_filter($infoArray)));
	}



	public function reset(){
		$this->displayName = '';
		$this->pathType = '';
		$this->falPath = '';

		$this->pid = 0;
		$this->galleryUId = 0;
		$this->albumUid = 0;
		$this->itemUid = 0;
	}


	/**
	 * @param int $albumUid
	 */
	public function setAlbumUid($albumUid) {
		$this->albumUid = $albumUid;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getAlbumUid() {
		return $this->albumUid;
	}

	/**
	 * @param int $galleryUId
	 */
	public function setGalleryUId($galleryUId) {
		$this->galleryUId = $galleryUId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getGalleryUId() {
		return $this->galleryUId;
	}

	/**
	 * @param int $itemUid
	 */
	public function setItemUid($itemUid) {
		$this->itemUid = $itemUid;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getItemUid() {
		return $this->itemUid;
	}

	/**
	 * @param int $pid
	 */
	public function setPid($pid) {
		$this->pid = $pid;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPid() {
		return $this->pid;
	}

	/**
	 * @param string $falPath
	 */
	public function setFalPath($falPath) {
		$this->falPath = $falPath;
	}


	/**
	 * @return string
	 */
	public function getFalPath() {
		return $this->falPath;
	}

	/**
	 * @param string $infoName
	 */
	public function setDisplayName($infoName) {
		$this->displayName = $infoName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDisplayName() {
		return $this->displayName;
	}

	/**
	 * @param string $pathType
	 */
	public function setPathType($pathType) {
		$this->pathType = $pathType;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPathType() {
		return $this->pathType;
	}

}

?>
