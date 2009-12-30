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
 * Class definition file for a AddImagesByFile form object validator
 *
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @scope singleton
 */



/**
 * Class implements a validator for a addImagesByFile form object
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-29
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Domain_Validator_FormObject_AddImagesByFileValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

    /**
     * Returns true, if the given AddImagesByFile form object is valid
     *
     * @param Tx_Yag_Domain_Model_FormObject_AddImagesByFile $addImagesByFile  The addImagesByFile form object
     * @return boolean true
     */
    public function isValid($addImagesByFile) {
    	$isValid = true;
    	// check for existence of base path
        if (!is_dir($addImagesByFile->getBasePath())) {
            $this->addError('The given base path is not a valid path on this system!', time());
            $isValid = false;
        }
        
        // check for correct value of quality parameters
        if (!(1 <= $addImagesByFile->getSinglesQuality() && $addImagesByFile->getSinglesQuality() <= 100)) {
        	$this->addError('Singles Quality must be a value between 1 and 100');
        	$isValid = false;
        }
        if (!(1 <= $addImagesByFile->getThumbsQuality() && $addImagesByFile->getThumbsQuality() <= 100)) {
        	$this->addError('Thumbs Quality must be a value between 1 and 100');
            $isValid = false;
        }
        return $isValid;
    }

}
?>