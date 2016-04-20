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

use DL\Yag\Domain\Import\ZipImporter\ImporterBuilder;
use DL\Yag\Domain\Model\Album;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Controller for the Album object
 *
 * @package Controller
 * @author  Michael Knoll <mimi@kaktusteam.de>
 * @author  Daniel Lienert <typo3@lienert.cc>
 */
class AlbumController extends AbstractController {
    /**
     * Show action for album.
     * Set the current album to the albumFilter
     *
     * @param Album $album
     */
    public function showAction( Album $album = null ) {
        if ( $album === null ) {
            $album = $this->yagContext->getAlbum();

            if ( $album == null ) {
                $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_album.noAlbumSelected', $this->extensionName ), '', FlashMessage::ERROR );
                $this->forward( 'index', 'Error' );
            }
        } else {
            $this->yagContext->setAlbum( $album );
        }

        $extListDataBackend = $this->yagContext->getItemlistContext()->getDataBackend();
        $extListDataBackend->getPagerCollection()->reset();
        $this->forward( 'list', 'ItemList' );
    }


    /**
     * Generic album list
     * List output is defined by typoScript and source selection
     *
     * @return void
     */
    public function listAction() {
        $extlistContext = $this->yagContext->getAlbumListContext();
        $extlistContext->getPagerCollection()->setItemsPerPage( $this->configurationBuilder->buildAlbumListConfiguration()->getItemsPerPage() );
        $extlistContext->getPagerCollection()->setItemCount( $extlistContext->getDataBackend()->getTotalItemsCount() );

        $this->view->assign( 'gallery', $this->yagContext->getGallery() );
        $this->view->assign( 'listData', $extlistContext->getRenderedListData() );
        $this->view->assign( 'pagerCollection', $extlistContext->getPagerCollection() );
        $this->view->assign( 'pager', $extlistContext->getPagerCollection()->getPagerByIdentifier( $this->configurationBuilder->buildAlbumListConfiguration()->getPagerIdentifier() ) );
    }


    /**
     * Entry point for specific album mode
     *
     */
    public function showSingleAction() {
        $albumUid = $this->configurationBuilder->buildContextConfiguration()->getSelectedAlbumUid();
        $this->yagContext->setAlbumUid( $albumUid );
        $this->forward( 'show' );
    }


    /**
     * Creates a new album
     *
     * @param Gallery $gallery  Gallery object to create album in
     * @param Album   $newAlbum New album object in case of an error
     *
     * @return string  The rendered new action
     * @dontvalidate $newAlbum
     * @rbacNeedsAccess
     * @rbacObject album
     * @rbacAction create
     */
    public function newAction( Gallery $gallery = null, Album $newAlbum = null ) {
        if ( $newAlbum === null ) {
            $newAlbum = $this->objectManager->get( 'DL\\Yag\\Domain\\Model\\Album' );
        }
        $selectableGalleries = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\GalleryRepository' )->findAll();

        $this->view->assign( 'selectableGalleries', $selectableGalleries );
        $this->view->assign( 'selectedGallery', $gallery );
        $this->view->assign( 'newAlbum', $newAlbum );
    }


    /**
     * Adds a new album to repository
     *
     * @param Album   $newAlbum New album to add
     * @param Gallery $gallery
     *
     * @return string  The rendered create action
     * @rbacNeedsAccess
     * @rbacObject album
     * @rbacAction create
     */
    public function createAction( Album $newAlbum, Gallery $gallery = null ) {
        if ( $gallery != null ) {
            $gallery->addAlbum( $newAlbum );
            $newAlbum->addGallery( $gallery );
        } elseif ( $newAlbum->getGallery() != null ) {
            // gallery has been set by editing form
            $gallery = $newAlbum->getGallery();
        } else {
            $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_album.albumCreateErrorNoGallery', $this->extensionName ), '', FlashMessage::ERROR );
            $this->redirect( 'create' );
        }

        $gallery->addAlbum( $newAlbum );
        $this->yagContext->setGallery( $gallery );

        $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_album.albumCreated', $this->extensionName ), '', FlashMessage::OK );

        $this->albumRepository->add( $newAlbum );
        $this->persistenceManager->persistAll();

        $this->redirect( 'index', 'Gallery' );
    }


    /**
     * Delete action for deleting an album
     *
     * @param Album $album album that should be deleted
     *
     * @return string    The rendered delete action
     * @rbacNeedsAccess
     * @rbacObject album
     * @rbacAction delete
     */
    public function deleteAction( Album $album ) {
        $gallery = $album->getGallery();
        $album->delete( true );

        $this->albumRepository->syncTranslatedAlbums();
        $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_album.deletesuccessfull', $this->extensionName ), '', FlashMessage::OK );

        $this->yagContext->setGallery( $gallery );
        $this->redirect( 'index', 'Gallery' );
    }


    /**
     * Action for adding new items to an existing album
     *
     * @param Album $album Album to add items to
     *
     * @rbacNeedsAccess
     * @rbacObject album
     * @rbacAction edit
     */
    public function addItemsAction( Album $album ) {
        $this->view->assign( 'zipImportAvailable', ImporterBuilder::checkIfImporterIsAvailable() );
        $this->view->assign( 'album', $album );
    }


    /**
     * Updates an existing Album and forwards to the index action afterwards.
     *
     * @param Album $album the Album to display
     *
     * @return string A form to edit a Album
     * @rbacNeedsAccess
     * @rbacObject album
     * @rbacAction edit
     */
    public function editAction( Album $album ) {
        $selectableGalleries = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\GalleryRepository' )->findAll();

        $this->view->assign( 'album', $album );
        $this->view->assign( 'selectableGalleries', $selectableGalleries );
        $this->view->assign( 'selectedGallery', $album->getGallery() );
    }


    /**
     * Action for updating an album after it has been edited
     *
     * @param Album $album
     *
     * @rbacNeedsAccess
     * @rbacObject album
     * @rbacAction edit
     */
    public function updateAction( Album $album ) {
        $this->albumRepository->update( $album );
        $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_album.updatesuccessfull', $this->extensionName ), '', FlashMessage::OK );
        $this->forward( 'show' );
    }


    /**
     * Sets sorting of whole album to given sorting parameter with given sorting direction
     *
     * @param Album  $album
     * @param string $sortingField
     * @param int    $sortingDirection (1 = ASC, -1 = DESC)
     *
     * @rbacNeedsAccess
     * @rbacObject album
     * @rbacAction update
     * @return void
     */
    public function updateSortingAction( Album $album, $sortingField, $sortingDirection ) {
        $direction = ( $sortingDirection == 1 ? QueryInterface::ORDER_ASCENDING : QueryInterface::ORDER_DESCENDING );
        $album->updateSorting( $sortingField, $direction );
        $this->albumRepository->update( $album );

        $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_album.sortingChanged', $this->extensionName ), '', FlashMessage::OK );

        $this->objectManager->get( 'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager' )->persistAll();

        $this->albumRepository->syncTranslatedAlbums();

        $this->forward( 'list', 'ItemList' );
    }


    /**
     * Action handles bulk update of album edit
     *
     * @rbacNeedsAccess
     * @rbacObject item
     * @rbacAction update
     */
    public function bulkUpdateAction() {
        $postVars = GeneralUtility::_POST( 'tx_yag_web_yagtxyagm1' );

        // Somehow, mapping does not seem to work here - so we do it manually
        $gallery = $this->galleryRepository->findByUid( $postVars['gallery']['uid'] );
        /* @var $gallery Gallery */

        // Do we have to change thumb for album?
        if ( $gallery->getThumbAlbum() ) {
            // We have a thumb for gallery and probably need to update it
            if ( $gallery->getThumbAlbum()->getUid() != $postVars['gallery']['thumb'] ) {
                $thumbAlbum = $this->albumRepository->findByUid( $postVars['gallery']['thumb'] );
                if ( $thumbAlbum != null ) {
                    $gallery->setThumbAlbum( $thumbAlbum );
                    $this->galleryRepository->update( $gallery );
                }
            }
        } else {
            // We don't have a thumb for gallery - do we get a new one?
            $thumbAlbum = $this->albumRepository->findByUid( $postVars['gallery']['thumb'] );
            if ( $thumbAlbum != null ) {
                $gallery->setThumbAlbum( $thumbAlbum );
                $this->galleryRepository->update( $gallery );
            }
        }

        // Delete albums that are marked for deletion
        foreach ( $postVars['albumsToBeDeleted'] as $albumUid => $value ) {
            if ( intval( $value ) === 1 ) {
                $album = $this->albumRepository->findByUid( $albumUid );
                /* @var $album Album */
                $album->delete();
            }
        }

        // Update each album that is associated to item
        foreach ( $gallery->getAlbums() as $album ) {
            /* @var $album Album */
            $albumUid   = $album->getUid();
            $albumArray = $postVars['gallery']['album'][ $albumUid ];
            if ( is_array( $albumArray ) ) {
                $album->setName( $albumArray['name'] );
                $album->setDescription( $albumArray['description'] );
                $album->setGallery( $this->galleryRepository->findByUid( intval( $albumArray['gallery']['__identity'] ) ) );
                $this->albumRepository->update( $album );
            }
        }

        $this->persistenceManager->persistAll();

        $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_controller_album.albumsUpdated', $this->extensionName ), '', FlashMessage::OK );

        /* TODO try to find out, why this does not seem to work with forward. Somehow the list data does not seem to be updated.
            So we have an album in an "old" gallery although it's been moved to another gallery. */
        $this->redirect( 'index', 'Gallery', null, array( 'gallery' => $gallery ) );
    }
}
