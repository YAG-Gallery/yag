<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011-2011 Michael Knoll <mimi@kaktusteam.de>
*  			Daniel Lienert <daniel@lienert.cc>
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
 * Controller for the Album object
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Controller_AlbumController extends Tx_Yag_Controller_AbstractController {

	/**
	 * Show action for album.
	 * Set the current album to the albumFilter
	 * 
	 * @param Tx_Yag_Domain_Model_Album $album
	 */
	public function showAction(Tx_Yag_Domain_Model_Album $album = NULL) {
			
		if ($album === NULL) {
			$album = $this->yagContext->getAlbum();
			
			if($album == NULL) {
				$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_yag_controller_album.noAlbumSelected', $this->extensionName),'',t3lib_FlashMessage::ERROR);
				$this->forward('index', 'Error');			
			}
		} else {
			$this->yagContext->setAlbum($album);
		}
		
		$extListDataBackend = $this->yagContext->getItemlistContext()->getDataBackend(); 
    	$extListDataBackend->getPagerCollection()->reset();
		$this->forward('list', 'ItemList');
	}



	/**
	 * Generic album list
	 * List output is defined by typoScript and source selection
	 *
	 * @return void
	 */
	public function listAction() {
		$extlistContext = $this->yagContext->getAlbumListContext();
		$extlistContext->getPagerCollection()->setItemsPerPage($this->configurationBuilder->buildAlbumListConfiguration()->getItemsPerPage());
		$extlistContext->getPagerCollection()->setItemCount($extlistContext->getDataBackend()->getTotalItemsCount());

		$this->view->assign('gallery', $this->yagContext->getGallery());
		$this->view->assign('listData', $extlistContext->getRenderedListData());
		$this->view->assign('pagerCollection', $extlistContext->getPagerCollection());
		$this->view->assign('pager', $extlistContext->getPagerCollection()->getPagerByIdentifier($this->configurationBuilder->buildAlbumListConfiguration()->getPagerIdentifier()));
	}


	
	/**
	 * Entry point for specific album mode 
	 * 
	 */
	public function showSingleAction() {
		$albumUid = $this->configurationBuilder->buildContextConfiguration()->getSelectedAlbumUid();
		$this->yagContext->setAlbumUid($albumUid);
		$this->forward('show');
	}


	/**
	 * Creates a new album
	 *
	 * @param Tx_Yag_Domain_Model_Gallery $gallery	  Gallery object to create album in
	 * @param Tx_Yag_Domain_Model_Album $newAlbum	  New album object in case of an error
	 * @return string  The rendered new action
	 * @dontvalidate $newAlbum
	 * @rbacNeedsAccess
	 * @rbacObject album
	 * @rbacAction create
	 */
	public function newAction(Tx_Yag_Domain_Model_Gallery $gallery = NULL, Tx_Yag_Domain_Model_Album $newAlbum = NULL) {
		if($newAlbum === NULL) $newAlbum = $this->objectManager->get('Tx_Yag_Domain_Model_Album');
		$selectableGalleries = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository')->findAll();

		$this->view->assign('selectableGalleries', $selectableGalleries);
		$this->view->assign('selectedGallery', $gallery);
		$this->view->assign('newAlbum', $newAlbum);
	}


	/**
	 * Adds a new album to repository
	 *
	 * @param Tx_Yag_Domain_Model_Album $newAlbum  New album to add
	 * @param Tx_Yag_Domain_Model_Gallery $gallery
	 * @return string  The rendered create action
	 * @rbacNeedsAccess
	 * @rbacObject album
	 * @rbacAction create
	 */
	public function createAction(Tx_Yag_Domain_Model_Album $newAlbum, Tx_Yag_Domain_Model_Gallery $gallery = NULL) {

		if ($gallery != NULL) {
			$gallery->addAlbum($newAlbum);
			$newAlbum->addGallery($gallery);

		} elseIf ($newAlbum->getGallery() != NULL) {
			// gallery has been set by editing form
			$gallery = $newAlbum->getGallery();

		} else {
			$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_yag_controller_album.albumCreateErrorNoGallery', $this->extensionName), '', t3lib_FlashMessage::ERROR);
			$this->redirect('create');
		}

		$gallery->addAlbum($newAlbum);
		$this->yagContext->setGallery($gallery);

		$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_yag_controller_album.albumCreated', $this->extensionName), '', t3lib_FlashMessage::OK);

		$this->albumRepository->add($newAlbum);
		$this->persistenceManager->persistAll();

		$this->redirect('index', 'Gallery');
	}



	/**
	 * Delete action for deleting an album
	 *
	 * @param Tx_Yag_Domain_Model_Album $album album that should be deleted
	 * @return string	The rendered delete action
	 * @rbacNeedsAccess
	 * @rbacObject album
	 * @rbacAction delete
	 */
	public function deleteAction(Tx_Yag_Domain_Model_Album $album) {
		$gallery = $album->getGallery();
		$album->delete(TRUE);

		$this->flashMessageContainer->add(
			Tx_Extbase_Utility_Localization::translate('tx_yag_controller_album.deletesuccessfull', $this->extensionName),
			'',
			t3lib_FlashMessage::OK
		);

		$this->yagContext->setGallery($gallery);
		$this->redirect('index', 'Gallery');
	}


	/**
	 * Action for adding new items to an existing album
	 *
	 * @param Tx_Yag_Domain_Model_Album $album Album to add items to
	 * @rbacNeedsAccess
	 * @rbacObject album
	 * @rbacAction edit
	 */
	public function addItemsAction(Tx_Yag_Domain_Model_Album $album) {
		$this->view->assign('zipImportAvailable', Tx_Yag_Domain_Import_ZipImporter_ImporterBuilder::checkIfImporterIsAvailable());
		$this->view->assign('album', $album);
	}


	/**
	 * Updates an existing Album and forwards to the index action afterwards.
	 *
	 * @param Tx_Yag_Domain_Model_Album $album the Album to display
	 * @return string A form to edit a Album
	 * @rbacNeedsAccess
	 * @rbacObject album
	 * @rbacAction edit
	 */
	public function editAction(Tx_Yag_Domain_Model_Album $album) {
		$selectableGalleries = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository')->findAll();

		$this->view->assign('album', $album);
		$this->view->assign('selectableGalleries', $selectableGalleries);
		$this->view->assign('selectedGallery', $album->getGallery());
	}


	/**
	 * Action for updating an album after it has been edited
	 *
	 * @param Tx_Yag_Domain_Model_Album $album
	 * @rbacNeedsAccess
	 * @rbacObject album
	 * @rbacAction edit
	 */
	public function updateAction(Tx_Yag_Domain_Model_Album $album) {
		$this->albumRepository->update($album);
		$this->flashMessageContainer->add(
			Tx_Extbase_Utility_Localization::translate('tx_yag_controller_album.updatesuccessfull', $this->extensionName),
			'',
			t3lib_FlashMessage::OK
		);
		$this->forward('show');
	}



    /**
     * Sets sorting of whole album to given sorting parameter with given sorting direction
     *
     * @param Tx_Yag_Domain_Model_Album $album
     * @param string $sortingField
     * @param int $sortingDirection (1 = ASC, -1 = DESC)
     * @rbacNeedsAccess
     * @rbacObject album
     * @rbacAction update
     * @return void
     */
    public function updateSortingAction(Tx_Yag_Domain_Model_Album $album, $sortingField, $sortingDirection) {
        $direction = ($sortingDirection == 1 ? Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING : Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING);
        $album->updateSorting($sortingField, $direction);
        $this->albumRepository->update($album);
        $this->flashMessageContainer->add(
            Tx_Extbase_Utility_Localization::translate('tx_yag_controller_album.sortingChanged', $this->extensionName),
            '',
            t3lib_FlashMessage::OK
        );
        $this->objectManager->get('Tx_Extbase_Persistence_Manager')->persistAll();
        $this->forward('list','ItemList');
    }


	/**
	 * Action handles bulk update of album edit
	 *
	 * @rbacNeedsAccess
	 * @rbacObject item
	 * @rbacAction update
	 */
	public function bulkUpdateAction() {

		$postVars = t3lib_div::_POST('tx_yag_web_yagtxyagm1');

		// Somehow, mapping does not seem to work here - so we do it manually
		$gallery = $this->galleryRepository->findByUid($postVars['gallery']['uid']);
		/* @var $gallery Tx_Yag_Domain_Model_Gallery */

		// Do we have to change thumb for album?
		if ($gallery->getThumbAlbum()) {
			// We have a thumb for gallery and probably need to update it
			if ($gallery->getThumbAlbum()->getUid() != $postVars['gallery']['thumb']) {
				$thumbAlbum = $this->albumRepository->findByUid($postVars['gallery']['thumb']);
				if ($thumbAlbum != NULL) {
					$gallery->setThumbAlbum($thumbAlbum);
					$this->galleryRepository->update($gallery);
				}
			}
		} else {
			// We don't have a thumb for gallery - do we get a new one?
			$thumbAlbum = $this->albumRepository->findByUid($postVars['gallery']['thumb']);
			if ($thumbAlbum != NULL) {
				$gallery->setThumbAlbum($thumbAlbum);
				$this->galleryRepository->update($gallery);
			}
		}

		// Delete albums that are marked for deletion
		foreach ($postVars['albumsToBeDeleted'] as $albumUid => $value) {
			if (intval($value) === 1) {
				$album = $this->albumRepository->findByUid($albumUid);
				/* @var $album Tx_Yag_Domain_Model_Album */
				$album->delete();
			}
		}

		// Update each album that is associated to item
		foreach ($gallery->getAlbums() as $album) {
			/* @var $album Tx_Yag_Domain_Model_Album */
			$albumUid = $album->getUid();
			$albumArray = $postVars['gallery']['album'][$albumUid];
			if (is_array($albumArray)) {
				$album->setName($albumArray['name']);
				$album->setDescription($albumArray['description']);
				$album->setGallery($this->galleryRepository->findByUid(intval($albumArray['gallery']['__identity'])));
				$this->albumRepository->update($album);
			}
		}

		$this->persistenceManager->persistAll();

		$this->flashMessageContainer->add(
			Tx_Extbase_Utility_Localization::translate('tx_yag_controller_album.albumsUpdated', $this->extensionName),
			'',
			t3lib_FlashMessage::OK
		);

		/* TODO try to find out, why this does not seem to work with forward. Somehow the list data does not seem to be updated.
			So we have an album in an "old" gallery although it's been moved to another gallery. */
		$this->redirect('index', 'Gallery', NULL, array('gallery' => $gallery));
	}
    
}
?>