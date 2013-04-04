<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <lienert@punkt.de>, Michael Knoll <mimi@kaktsuteam.de>
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
 * collection of fe libs
 *
 * @package Domain
 * @subpackage Configuration\FrontendLib
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_FrontendLib_FrontendLibConfigCollection extends Tx_PtExtbase_Collection_ObjectCollection {

	/**
	 * @var string
	 */
	protected $restrictedClassName = 'Tx_Yag_Domain_Configuration_FrontendLib_FrontendLibConfig';
	
	
	
	/**
	 * Add a frontend lib config
	 * 
	 * @param Tx_Yag_Domain_Configuration_FrontendLib_FrontendLibConfig $frontendLibConfig
	 * @param string $frontendLibName
	 */
	public function addFrontendLibConfig(Tx_Yag_Domain_Configuration_FrontendLib_FrontendLibConfig $frontendLibConfig, $frontendLibName) {
		$this->addItem($frontendLibConfig, $frontendLibName);
	}
	
	
	
	/** 
	 * @param string $frontendLibName
	 * @return Tx_Yag_Domain_Configuration_FrontendLib_FrontendLibConfig
	 */
	public function getFrontendLibConfig($frontendLibName) {
		if($this->hasItem($frontendLibName)) {
			return $this->getItemById($frontendLibName);
		} else {
			throw new Exception('The frontendLib row with name ' . $frontendLibName . ' is not defined! 1300798012');
		}
	}
	
}

?>