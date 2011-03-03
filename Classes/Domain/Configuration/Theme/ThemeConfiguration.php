<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>
*  			Michael Knoll <mimi@kaktusteam.de>
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
 * Class implements theme configuration object for YAG.
 *
 * @package Domain
 * @subpackage Configuration\Theme
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_Theme_ThemeConfiguration extends Tx_PtExtlist_Domain_Configuration_AbstractConfiguration {


	/**
	 * Resolution config collection
	 * @var Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection
	 */
	protected $resolutionConfigCollection;
	
	
	/**
	 * Show breadcrumbs
	 * 
	 * @var boolean
	 */
	protected $showBreadcrumbs = true;
	
	
	
	/**
	 * Initializes configuration object (Template method)
	 */
	protected function init() {
		$this->resolutionConfigCollection = Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollectionFactory::getInstance($this->configurationBuilder, $this->settings['resolutionConfigs']);
		$this->setBooleanIfExistsAndNotNothing('showBreadcrumbs');
	}
	
	
	
	/**
	 * @return boolean 
	 */
	public function getShowBreadcrumbs() {
		return $this->showBreadcrumbs;
	}
	
	
	
	/**
	 * @return Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection
	 */
	public function getResolutionConfigCollection() {
		return $this->resolutionConfigCollection;
	}
}
?>