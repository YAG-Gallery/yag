<?php
namespace YAG\Yag\Scheduler;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Daniel Lienert <typo3@lienert.cc>
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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * YAG Scheduler Task
 *
 * @package YAG
 * @subpackage Scheduler
 */
abstract class AbstractAdditionalFieldProvider  implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface
{
    /**
     * @param $templatePathPart
     * @param array $data
     * @return string
     */
    protected function getFieldHTML($templatePathPart, $data = array())
    {
        $view = GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\View\\StandaloneView'); /** @var $view \TYPO3\CMS\Fluid\View\StandaloneView */
        $view->assignMultiple($data);
        $templateFileName = GeneralUtility::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Scheduler/' . $templatePathPart);
        $view->setTemplatePathAndFilename($templateFileName);
        return $view->render();
    }
}
