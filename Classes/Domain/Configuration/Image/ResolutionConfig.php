<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <knoll@punkt.de>
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

/**
 * Configuration for image resolution
 *
 * @package Domain
 * @subpackage Configuration\Image
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_Image_ResolutionConfig extends Tx_PtExtlist_Domain_Configuration_AbstractConfiguration {
	
	
	/**
	 * The mode is the _typoScriptNodeValue of the Resolutionconfig typoscript branch
	 * It indicates if an image should be rendered default or via GIFBUILDER
	 * 
	 * @var string
	 */
	protected $mode;
	
	
	/**
	 * Holds the width of the image
	 *
	 * @var integer
	 */
	protected $width = 150;
	
	
	/**
	 * Holds the height of the image
	 *
	 * @var integer
	 */
	protected $height;
	
	
	
	/**
	 * Holds the quality of the image
	 * 
	 * @var integer
	 */
	protected $quality = 70;
	
	
	/**
	 * Name of this named resolution
	 * 
	 * @var string
	 */
	protected $name;
	
	
	/**
	 * Initializes properties
	 */
	protected function init() {
		$this->setRequiredValue('name', 'No name for this resolution set! 1298208644');
		
		$this->setValueIfExistsAndNotNothing('_typoScriptNodeValue', 'mode');
		unset($this->settings['_typoScriptNodeValue']);
		
		$this->setValueIfExistsAndNotNothing('height');
		$this->setValueIfExistsAndNotNothing('width');
		$this->setValueIfExistsAndNotNothing('quality');
	}
	
	
	
	/**
	 * Returns height
	 *
	 * @return string
	 */
	public function getHeight() {
		return $this->height;
	}
	
	
	
	/**
	 * Returns width
	 *
	 * @return string
	 */
	public function getWidth() {
		return $this->width;
	}
	
	
	
	/**
	 * Returns quality
	 *
	 * @return string
	 */
	public function getQuality() {
		return $this->quality;
	}
	
	
	/**
	 * Returns name
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	
	/**
	 * Mode = '' or 'GIFBUILDER'
	 * @return string
	 */
	public function getMode() {
		return $this->mode;
	}
	
}
?>