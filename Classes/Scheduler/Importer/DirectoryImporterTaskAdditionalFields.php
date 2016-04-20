<?php
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

namespace DL\Yag\Scheduler\Importer;

use TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface;
use TYPO3\CMS\Scheduler\Controller\SchedulerModuleController;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * SQL Runner Task Additional Fields
 *
 * @package    YAG
 * @subpackage Scheduler
 */
class DirectoryImporterTaskAdditionalFields implements AdditionalFieldProviderInterface {
    /**
     * @var array
     */
    protected $configuration = array(
        'sysFolderPid' => 'SysFolder Pid',
        'removeFiles'  => 'Remove Files after import',
    );

    /**
     * Gets additional fields to render in the form to add/edit a task
     *
     * @param array                     $taskInfo        Values of the fields from the add/edit task form
     * @param tx_scheduler_Task         $task            The task object being eddited. Null when adding a task!
     * @param SchedulerModuleController $schedulerModule Reference to the scheduler backend module
     *
     * @return array A two dimensional array, array('Identifier' => array('fieldId' => array('code' => '', 'label' =>
     *               '', 'cshKey' => '', 'cshLabel' => ''))
     */
    public function getAdditionalFields( array &$taskInfo, $task, SchedulerModuleController $schedulerModule ) {
        $additionalFields = array();

        return $additionalFields;
    }


    /**
     * Validates the additional fields' values
     *
     * @param array                     $submittedData   An array containing the data submitted by the add/edit task
     *                                                   form
     * @param SchedulerModuleController $schedulerModule Reference to the scheduler backend module
     *
     * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
     */
    public function validateAdditionalFields( array &$submittedData, SchedulerModuleController $schedulerModule ) {
        $submittedData[ $this->configuration['sysFolderPid'] ] = (int) $submittedData[ $this->configuration['sysFolderPid'] ];

        return true;
    }

    /**
     * Takes care of saving the additional fields' values in the task's object
     *
     * @param array                          $submittedData An array containing the data submitted by the add/edit task
     *                                                      form
     * @param tx_scheduler_Task|AbstractTask $task          Reference to the scheduler backend module
     */
    public function saveAdditionalFields( array $submittedData, AbstractTask $task ) {
        $configuration                        = $this->configuration;
        $task->$configuration['sysFolderPid'] = $submittedData[ $configuration['sysFolderPid'] ];
    }
}
