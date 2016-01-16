<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2014 Daniel Lienert <typo3@lienert.cc>
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
 * TCA Manager
 *
 * @package pt_dppp_zca
 * @subpackage Domain\Utility
 */

class Tx_Yag_Utility_TCAUtility implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * @return void
     */
    public function deactivateHiddenFields()
    {
        $this->deactivateHiddenField('tx_yag_domain_model_item');
        $this->deactivateHiddenField('tx_yag_domain_model_album');
        $this->deactivateHiddenField('tx_yag_domain_model_gallery');
    }

    /**
     * @param string $tableName
     */
    protected function deactivateHiddenField($tableName)
    {
        $GLOBALS['TCA'][$tableName]['ctrl']['enablecolumns']['disabled'] = '';
    }
}
