<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*            
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
 * Class implements a fake viewhelper to add a CSS file to the header
 *
 * @author Daniel Lienert <daniel@lienert.cc>
 * @package ViewHelpers
 * @subpackage Javascript
 * 
 */
class Tx_Yag_ViewHelpers_CSS_IncludeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	
	/**
	 * @param string $library
	 * @param string $file
	 */
	public function render($library = '', $file = '') {
		
		$headerInclusion = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')->get('Tx_Yag_Utility_HeaderInclusion'); /* @var $headerInclusion  Tx_Yag_Utility_HeaderInclusion  */
		
		if($library) {
			$headerInclusion->addDefinedLibCSS($library);
		}
		
		if($file) {
			$headerInclusion->addCSSFile($file);
		}
	}

}
?>