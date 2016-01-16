<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Class implements an controller for importing images from a zip archive
 * 
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_ZipImportController extends Tx_Yag_Controller_AbstractController
{
    /**
     * @inject
     * @var Tx_PtExtlist_Domain_StateAdapter_GetPostVarAdapterFactory
     */
    protected $getPostVarAdapterFactory;

    /**
     * Shows import form for selecting album to import images to
     *
     * @return string The HTML source for import form
     */
    public function showImportFormAction()
    {
        $albums = $this->albumRepository->findAll();
        $galleries = $this->galleryRepository->findAll();

        $this->view->assign('galleries', $galleries);
        $this->view->assign('albums', $albums);
    }



    /**
     * Shows results for importing images from zip
     *
     * @param Tx_Yag_Domain_Model_Album $album
     * @return string The rendered import from zip action
     */
    public function importFromZipAction(Tx_Yag_Domain_Model_Album $album)
    {
        $getPostVarAdapter = $this->getPostVarAdapterFactory->getInstance();
        // Be careful: Path to file is in $_FILES which we don't get from "standard" GP vars!
        $filePath = $getPostVarAdapter->getFilesVarsByNamespace('tmp_name.file');
        if ($filePath == '') {
            $this->addFlashMessage(
                LocalizationUtility::translate('tx_yag_controller_zipimportcontroller_importfromzipaction.nofilegiven', $this->extensionName),
                '',
                FlashMessage::ERROR
            );
            $this->redirect('addItems', 'Album', null, array('album' => $album));
            return;
        }
        
        $importer = Tx_Yag_Domain_Import_ZipImporter_ImporterBuilder::getInstance()->getZipImporterInstanceForAlbumAndFilePath($album, $filePath);
        $importer->runImport();
        $this->yagContext->setAlbum($album);
        
        // TODO add number of images imported to $importer object
        $this->addFlashMessage(
            LocalizationUtility::translate('tx_yag_controller_zipimportcontroller_importfromzipaction.uploadsuccessfull', $this->extensionName, array($importer->getItemsImported())),
            '',
            FlashMessage::OK);
        $this->yagContext->setAlbum($album);
        $this->redirect('list', 'ItemList');
    }


    /**
     * Creates a new album and imports images from zip into that album
     *
     * TODO this method is not yet used and hence not tested!
     *
     * @param Tx_Yag_Domain_Model_Gallery $gallery Gallery to add album to
     * @param string $albumName Name of album to be created
     * @throws Exception
     */
    public function createNewAlbumAndImportFromZipAction(Tx_Yag_Domain_Model_Gallery $gallery, $albumName)
    {
        $album = new Tx_Yag_Domain_Model_Album();
        $album->setName($albumName);
        $album->addGallery($gallery);
        $gallery->addAlbum($album);
        $this->albumRepository->add($album);
        
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        
        if (!$album->getUid() > 0) {
            throw new Exception('Album hat keine UID!');
        }
        
        $importer = Tx_Yag_Domain_Import_ZipImporter_ImporterBuilder::getInstance()->getZipImporterInstanceForAlbum($album);
        $importer->runImport();

        $this->view->assign('album', $album);
    }
}
