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
 * ResolutionPreset
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Yag_Domain_Model_ResolutionPreset extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * name
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;
	
	
	
	/**
	 * isRequired
	 * @var boolean
	 */
	protected $isRequired;
	
	
	
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
	 * Setter for isRequired
	 *
	 * @param boolean $isRequired isRequired
	 * @return void
	 */
	public function setIsRequired($isRequired) {
		$this->isRequired = $isRequired;
	}
	
	

	/**
	 * Getter for isRequired
	 *
	 * @return boolean isRequired
	 */
	public function getIsRequired() {
		return $this->isRequired;
	}
	
	
	
	/**
	 * Returns the boolean state of isRequired
	 *
	 * @return boolean The state of isRequired
	 */
	public function isIsRequired() {
		return $this->getIsRequired();
	}
	
}
?>