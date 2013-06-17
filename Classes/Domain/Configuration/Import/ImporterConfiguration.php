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
 * Class for importer configuration
 *
 * @package Domain
 * @subpackage Configuration\Import
 * 
 * @author Michael Knoll <mimi@kaktsuteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_Import_ImporterConfiguration extends Tx_PtExtbase_Configuration_AbstractConfiguration {
	
	/**
	 * Parse the metadata of the imported items
	 *
	 * @var boolean
	 */
	protected $parseItemMeta;

	
	
	/**
	 * Generate tags from imported meta data
	 * 
	 * @var boolean
	 */
	protected $generateTagsFromMetaData;
	
	
	
	/**
	 * Holds file mask for imported files. Usually 660
	 *
	 * @var string
	 */
	protected $importFileMask;



	/**
	 * Title format on import
	 *
	 * @var array
	 */
	protected $titleFormat;


	/**
	 * Description Format on Import
	 *
	 * @var array
	 */
	protected $descriptionFormat;

	
	/**
	 * Inits object
	 */
	protected function init() {
		$this->setBooleanIfExistsAndNotNothing('parseItemMeta');
		$this->setBooleanIfExistsAndNotNothing('generateTagsFromMetaData');
		$this->setValueIfExists('titleFormat');
		$this->setValueIfExists('descriptionFormat');
		$this->setRequiredValue('importFileMask', 'Required property "importFileMask" is not set in importer configuration. 1311539644');
	}
	
	
	
	/**
	 * @return bool $getParseItemMeta
	 * 
	 */
	public function getParseItemMeta() {
		return $this->parseItemMeta;
	}
	
	
	
	/**
	 * @return boolean $generateTagsFromMetaData
	 * 
	 */
	public function getGenerateTagsFromMetaData() {
		return $this->generateTagsFromMetaData;
	}
	
	
	
	/**
	 * Gets file mask for imported files (in octal encoding)
	 *
	 * @return int File mask for imported files (octal)
	 */
	public function getImportFileMask() {
		return octdec($this->importFileMask);
	}

	/**
	 * @return boolean
	 */
	public function getUseFileNameAsTitle() {
		return $this->useFileNameAsTitle;
	}

	/**
	 * @param string $titleFormat
	 */
	public function setTitleFormat($titleFormat) {
		$this->titleFormat = $titleFormat;
	}

	/**
	 * @return string
	 */
	public function getTitleFormat() {
		return $this->titleFormat;
	}

	/**
	 * @param string $descriptionFormat
	 */
	public function setDescriptionFormat($descriptionFormat) {
		$this->descriptionFormat = $descriptionFormat;
	}

	/**
	 * @return string
	 */
	public function getDescriptionFormat() {
		return $this->descriptionFormat;
	}

}

?>