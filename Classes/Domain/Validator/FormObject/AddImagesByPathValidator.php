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
 * Class definition file for a AddImagesByPath form object validator
 *
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @scope singleton
 */



/**
 * Class implements a validator for a addImagesByPath form object
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-29
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Domain_Validator_FormObject_AddImagesByPathValidator extends Tx_Yag_Domain_Validator_AbstractValidator {

    /**
     * Returns true, if the given AddImagesByPath form object is valid
     *
     * @param Tx_Yag_Lib_FormObject_AlbumContent_AddImagesByPath $addImagesByPath  The addImagesByPath form object
     * @return boolean true
     */
    public function isValid($addImagesByPath) {
    	$isValid = TRUE;
        if (!is_dir($addImagesByPath->getBasePath())) {
            $this->addPropertyError('basePath', 'The given base path is not a valid path on this system!', 1262175834);
            $isValid = FALSE;
        }
        if (!is_dir($addImagesByPath->getBasePath() . '/' . $addImagesByPath->getOrigsPath())) {
        	$this->addPropertyError('origsPath','The given origs path is not a valid path inside the given base path!', 1262175835);
        	$isValid = FALSE;
        }
        if (!is_dir($addImagesByPath->getBasePath() . '/' . $addImagesByPath->getSinglesPath())) {
        	$this->addPropertyError('singlesPath', 'The given singles path is not a valid path inside the given base path!', 1262175836);
        	$isValid = FALSE;
        }
        if (!is_dir($addImagesByPath->getBasePath() . '/' . $addImagesByPath->getThumbsPath())) {
        	$this->addPropertyError('thumbsPath', 'The given thumbs path is not a valid path inside the given base path!', 1262175837);
        	$isValid = FALSE;
        }
        return $isValid;
    }

}
?>