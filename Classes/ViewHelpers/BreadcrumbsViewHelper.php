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
 * Class implements the navigation path
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 * @package ViewHelpers
 */
class Tx_Yag_ViewHelpers_BreadcrumbsViewHelper extends Tx_Fluid_Core_Widget_AbstractWidgetViewHelper {
	
	
	/**
	 * @var Tx_Yag_ViewHelpers_Widget_Controller_BreadcrumbsController
	 */
	protected $controller;

	
	/**
	 * @param Tx_Yag_ViewHelpers_Widget_Controller_BreadcrumbsController $controller
	 * @return void
	 */
	public function injectController(Tx_Yag_ViewHelpers_Widget_Controller_BreadcrumbsController $controller) {
		$this->controller = $controller;
	}
	
	

	/**
	 * Render the navigation path
	 * 
	 * @return string
	 */
	public function render() {
		return  $this->initiateSubRequest();
	}
}
?>
