<?php
namespace YAG\Yag\Scheduler\Importer;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Daniel Lienert <daniel@lienert.cc>
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

/**
 * SQL Runner Task Additional Fields
 *
 * @package YAG
 * @subpackage Scheduler
 */
class DirectoryImporterTaskAdditionalFields extends \YAG\Yag\Scheduler\AbstractAdditionalFieldProvider {



	/**
	 * Gets additional fields to render in the form to add/edit a task
	 *
	 * @param array $taskInfo Values of the fields from the add/edit task form
	 * @param DirectoryImporterTask $task The task object being edited. Null when adding a task!
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the scheduler backend module
	 * @return array A two dimensional array, array('Identifier' => array('fieldId' => array('code' => '', 'label' => '', 'cshKey' => '', 'cshLabel' => ''))
	 */
	public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule) {

		if($task == NULL) {
			$task = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\YAG\\Yag\\Scheduler\\Importer\\DirectoryImporterTask');
		}

		return array(
			'storageSysFolder' => array(
				'label' => 'YAG SysFolder:',
				'code'  => $this->getFieldHTML('Import/StorageSysFolderSelection.html',
						array('storageSysFolder' => $task->getStorageSysfolder(),
							'selectableSysFolders' => $this->getSelectableSysFolders()))
			),
			'importDirectoryRoot' => array(
				'label' => 'Import Directory Root:',
				'code'  => $this->getFieldHTML('Import/ImportDirectoryRoot.html',
						array('importDirectoryRoot' => $task->getImportDirectoryRoot()))
			)
		);
	}



	/**
	 * @return array
	 */
	protected function getSelectableSysFolders() {
		$pidDetector = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('Tx_Yag_Utility_PidDetector'); /** @var Tx_Yag_Utility_PidDetector $pidDetector */
		$pageRecords = $pidDetector->getPageRecords();

		$selectableSysFolders = array();

		foreach($pageRecords as $pageRecord) {
			$selectableSysFolders[$pageRecord['uid']] = $pageRecord['title'];
		}

		return $selectableSysFolders;
	}


	/**
	 * Validates the additional fields' values
	 *
	 * @param array $submittedData An array containing the data submitted by the add/edit task form
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the scheduler backend module
	 * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
	 */
	public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule) {

		$submitedRootDirectory = trim($submittedData['yagImportDirectoryRoot']);

		if($submitedRootDirectory == '') return FALSE;
		if(!is_dir($submitedRootDirectory) || !is_readable($submitedRootDirectory)) return FALSE;

		if((int) $submittedData['yagSelectedSysFolder'] <= 0) return FALSE;
	}


	/**
	 * @param array $submittedData
	 * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task
	 * @throws \InvalidArgumentException
	 */
	public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task) {
		if (!$task instanceof DirectoryImporterTask) {
			throw new \InvalidArgumentException('Task not of type DirectoryImporterTask', 1403364443);
		}

		$task->setImportDirectoryRoot(trim($submittedData['yagImportDirectoryRoot']));
		$task->setStorageSysFolder((int) $submittedData['yagSelectedSysFolder']);
	}


}
?>