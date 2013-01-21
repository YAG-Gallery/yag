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


class PathInfo {

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
	 * @param int $albumUid
	 */
	public function setAlbumUid($albumUid) {
		$this->albumUid = $albumUid;
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
}

?>
