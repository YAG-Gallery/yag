<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2014 Daniel Lienert <typo3@lienert.cc>
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

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Controller for Backend Module actions
 *
 * @package Controller
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class Tx_Yag_Controller_BackendController extends Tx_Yag_Controller_AbstractController
{
    /**
     * @var Tx_Yag_Utility_DBUpgrade
     */
    protected $dbUpgradeUtility;



    /**
     * @param Tx_Yag_Utility_DBUpgrade $dbUpgradeUtility
     */
    public function injectUpgradeUtility(Tx_Yag_Utility_DBUpgrade $dbUpgradeUtility)
    {
        $this->dbUpgradeUtility = $dbUpgradeUtility;
    }



    /**
     * Render a message if no settings are available
     */
    public function settingsNotAvailableAction()
    {
        $this->addFlashMessage(
            LocalizationUtility::translate('tx_yag_controller_backend_settingsNotAvailable.infoText', $this->extensionName),
            LocalizationUtility::translate('tx_yag_controller_backend_settingsNotAvailable.headline', $this->extensionName),
            FlashMessage::INFO);
    }



    /**
     * Render a flash message if someone tries to call the module on PID 0
     */
    public function noGalleryIsPosibleOnPIDZeroAction()
    {
        $this->addFlashMessage(
        LocalizationUtility::translate('tx_yag_controller_backend_noGalleryOnPIDZero.infoText', $this->extensionName),
        LocalizationUtility::translate('tx_yag_controller_backend_noGalleryOnPIDZero.headline', $this->extensionName),
        FlashMessage::INFO);
    }



    /**
     * Render a message if entry in ext_localconf is not aviable
     *
     */
    public function extConfSettingsNotAvailableAction()
    {
        $this->addFlashMessage(
        LocalizationUtility::translate('tx_yag_controller_backend_extConfSettingsNotAvailable.infoText', $this->extensionName),
        LocalizationUtility::translate('tx_yag_controller_backend_extConfSettingsNotAvailable.headline', $this->extensionName),
        FlashMessage::INFO);
    }



    /**
     * Show the maintenance overview
     */
    public function maintenanceOverviewAction()
    {

        /**
         * Check if an update is available
         */
        if ($this->dbUpgradeUtility->getAvailableUpdateMethod() != '') {
            $this->forward('dbUpdateNeeded');
        }

        $itemRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository'); /* @var $itemRepository Tx_Yag_Domain_Repository_ItemRepository */

        $galleryCount = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository')->countAll();
        $albumCount = $this->objectManager->get('Tx_Yag_Domain_Repository_AlbumRepository')->countAll();

        $itemCount = $itemRepository->countAll();
        $itemSizeSum = \TYPO3\CMS\Core\Utility\GeneralUtility::formatSize($itemRepository->getItemSizeSum());
        $includedCount = $this->objectManager->get('Tx_Yag_Domain_Repository_Extern_TTContentRepository')->countAllYagInstances();

        $firstItem = $itemRepository->getItemsAfterThisItem();
        if ($firstItem) {
            $firstItemUid = $firstItem->getUid();
        }



        $resolutionFileCache = Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance();

        $this->view->assign('folderStatistics', array(
            'galleryCount' => $galleryCount,
            'albumCount' => $albumCount,
            'itemCount' => $itemCount,
        ));

        $this->view->assign('globalStatistics', array(
            'show' => $GLOBALS['BE_USER']->isAdmin(),
            'itemSizeSum' => $itemSizeSum,
        ));

        $this->view->assign('firstItemUid', $firstItemUid);
        $this->view->assign('includedCount', $includedCount);

        $this->view->assign('resolutionFileCache', $resolutionFileCache);
    }



    /**
     * Show the database update form
     */
    public function dbUpdateNeededAction()
    {
        $this->view->assign('currentAppVersion', $this->dbUpgradeUtility->getCurrentAppVersion());
        $this->view->assign('currentDatabaseVersion', $this->dbUpgradeUtility->getCurrentDatabaseVersion());
        $this->view->assign('updateMethod', $this->dbUpgradeUtility->getAvailableUpdateMethod());
    }



    /**
     * Do the upgrade
     */
    public function doDbUpdateAction()
    {
        $arguments = $this->controllerContext->getRequest()->getArguments();
        $result = $this->dbUpgradeUtility->doUpdate($arguments);

        if ($result === true) {
            $this->addFlashMessage('Database update successful!', '', FlashMessage::OK);
        } else {
            $this->addFlashMessage('Error while updating the database!', '', FlashMessage::ERROR);
        }

        $this->forward('maintenanceOverview');
    }



    /**
     * Clear the cache of all pages where yag is included
     */
    public function clearAllPageCacheAction()
    {
        $this->objectManager->get('Tx_Yag_PageCache_PageCacheManager')->clearAll();
        $this->addFlashMessage(LocalizationUtility::translate('tx_yag_controller_backend_MaintenanceOverview.pageCacheSuccessfullyCleared', $this->extensionName));
        $this->forward('maintenanceOverview');
    }



    /**
     * Mark a page as YAG SysFolder
     *
     * @param integer $pid
     */
    public function markPageAsYagSysFolderAction($pid)
    {
        $pageRepository = $this->objectManager->get('Tx_PtExtbase_Domain_Repository_PageRepository'); /** @var $pageRepository Tx_PtExtbase_Domain_Repository_PageRepository */
        $page = $pageRepository->findOneByUid($pid); /** @var $page Tx_PtExtbase_Domain_Model_Page */

        if ($page instanceof Tx_PtExtbase_Domain_Model_Page) {
            $page->setModule('yag');
            $pageRepository->update($page);

            $this->addFlashMessage(LocalizationUtility::translate('tx_yag_controller_backend.pageSuccessfullyMarkedAsYAGFolder', $this->extensionName));
        } else {
            $this->addFlashMessage(LocalizationUtility::translate('tx_yag_controller_backend.pageNotFound', $this->extensionName));
        }

        $this->redirect('list', 'Gallery');
    }
}
