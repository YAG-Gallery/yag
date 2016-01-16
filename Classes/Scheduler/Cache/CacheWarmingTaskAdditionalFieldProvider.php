<?php
namespace YAG\Yag\Scheduler\Cache;

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


/**
 * SQL Runner Task Additional Fields
 *
 * @package YAG
 * @subpackage Scheduler
 */
class CacheWarmingTaskAdditionalFieldProvider extends \YAG\Yag\Scheduler\AbstractAdditionalFieldProvider
{
    /**
     * Gets additional fields to render in the form to add/edit a task
     *
     * @param array $taskInfo Values of the fields from the add/edit task form
     * @param \YAG\Yag\Scheduler\Cache\CacheWarmingTask $task
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the scheduler backend module
     * @return array A two dimensional array, array('Identifier' => array('fieldId' => array('code' => '', 'label' => '', 'cshKey' => '', 'cshLabel' => ''))
     */
    public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule)
    {
        $typoScriptPageUid = 1;
        $selectedThemes = array();
        $imagesPerRun = 10;

        if ($task !== null) {
            $typoScriptPageUid = $task->getTyposcriptPageUid();
            $selectedThemes = $task->getSelectedThemes();
            $imagesPerRun = $task->getImagesPerRun();
        }



        $themes = $this->getSelectableThemes();

        return array(
            'typoScriptPageUid' => array(
                'label' => 'Page Id to read TypoScript settings from:',
                'code'  => $this->getFieldHTML('CacheWarming/PageUid.html', array('typoScriptPageUid' => $typoScriptPageUid))
            ),
            'themeSelection' => array(
                'label' => 'Themes to render:',
                'code'  => $this->getFieldHTML('CacheWarming/ThemeSelection.html', array('selectableThemes' => $themes, 'selected' => $selectedThemes))
            ),
            'imagesPerRun' => array(
                'label' => 'Images to process per run:',
                'code'  => $this->getFieldHTML('CacheWarming/ImagesPerRun.html', array('imagesPerRun' => $imagesPerRun))
            )
        );
    }


    protected function getSelectableThemes()
    {
        $configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')
            ->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface'); /** @var $configurationManager \TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager */

        $settings = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'Yag', 'pi1');

        $themes = \Tx_PtExtbase_Utility_NameSpace::getArrayContentByArrayAndNamespace($settings, 'themes');

        $selectableThemes = array();

        foreach ($themes as $themeIdentifier => $theme) {
            $themeTitle = (array_key_exists('title', $theme)) ? $theme['title'] : $themeIdentifier;
            $selectableThemes[$themeIdentifier] = $themeTitle;
        }

        return $selectableThemes;
    }


    /**
     * Validates the additional fields' values
     *
     * @param array $submittedData An array containing the data submitted by the add/edit task form
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the scheduler backend module
     * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
     */
    public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule)
    {
        if ((int) $submittedData['yagTypoScriptPageUid'] <= 0) {
            return false;
        }
        if ((int) $submittedData['yagImagesPerRun'] <= 0) {
            return false;
        }
        if (!is_array($submittedData['yagSelectedThemes']) || count($submittedData['yagSelectedThemes']) === 0) {
            return false;
        }

        return true;
    }


    /**
     * Takes care of saving the additional fields' values in the task's object
     *
     * @param array $submittedData An array containing the data submitted by the add/edit task form
     * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task Reference to the scheduler backend module
     * @throws \InvalidArgumentException
     * @return void
     */
    public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task)
    {
        if (!$task instanceof CacheWarmingTask) {
            throw new \InvalidArgumentException('Task not of type CacheWarmingTask', 1384275697);
        }

        $task->setTypoScriptPageUid((int) $submittedData['yagTypoScriptPageUid']);
        $task->setSelectedThemes(array_values($submittedData['yagSelectedThemes']));
        $task->setImagesPerRun((int) $submittedData['yagImagesPerRun']);
    }
}
