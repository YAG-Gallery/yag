<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
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
 * Class implements read only access to tt_content table
 *
 * @package Domain
 * @subpackage Model\Extern
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Model_Extern_TTContent extends Tx_Extbase_DomainObject_AbstractEntity {


	/**
	 * Type of the content element
	 *
	 * @var string $listType
	 */
	protected $listType;

	/**
	 * The constructor.
	 *
	 * @return void
	 */
	public function __construct() {
	}
	
	
	
	/**
	 * Setter for listType
	 *
	 * @param string $listType
	 * @return void
	 */
	public function setListType($listType) {
		$this->listType = $listType;
	}


	/**
	 * Getter for listType
	 *
	 * @return string listType
	 */
	public function getListType() {
		return $this->listType;
	}
}
?>