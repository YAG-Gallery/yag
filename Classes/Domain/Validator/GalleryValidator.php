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
 * Class definition file for a Gallery object validator
 *
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @scope singleton
 */



/**
 * Class implements a validator for a gallery object
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-29
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Domain_Validator_GalleryValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

    /**
     * Returns true, if the given gallery object is valid
     *
     * @param Tx_Yag_Domain_Model_Gallery $gallery  The gallery object
     * @return boolean true
     */
    public function isValid($gallery) {
    	$isValid = true;
    	// check for correct length of title
        if (strlen($gallery->getName()) <= 0) {
            $this->addError('The name of the gallery must not be empty!', time());
            $isValid = false;
        }
        return $isValid;
    }

}
?>