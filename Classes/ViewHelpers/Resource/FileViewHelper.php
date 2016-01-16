<?php
/***************************************************************
* Copyright notice
*
*   2010 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
* All rights reserved
*
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* Generic Viewhelper for rendering an URL to a file using getFileAbsFileName
* 
* Example:
* 
* <yag:resource.file path="{item}">
* 
* Only renders URL, no link action!
* 
* @package ViewHelpers
* @subpackage Resource
* @author Daniel Lienert <typo3@lienert.cc>
* @author Michael Knoll <mimi@kaktusteam.de>
*/

class Tx_Yag_ViewHelpers_Resource_FileViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @var Tx_Yag_Domain_FileSystem_Div
     */
    protected $fileSystemDiv;


    /**
     * @param Tx_Yag_Domain_FileSystem_Div $fileSystemDiv
     */
    public function injectFileSystemDiv(Tx_Yag_Domain_FileSystem_Div $fileSystemDiv)
    {
        $this->fileSystemDiv = $fileSystemDiv;
    }


    /**
     * Render the path
     *
     * @param string $path
     * @return string
     */
    public function render($path = '')
    {
        if ($path == '') {
            $path = $this->renderChildren();
        }

        if (file_exists(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($path))) {
            return $this->fileSystemDiv->getFileRelFileName($path);
        } else {
            return sprintf('The given Path %s was not found', htmlspecialchars($path));
        }
    }
}
