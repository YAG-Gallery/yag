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
	 * path
	 * @var string
	 * @validate NotEmpty
	 */
	protected $path;
	
	
	
	/**
	 * name
	 * @var string
	 */
	protected $name;
	
	
	
	/**
	 * Constructor for item file
	 *
	 * @param string $path
	 * @param string $name
	 */
	public function __construct($path, $name) {
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
	
}
?>