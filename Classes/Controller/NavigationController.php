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
 * Controller for YAG navigation widgets
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_NavigationController extends Tx_Yag_Controller_AbstractController {
    
	/**
	 * Was soll hier passieren:
	 * 
	 * 1. Wir benutzen ein Objekt "GalleryState" welches einen Zustand in die Session schreibt
	 * 
	 * 2. Wird eine Gallery ausgewählt, wir diese in den Zustand geschrieben
	 * 2.1 Wird eine neue Gallery ausgewählt / der Gallery-Controller angezeigt, wird die Gallery im Zustand resetted
	 * 
	 * 3. Wird ein Album ausgewählt, wird dieses in den Zustand geschrieben
	 * 3.1 Wird ein neues Album gewählt / der Album-List Controller angezeigt, wird das Album im Zustand resetted
	 * 
	 * 4. Werden weitere Filter aktiviert (Tags etc.) werden die Zustände in den Filtern festgehalten
	 * 4.1 Der Album Zustand hat Zugriff auf die aktiven Filter
	 * 4.2 Die Navigation erhält die Album-Filter-Breadcrumbs und kann von diesen Werte anzeigen
	 * 
	 * Der Zustand wird über den Lifecycle-Manager gemanaged.
	 * 
	 * Frage: Wäre es nicht intuitiver, den Album-Filter aus dem Gallery Zustand heraus zu setzen?
	 * --> nur noch domainspezifische Daten im Zustand setzen, keine "komischen" Filterwerte setzen... 
	 */
	
	/**
	 * Action for rendering navigation
	 *
	 * @return string Rendered show action
	 */
	public function showAction() {
		$this->view->assign('yagContext', $this->yagContext);
	}
	
}
 
?>