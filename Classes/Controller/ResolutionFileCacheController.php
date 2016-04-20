<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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

namespace DL\Yag\Controller;

use DL\Yag\Domain\Configuration\Image\ResolutionConfigCollectionFactory;
use DL\Yag\Domain\FileSystem\ResolutionFileCache;
use DL\Yag\Domain\FileSystem\ResolutionFileCacheFactory;
use DL\Yag\Domain\Model\Item;
use DL\Yag\Domain\Repository\ItemRepository;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Controller for Resolution File Cache
 *
 * @package Controller
 * @author  Daniel Lienert <typo3@lienert.cc>
 */
class ResolutionFileCacheController extends AbstractController {
    /**
     * @var \DL\Yag\Domain\FileSystem\ResolutionFileCache
     */
    protected $resolutionFileCache;


    /**
     * @return void
     */
    public function postInitializeAction() {
        $this->resolutionFileCache = ResolutionFileCacheFactory::getInstance();
    }


    /**
     * Render a message if no settings ar available
     * @return string   The rendered delete action
     * @rbacNeedsAccess
     * @rbacObject ResolutionFileCache
     * @rbacAction delete
     */
    public function clearResolutionFileCacheAction() {
        $this->resolutionFileCache->clear();
        $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_resolutionFileCache.cacheSuccessfullyCleared', $this->extensionName ) );

        $this->forward( 'maintenanceOverview', 'Backend' );
    }


    /**
     * Build all resolutions for all images
     */
    public function buildAllItemResolutionsAction() {
        $itemRepository = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\ItemRepository' );
        /* @var $itemRepository ItemRepository */
        $items = $itemRepository->findAll();

        foreach ( $items as $item ) {
            $this->resolutionFileCache->buildAllResolutionFilesForItem( $item );
        }
    }


    /**
     * @param Item $item
     *
     * @return void
     */
    public function buildResolutionByConfigurationAction( Item $item = null ) {
        $selectedThemes = ResolutionConfigCollectionFactory::getInstanceOfRegistrySelectedThemes( $this->configurationBuilder );

        if ( $item != null ) {
            $this->resolutionFileCache->buildResolutionFilesForItem( $item, $selectedThemes );

            $this->objectManager->get( 'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager' )->persistAll();
            $returnArray = $this->buildReturnArray( $item );
        } else {
            $returnArray = array( 'nextItemUid' => 0 );
        }

        ob_clean();

        echo json_encode( $returnArray );
        exit();
    }


    /**
     * @param Item $item
     *
     * @return array
     */
    protected function buildReturnArray( Item $item ) {

        // The backend thumb
        $resolutionConfig   = $this->configurationBuilder->buildThemeConfiguration()->getResolutionConfigCollection()->getResolutionConfig( 'icon64' );
        $itemFileResolution = $this->resolutionFileCache->getItemFileResolutionPathByConfiguration( $item, $resolutionConfig );

        // The next image uid
        $nextItem    = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\ItemRepository' )->getItemsAfterThisItem( $item );
        $nextItemUid = 0;
        if ( $nextItem ) {
            $nextItemUid = $nextItem->getUid();
        }

        $returnArray = array(
            'thumbPath'   => $itemFileResolution->getPath(),
            'thumbHeight' => $itemFileResolution->getHeight(),
            'thumbWidth'  => $itemFileResolution->getWidth(),
            'nextItemUid' => $nextItemUid
        );

        return $returnArray;
    }
}
