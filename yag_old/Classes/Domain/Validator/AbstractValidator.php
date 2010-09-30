<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*  All rights reserved
*
*  This class is a backport of the corresponding class of FLOW3.
*  All credits go to the v5 team.
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
 * Abstract validator
 * 
 * This validator class extends AbstractValidator from Extbase and allows adding  
 * property errors instead of validation errors.
 *
 * @package Typo3
 * @subpackage yag
 * @version $Id:$
 * @author Michael Knoll
 * @since 2009-12-31
 */
abstract class Tx_Yag_Domain_Validator_AbstractValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

	/**
	 * Holds errors of already added properties. 
	 *
	 * @var array
	 */
	protected $propertyErrors = array();
	
	
	
	/**
	 * Adds a property error to current validator
	 *
	 * @param  string $propertyName    The name of the property to add the error for
	 * @param  string $message         The message that comes with the error
	 * @param  int    $code            The code of the error (most likely a timestamp)
	 * @return void    
	 * @author Michael Knoll <mimi@kaktusteam.de>
	 * @since  2009-12-30
	 */
	protected function addPropertyError($propertyName, $message, $code) {
		$validationErrors = array();
		// Make sure to be able to add multiple property errors for one property!
		if (!array_key_exists($propertyName, $this->propertyErrors)) {
		    $this->propertyErrors[$propertyName] = t3lib_div::makeInstance('Tx_Extbase_Validation_PropertyError', $propertyName);
		    $this->errors[] = $this->propertyErrors[$propertyName]; 
		}
		$validationErrors[] = t3lib_div::makeInstance('Tx_Extbase_Validation_Error', $message, $code);
		$this->propertyErrors[$propertyName]->addErrors($validationErrors);
	}
	
}

?>