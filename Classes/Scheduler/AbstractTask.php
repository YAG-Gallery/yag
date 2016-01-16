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
abstract class AbstractTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;


    public function __construct()
    {
        parent::__construct();

        $this->initializeExtbase();
        $this->initializeScheduler();
    }


    public function __wakeup()
    {
        $this->initializeExtbase();
        $this->initializeScheduler();
    }


    /**
     * Template method to initialize the scheduler
     */
    protected function initializeScheduler()
    {
        die('this should not be called');
    }


    /**
     * Initialize Extbase
     *
     * This is necessary to resolve the TypoScript interface definitions
     */
    protected function initializeExtbase()
    {
        $configuration['extensionName'] = 'Yag';
        $configuration['pluginName'] = 'dummy';
        $extbaseBootstrap = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Core\\Bootstrap'); /** @var \TYPO3\CMS\Extbase\Core\Bootstrap $extbaseBootstrap  */
        $extbaseBootstrap->initialize($configuration);

        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
    }


    /**
     * @param $templatePathPart
     * @param array $data
     * @return string
     */
    protected function getFieldHTML($templatePathPart, $data = array())
    {
        $view = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView'); /** @var $view \TYPO3\CMS\Fluid\View\StandaloneView */
        $view->assignMultiple($data);
        $view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Scheduler/' . $templatePathPart));
        return $view->render();
    }
}
