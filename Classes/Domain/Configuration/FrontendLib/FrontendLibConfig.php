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
 * Configuration for frontend library
 *
 * @package Domain
 * @subpackage Configuration\FrontendLib
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_FrontendLib_FrontendLibConfig extends Tx_PtExtbase_Configuration_AbstractConfiguration {

	/**
	 * Indicates if it is allowed to include this lib
	 * @var boolean 
	 */
	protected $include = FALSE;


	
	/**
	 * @var array
	 */
	protected $includeJS = array();
	


	/**
	 * @var array
	 */
	protected $includeCSS = array();


	
	/**
	 * Initializes properties
	 */
	protected function init() {
		$this->setBooleanIfExistsAndNotNothing('include');
		$this->setValueIfExistsAndNotNothing('includeJS');
		$this->setValueIfExistsAndNotNothing('includeCSS');
	}
	
	
	
	/**
	 * @return boolean
	 */
	public function getInclude() {
		return $this->include;
	}
	
	
	
	/**
	 * @return array
	 */
	public function getJSFiles() {
		return $this->includeJS;
	}
	
	
	
	/**
	 * @return array
	 */
	public function getCSSFiles() {
		return $this->includeCSS;
	}
	
}
?>