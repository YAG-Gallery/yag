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
class Tx_Yag_Domain_Configuration_Image_SysImageConfig extends Tx_PtExtbase_Configuration_AbstractConfiguration {
	
	
	/**
	 * Source Uri of the system image
	 *
	 * @var string
	 */
	protected $sourceUri = '';
	
	
	/**
	 * Title of the system image
	 *
	 * @var string
	 */
	protected $title = '';
	
	
	
	/**
	 * Description of the system image
	 *
	 * @var string
	 */
	protected $description = '';
	
	
	/**
	 * Initializes properties
	 */
	protected function init() {
		$this->setRequiredValue('sourceUri', 'Source Uri of this system image not set! 1298831563');
		if(!file_exists(Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($this->getSourceUri()))) throw new Exception('Imagesource ' . Tx_Yag_Domain_FileSystem_Div::makePathAbsolute($this->getSourceUri()) . ' defined by system image not found. 1298833321');

		$this->setValueIfExistsAndNotNothing('title');
		$this->setValueIfExistsAndNotNothing('description');
	}
	
	
	
	/**
	 * Returns sourceUri
	 *
	 * @return string
	 */
	public function getSourceUri() {
		return $this->sourceUri;
	}
	
	
	
	/**
	 * Returns title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	
	
	/**
	 * Returns description
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
}
?>