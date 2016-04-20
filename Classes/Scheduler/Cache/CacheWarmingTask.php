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

namespace DL\Yag\Scheduler\Cache;

use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\Configuration\Image\ResolutionConfigCollectionFactory;
use DL\Yag\Domain\FileSystem\ResolutionFileCache;
use DL\Yag\Domain\FileSystem\ResolutionFileCacheFactory;
use DL\Yag\Domain\Repository\ItemRepository;
use DL\Yag\Scheduler\AbstractTask;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * YAG Scheduler Task
 *
 * @package    YAG
 * @subpackage Scheduler
 */
class CacheWarmingTask extends AbstractTask {
    /**
     * @var ConfigurationManagerInterface
     */
    protected $configurationManager;


    /**
     * @var integer
     */
    protected $typoScriptPageUid = 1;


    /**
     * @var array
     */
    protected $selectedThemes;


    /**
     * @var integer
     */
    protected $imagesPerRun = 10;


    protected function initializeScheduler() {
        $this->configurationManager = $this->objectManager->get( 'TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface' );
    }


    /**
     * This is the main method that is called when a task is executed
     * It MUST be implemented by all classes inheriting from this one
     * Note that there is no error handling, errors and failures are expected
     * to be handled and logged by the client implementations.
     * Should return TRUE on successful execution, FALSE on error.
     *
     * @return boolean Returns TRUE on successful execution, FALSE on error
     */
    public function execute() {
        $selectedResolutionConfigCollection = $this->getSelectedResolutionConfigs();
        $itemRepository                     = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\ItemRepository' );
        /** @var $itemRepository ItemRepository */
        $resolutionFileCache = ResolutionFileCacheFactory::getInstance();
        /** @var  $resolutionFileCache ResolutionFileCache */
        $items = $itemRepository->findImagesWithUnRenderedResolutions( $selectedResolutionConfigCollection, $this->imagesPerRun );

        foreach ( $items as $item ) {
            $resolutionFileCache->buildResolutionFilesForItem( $item, $selectedResolutionConfigCollection );
            $this->objectManager->get( 'TYPO3\\CMS\\Extbase\\Persistence\\PersistenceManagerInterface' )->persistAll();
        }

        return true;
    }


    /**
     * @return ResolutionConfigCollection
     */
    protected function getSelectedResolutionConfigs() {
        $settings = $this->configurationManager->getConfiguration( ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'Yag', 'pi1' );

        ConfigurationBuilderFactory::injectSettings( $settings );
        $configurationBuilder               = ConfigurationBuilderFactory::getInstance( 'default', 'backend' );
        $resolutionConfigCollection         = ResolutionConfigCollectionFactory::getInstanceOfAllThemes( $configurationBuilder );
        $selectedResolutionConfigCollection = $resolutionConfigCollection->extractCollectionByThemeList( $this->selectedThemes );

        return $selectedResolutionConfigCollection;
    }


    /**
     * @return string
     */
    public function getAdditionalInformation() {
        $itemRepository = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\ItemRepository' );
        /** @var $itemRepository ItemRepository */

        $unRenderedCount = $itemRepository->countImagesWithUnRenderedResolutions( $this->getSelectedResolutionConfigs() );

        $totalItemsCount = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows(
            'uid',
            'tx_yag_domain_model_item'
        );

        $progress = $totalItemsCount == 0 ? 0 : ( 1 - ( $unRenderedCount / $totalItemsCount ) ) * 100;

        return sprintf( 'ImagesPerRun: %s. Themes: %s. Progress: %s', $this->imagesPerRun, implode( ', ', $this->selectedThemes ), number_format( $progress, 2 ) ) . '%';
    }


    /**
     * @param int $typoScriptPageUid
     */
    public function setTypoScriptPageUid( $typoScriptPageUid ) {
        $this->typoScriptPageUid = $typoScriptPageUid;
    }


    /**
     * @return int
     */
    public function getTypoScriptPageUid() {
        return $this->typoScriptPageUid;
    }

    /**
     * @param array $selectedThemes
     */
    public function setSelectedThemes( $selectedThemes ) {
        $this->selectedThemes = $selectedThemes;
    }

    /**
     * @return array
     */
    public function getSelectedThemes() {
        return $this->selectedThemes;
    }

    /**
     * @param int $imagesPerRun
     */
    public function setImagesPerRun( $imagesPerRun ) {
        $this->imagesPerRun = $imagesPerRun;
    }

    /**
     * @return int
     */
    public function getImagesPerRun() {
        return $this->imagesPerRun;
    }
}
