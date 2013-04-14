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
 * collection of resolution configs
 *
 * @package Domain
 * @subpackage Configuration\Image
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_Image_SysImageConfigCollection extends Tx_PtExtbase_Collection_ObjectCollection {

	/**
	 * @var string
	 */
	protected $restrictedClassName = 'Tx_Yag_Domain_Configuration_Image_SysImageConfig';
	
	
	
	/**
	 * Add a system image config to the colection
	 * 
	 * @param Tx_Yag_Domain_Configuration_Image_SysImageConfig $sysImageConfig
	 * @param string $sysImageConfigName
	 */
	public function addSysImageConfig(Tx_Yag_Domain_Configuration_Image_SysImageConfig $sysImageConfig, $sysImageConfigName) {
		$this->addItem($sysImageConfig, $sysImageConfigName);
	}
	
	
	
	/** 
	 * Get a system image config
	 * 
	 * @param string $sysImageConfigName
	 * @return Tx_Yag_Domain_Configuration_Image_SysImageConfig
	 */
	public function getSysImageConfig($sysImageConfigName) {
		if($this->hasItem($sysImageConfigName)) {
			return $this->getItemById($sysImageConfigName);
		} else {
			throw new Exception('The system image with name ' . $sysImageConfigName . ' is not defined! 1293862423');
		}
	}
	
}

?>