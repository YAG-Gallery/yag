<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*            
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
 * Class definition file of a class holding album sizes parameters
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


/**
 * Class for holding album sizes parameters
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since  2009-12-26
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Lib_AlbumSizeParameters {
	
	/**
	 * Height of thumbnails
	 *
	 * @var int
	 */
	protected $thumbsHeight;
	
	
	
	/**
	 * Width of thumbnails
	 *
	 * @var int
	 */
	protected $thumbsWidth;
	
	
	
	/**
	 * Quality of thumbs (1..100)
	 *
	 * @var int
	 */
	protected $thumbsQuality;
	
	
	
	/**
	 * Height of singles
	 *
	 * @var int
	 */
	protected $singlesHeight;
	
	
	
	/**
	 * Width of singles
	 *
	 * @var int
	 */
	protected $singlesWidth;
	
	
	
	/**
	 * Quality of singles (1..100)
	 *
	 * @var int
	 */
	protected $singlesQuality;
	
	
	
	/**
	 * @return int
	 */
	public function getSinglesHeight() {
		return $this->singlesHeight;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getSinglesQuality() {
		return $this->singlesQuality;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getSinglesWidth() {
		return $this->singlesWidth;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getThumbsHeight() {
		return $this->thumbsHeight;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getThumbsQuality() {
		return $this->thumbsQuality;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getThumbsWidth() {
		return $this->thumbsWidth;
	}
	
	
	
	/**
	 * @param int $singlesHeight
	 */
	public function setSinglesHeight($singlesHeight) {
		$this->singlesHeight = $singlesHeight;
	}
	
	
	
	/**
	 * @param int $singlesQuality
	 */
	public function setSinglesQuality($singlesQuality) {
		$this->singlesQuality = $singlesQuality;
	}
	
	
	
	/**
	 * @param int $singlesWidth
	 */
	public function setSinglesWidth($singlesWidth) {
		$this->singlesWidth = $singlesWidth;
	}
	
	
	
	/**
	 * @param int $thumbsHeight
	 */
	public function setThumbsHeight($thumbsHeight) {
		$this->thumbsHeight = $thumbsHeight;
	}
	
	
	
	/**
	 * @param int $thumbsQuality
	 */
	public function setThumbsQuality($thumbsQuality) {
		$this->thumbsQuality = $thumbsQuality;
	}
	
	
	
	/**
	 * @param int $thumbsWidth
	 */
	public function setThumbsWidth($thumbsWidth) {
		$this->thumbsWidth = $thumbsWidth;
	}

}

?>
