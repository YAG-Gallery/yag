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
 * Class definition for backend configuration viewhelper
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 * @package ViewHelpers
 */

class Tx_Yag_ViewHelpers_Backend_ConfigurationViewHelper extends Tx_Fluid_ViewHelpers_Be_AbstractBackendViewHelper {
	
	public function render() {
		$doc = $this->getDocInstance();
		$baseUrl = '../' . t3lib_extMgm::siteRelPath('yag');

		$pageRenderer = $doc->getPageRenderer();
		
		$pageRenderer->loadExtJS(false, false);

		$compress = true; // Set to false for debugging purposes

		// Standard theme CSS
		$pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/theme.css', 'stylesheet', 'all', '', $compress);
		
		$pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/itemAdminThumb.css', 'stylesheet', 'all', '', $compress);
		
		// Backend theme CSS
		$pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/Backend.css', 'stylesheet', 'all', '', $compress);
		
		
		// Jquery
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/JQuery/jquery-1.4.4.min.js', 'text/javascript', $compress);
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/JQuery/jquery-ui-1.8.7.custom.min.js', 'text/javascript', $compress);
		
		
		$pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/JQuery/base.css', 'stylesheet', 'all', '', $compress);
		$pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css', 'stylesheet', 'all', '', $compress);
		
		// SWFUploader
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/SwfUpload/swfupload.js', 'text/javascript', $compress);
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/swfobjects.js', 'text/javascript', $compress);
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/swfuploadqueue.js', 'text/javascript', $compress);
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/fileprogress.js', 'text/javascript', $compress);
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/swfcustom.js', 'text/javascript', $compress);
		
	}
}

?>