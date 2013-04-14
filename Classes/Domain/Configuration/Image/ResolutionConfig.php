<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
class Tx_Yag_Domain_Configuration_Image_ResolutionConfig extends Tx_PtExtbase_Configuration_AbstractConfiguration {
	
	
	/**
	 * The mode is the _typoScriptNodeValue of the Resolutionconfig typoscript branch
	 * It indicates if an image should be rendered default or via GIFBUILDER
	 * 
	 * @var string
	 */
	protected $mode;
	
	
	
	/**
	 * Name of this named resolution
	 * 
	 * @var string
	 */
	protected $name;
	
	
	
	/**
	 * MD5 Hash of all parameters 
	 * 
	 * @var string
	 */
	protected $parameterHash;
	
	
	
	/**
	 * Initializes properties
	 */
	protected function init() {
		$this->setRequiredValue('name', 'No name for this resolution set! 1298208644');
		
		$this->setValueIfExistsAndNotNothing('_typoScriptNodeValue', 'mode');
		unset($this->settings['_typoScriptNodeValue']);
		
		$settingsForHash = $this->settings;
		unset($settingsForHash['name']);
		$this->parameterHash = md5($this->mode . serialize($settingsForHash));
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
	
	
	
	/**
	 * Get a md5Hash that 
	 * @return string
	 */
	public function getParameterHash() {
		return $this->parameterHash;
	}
}
?>