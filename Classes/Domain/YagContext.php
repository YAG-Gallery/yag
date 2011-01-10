<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Class holds settings and objects for yag gallery.
 *
 * @package Domain
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_YagContext {

	/**
	 * Holds a singleton instance of this class
	 *
	 * @var Tx_Yag_Domain_YagContext
	 */
	private static $instance = null;
	
	
	
	/**
	 * Holds an array of extlist contexts - one for each list identifier
	 *
	 * @var array<string => Tx_Yag_Extlist_ExtlistContext> 
	 */
	protected $extlistContexts;
	
	
	
	/**
	 * Returns a singleton instance of this class
	 *
	 * @return Tx_Yag_Domain_YagContext Singleton instance of Tx_Yag_Domain_YagContext
	 */
	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new Tx_Yag_Domain_YagContext();
		}
		return self::$instance;
	}
	
	
	
	/**
	 * Constructor for yag context
	 */
	protected function __construct() {
		$this->extlistContexts = array();
	}
	
	
	
	/**
	 * Getter for extlist context. Returns extlist context for given list identifier 
	 *
	 * @param string $listIdentifier List identifier for getting corresponding extlist context
	 */
	public function getExtlistContextByListIdentifier($listIdentifier) {
		
	}
	
	
	
	/**
	 * Setter for extlist context.
	 *
	 * @param string $listIdentifier
	 * @param Tx_Yag_Extlist_ExtlistContext $extlistContext
	 */
	public function setExtlistContextByListIdentifier($listIdentifier, Tx_Yag_Extlist_ExtlistContext $extlistContext) {
		$this->extlistContexts[$listIdentifier] = $extlistContext;
	}
	
}
 
?>