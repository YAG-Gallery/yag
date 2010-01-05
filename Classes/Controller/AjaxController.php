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
 * Controller for Album Content 
 * 
 * This controller handles all ajax actions
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */



/**
 * Class implements a controller for ajax actions
 * 
 * @package Typo3
 * @subpackage yag
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2010-01-03
 */
class Tx_Yag_Controller_AjaxController extends Tx_Yag_Controller_AbstractController {
    
	/**
	 * Returns index action
	 * 
	 * @return string  The rendered index action
	 */
	public function indexAction() {
		
	}
	
	
	
	/**
	 * Returns some test content and ends further processing
	 *
	 * @return void
	 */
	public function ajaxResponseAction() {
		ob_clean();
		$average = 10;
		$count = 20;
		header('Content-type: text/xml'); 
		$xml = "<ratings><average>$average</average><count>$count</count></ratings>";
		echo $xml;
		die();
	}
	
}
?>
