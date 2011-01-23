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
 * Class definition file of resizing parameter
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */



/**
 * Class for storing image resizing parameters
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since  2009-12-25
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Lib_ResizingParameter {
	
	/**
	 * Width of image
	 * @var int
	 */
	protected $width;
	
	
	
	/**
	 * Height of image
	 * @var int
	 */
	protected $height;
	
	
	
	/**
	 * Source path of image
	 * @var string
	 */
	protected $source;
	
	
	
	/**
	 * Target path of image
	 * @var string
	 */
	protected $target;
	
	
	
	/**
	 * Quality of resizing (1..100)
	 * @var int
	 */
	protected $quality;
	
	/**
	 * @return int
	 */
	public function getQuality() {
		return $this->quality;
	}
	
	/**
	 * @param int $quality
	 */
	public function setQuality($quality) {
		$this->quality = $quality;
	}
	
	/**
	 * @return int
	 */
	public function getHeight() {
		return $this->height;
	}
	
	
	
	/**
	 * @return string
	 */
	public function getSource() {
		return $this->source;
	}
	
	
	
	/**
	 * @return string
	 */
	public function getTarget() {
		return $this->target;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getWidth() {
		return $this->width;
	}
	
	
	
	/**
	 * @param int $height
	 */
	public function setHeight($height) {
		$this->height = $height;
	}
	
	
	
	/**
	 * @param string $source
	 */
	public function setSource($source) {
		$this->source = $source;
	}
	
	
	
	/**
	 * @param string $target
	 */
	public function setTarget($target) {
		$this->target = $target;
	}
	
	
	
	/**
	 * @param int $width
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

}

?>
