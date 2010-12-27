<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 Michael Knoll <mimi@kaktusteam.de>
*  			Daniel Lienert <daniel@lienert.cc>
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
 * Class implements ItemFile domain object. An item file is a source for 
 * a file associated with an item. For example a thumb image generated for an 
 * item is a item file.
 *
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Domain
 * @subpackage Model
 */
class Tx_Yag_Domain_Model_ItemFile extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * This is the full qualified path to the file relative to
	 * yag gallery's root path (set in ExtMgm).
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $path;
	
	
	
	/**
	 * A file name differing from the file name given to the item
	 * file by the yag file system. As all files in yag's filesystem 
	 * get an ID as filename, this property can be used to preserve
	 * the corresponding file's filename.
	 * 
	 * @var string
	 */
	protected $name;
	
	
	
	/**
	 * Constructor for item file
	 *
	 * @param string $path
	 * @param string $name
	 */
	public function __construct($path = null, $name = null) {
		parent::__construct();
		$this->path = $path;
		$this->name = $name;
	}
	
	
	
	/**
	 * Setter for path
	 *
	 * @param string $path path
	 * @return void
	 */
	public function setPath($path) {
		$this->path = $path;
	}
	
	

	/**
	 * Getter for path
	 *
	 * @return string path
	 */
	public function getPath() {
		return $this->path;
	}
	
	
	
	/**
	 * Setter for name
	 *
	 * @param string $name name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	

	/**
	 * Getter for name
	 *
	 * @return string name
	 */
	public function getName() {
		return $this->name;
	}
	
	
	
	/**
	 * Returns directory from corresponding file path
	 *
	 * @return string Directory part of file path
	 */
	public function getDirectoryPartFromPath() {
		return Tx_Yag_Domain_ImageProcessing_YagDiv::getPathFromFilePath($this->path);
	}
	
}
?>