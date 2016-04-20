<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011-2011 Michael Knoll <mimi@kaktusteam.de>
 *            Daniel Lienert <typo3@lienert.cc>
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

namespace DL\Yag\Controller;

use DL\Yag\Domain\Model\Gallery;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Controller for gallery
 *
 * @package Controller
 * @author  Daniel Lienert <typo3@lienert.cc>
 * @author  Michael Knoll <mimi@kaktusteam.de>
 */
class GalleryController extends AbstractController {
    /**
     * Show list of galleries
     *
     * @return string Rendered list of galleries action
     */
    public function listAction() {
        // Reset all selections in yag context
        $extlistContext = $this->yagContext->getGalleryListContext();
        $extlistContext->getPagerCollection()->setItemsPerPage( $this->configurationBuilder->buildGalleryListConfiguration()->getItemsPerPage() );
        $extlistContext->getPagerCollection()->setItemCount( $extlistContext->getDataBackend()->getTotalItemsCount() );

        $this->view->assign( 'listData', $extlistContext->getRenderedListData() );
        $this->view->assign( 'pagerCollection', $extlistContext->getPagerCollection() );
        $this->view->assign( 'pager', $extlistContext->getPagerCollection()->getPagerByIdentifier( $this->configurationBuilder->buildGalleryListConfiguration()->getPagerIdentifier() ) );
        $this->view->assign( 'pidDetector', $this->pidDetector );
    }


    /**
     * Show the albums of the gallery
     *
     * @param Gallery $gallery Gallery to be rendered
     *
     * @return string Rendered Index action
     */
    public function indexAction( Gallery $gallery = null ) {
        $extlistContext = $this->yagContext->getAlbumListContext();
        $extlistContext->getPagerCollection()->setItemsPerPage( $this->configurationBuilder->buildAlbumListConfiguration()->getItemsPerPage() );
        $extlistContext->getPagerCollection()->setItemCount( $extlistContext->getDataBackend()->getTotalItemsCount() );

        if ( $gallery === null ) {
            // If we do not get a gallery from Request, we get it from context
            $gallery = $this->yagContext->getGallery();
        } else {
            $this->yagContext->setGallery( $gallery );
        }

        if ( $gallery === null ) {
            $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_gallery.noGallerySelected', $this->extensionName ), '', FlashMessage::ERROR );
            $this->forward( 'index', 'Error' );
        }

        $this->view->assign( 'gallery', $gallery );
        $this->view->assign( 'galleries', $this->galleryRepository->findAll() );
        $this->view->assign( 'listData', $extlistContext->getRenderedListData() );
        $this->view->assign( 'pagerCollection', $extlistContext->getPagerCollection() );
        $this->view->assign( 'pager', $extlistContext->getPagerCollection()->getPagerByIdentifier( $this->configurationBuilder->buildAlbumListConfiguration()->getPagerIdentifier() ) );
    }


    /**
     * Entry point for show specific gallery mode
     *
     * @return string Rendered action
     */
    public function showSingleAction() {
        $galleryUid = $this->configurationBuilder->buildContextConfiguration()->getSelectedGalleryUid();
        $this->yagContext->setGalleryUid( $galleryUid );
        $this->forward( 'index' );
    }


    /**
     * Edit action for gallery object
     *
     * @param Gallery $gallery Gallery to be edited
     *
     * @return string The rendered edit action
     * @dontvalidate $gallery
     * @rbacNeedsAccess
     * @rbacObject gallery
     * @rbacAction edit
     */
    public function editAction( Gallery $gallery ) {
        $this->view->assign( 'gallery', $gallery );
    }


    /**
     * Update action for gallery object
     *
     * @param Gallery $gallery Gallery to be updated
     *
     * @return string The rendered update action
     * @rbacNeedsAccess
     * @rbacObject gallery
     * @rbacAction edit
     */
    public function updateAction( Gallery $gallery ) {
        $this->galleryRepository->update( $gallery );
        $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_gallery.gallerySuccessfullyUpdated', $this->extensionName ) );
        $this->redirect( 'list' );
    }


    /**
     * Delete action for deleting a gallery
     *
     * @param Gallery $gallery Gallery object to be deleted
     *
     * @rbacNeedsAccess
     * @rbacObject gallery
     * @rbacAction delete
     */
    public function deleteAction( Gallery $gallery ) {
        $gallery->delete();
        $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_gallery.gallerySuccessfullyDeleted', $this->extensionName, array( $gallery->getName() ) ) );
        $this->galleryRepository->syncTranslatedGalleries();
        $this->redirect( 'list' );
    }


    /**
     * new action
     *
     * @param Gallery $gallery
     *
     * @return string The rendered new action
     * @rbacNeedsAccess
     * @rbacObject gallery
     * @rbacAction create
     */
    public function newAction( Gallery $gallery = null ) {
        if ( $gallery === null ) {
            $gallery = $this->objectManager->get( 'DL\\Yag\\Domain\\Model\\Gallery' );
        }

        $this->view->assign( 'gallery', $gallery );
    }


    /**
     * Create  gallery action
     *
     * @param Gallery $gallery
     *
     * @return string The rendered create action
     * @rbacNeedsAccess
     * @rbacObject gallery
     * @rbacAction create
     */
    public function createAction( Gallery $gallery ) {
        $this->galleryRepository->add( $gallery );
        $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_gallery.gallerySuccessfullyCreated', $this->extensionName ) );
        $this->redirect( 'list' );
    }
}
