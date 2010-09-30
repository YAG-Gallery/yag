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
 * Class definition file for form object handling form parameters for
 * adding files by path form.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


/**
 * Class implements a form object handling parameters from a form 
 * for adding images by path.
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-29
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Domain_Model_FormObject_AddImagesByPath implements Tx_Yag_Lib_AlbumPathSettingsInterface {

	/**
	 * Path to directory containing album images
	 * @var string
	 */
	protected $basePath;

	
	
	/**
	 * Path to directory containing singles (relaitve to upper base path)
	 * @var string
	 */
	protected $singlesPath;
	
	
	
	/**
	 * Path to directory containing thumbs (relative to upper directory)
	 * @var string
	 */
	protected $thumbsPath;
	
	
	
	/**
	 * Path to directory containing original images (relative to upper base path)
	 * @var string
	 */
	protected $origsPath;
	
	
	
	/**
	 * @return string
	 */
	public function getBasePath() {
		return $this->basePath;
	}
	
	
	
	/**
	 * @return string
	 */
	public function getOrigsPath() {
		return $this->origsPath;
	}
	
	
	
	/**
	 * @return string
	 */
	public function getSinglesPath() {
		return $this->singlesPath;
	}
	
	
	
	/**
	 * @return string
	 */
	public function getThumbsPath() {
		return $this->thumbsPath;
	}
	
	
	
	/**
	 * @param string $basePath
	 */
	public function setBasePath($basePath) {
		$this->basePath = $basePath;
	}
	
	
	
	/**
	 * @param string $origsPath
	 */
	public function setOrigsPath($origsPath) {
		$this->origsPath = $origsPath;
	}
	
	
	
	/**
	 * @param string $singlesPath
	 */
	public function setSinglesPath($singlesPath) {
		$this->singlesPath = $singlesPath;
	}
	
	
	
	/**
	 * @param string $thumbsPath
	 */
	public function setThumbsPath($thumbsPath) {
		$this->thumbsPath = $thumbsPath;
	}
	
}

?>
