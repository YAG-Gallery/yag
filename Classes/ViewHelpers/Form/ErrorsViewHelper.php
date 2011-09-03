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
 * Error messages view helper
 *
 * = Examples =
 * 
 * {namespace yag = Tx_Yag_ViewHelpers}
 * <yag:form.errors for="{for}" class="tx-yag-form-errors">
 *     <div class="tx-yag-form-error">
 *         {error.message}
 *         <f:if condition="{error.propertyName}">
 *             <p>
 *                 <strong>{error.propertyName}</strong>:
 *                 <f:for each="{error.errors}" as="errorDetail">
 *                     {errorDetail.message}
 *                 </f:for>
 *             </p>
 *         </f:if>
 *     </div>
 * </yag:form.errors>
 * 
 *
 * Output:
 * <ul>
 *   <li>1234567890: Validation errors for argument "newBlog"</li>
 * </ul>
 *
 * @author Michael Knoll
 * @package ViewHelpers
 * @subpackage Form
 */
class Tx_Yag_ViewHelpers_Form_ErrorsViewHelper extends Tx_Fluid_ViewHelpers_Form_ErrorsViewHelper {

	/**
	 * Iterates through selected errors of the request.
	 *
	 * @param string $for The name of the error name (e.g. argument name or property name)
	 * @param string $as The name of the variable to store the current error
	 * @param string $class The name of the css class to be used for surrounding div container
	 * @return string Rendered string
	 * @author Michael Knoll <mimi@kaktusteam.de>
	 * @api
	 */
	public function render($for = '', $as = 'error', $class='') {
		$output = '';
		$parentOutput = parent::render($for, $as);
		if ($class !=='' && $parentOutput !== '') {
			$output .= '<div class="'.$class.'">';
			$output .= $parentOutput;
			$output .= '</div>';
		} else {
			$output = $parentOutput;
		}
		return $output;
	}
}
?>