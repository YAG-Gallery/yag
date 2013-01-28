<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011-2011 punkt.de GmbH - Karlsruhe, Germany - http://www.punkt.de
 *  Authors: Daniel Lienert, Michael Knoll
 *  All rights reserved
 *
 *  For further information: http://extlist.punkt.de <extlist@punkt.de>
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
 * GPValueViewHelper
 * 
 * @author Daniel Lienert 
 * @package ViewHelpers
 * @subpackage NameSpace
 */
class Tx_YAG_ViewHelpers_Namespace_GPArrayViewHelper extends Tx_PtExtlist_ViewHelpers_Namespace_GPArrayViewHelper {
	
	/**
	 * render build key/value GET/POST-array within the namespace of the given object
	 * 
	 * @param string $arguments : list of arguments
	 * @param Tx_PtExtlist_Domain_StateAdapter_IdentifiableInterface $object
	 * 	either as list of 'key : value' pairs 
	 *  or as list of properties wich are then recieved from the object
	 * @param string $nameSpace
	 * @param string $contextIdentifier send a specific contextIdentifier
	 * @return array GPArray of objects namespace	 
	 */
	public function render($arguments, $object = NULL, $nameSpace = '', $contextIdentifier = '') {
		$argumentArray = parent::render($arguments, $object, $nameSpace);
		
		if($contextIdentifier) {
			$argumentArray['contextIdentifier'] = $contextIdentifier;
		}
		
		return $argumentArray;
	}
}
?>