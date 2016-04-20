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

use DL\Yag\Domain\Import\FileImporter\ImporterBuilder;
use DL\Yag\Domain\Model\Album;
use DL\Yag\Utility\Encoding;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class implements a controller for multifile-upload using flash uploader
 *
 * @package Controller
 * @author  Michael Knoll <mimi@kaktusteam.de>
 */
class FileUploadController extends AbstractController {
    /**
     * Renders an upload form for multifile-uploading
     *
     * @return string Rendered upload form action
     */
    public function showUploadFormAction() {
        // Nothing to do so far but showing the upload form template
        // TODO make album selectable 
    }


    /**
     * @rbacNeedsAccess
     * @rbacObject album
     * @rbacAction edit
     *
     * @param Album $album Album to add uploaded images to
     *
     * @return void Nothing, as we are called in AJAX mode from flash uploader
     */
    public function uploadAction( Album $album = null ) {
        if ( ! is_array( $_FILES ) || ! isset( $_FILES['Filedata'] ) ) {
            $this->handleError( 'No file found in upload data!' );
        }

        if ( ! file_exists( $_FILES['Filedata']['tmp_name'] ) || ! is_readable( $_FILES['Filedata']['tmp_name'] ) ) {
            $this->handleError(
                sprintf( 'File %s was uploaded and saved as %s, but this file is not readable!', $_FILES['Filedata']['name'], $_FILES['Filedata']['tmp_name'] )
            );
        }

        try {
            $rawFileName = $_FILES['Filedata']['name'];
            $fileName    = Encoding::toUTF8( $rawFileName );

            if ( TYPO3_DLOG ) {
                GeneralUtility::devLog( 'Converted filename: ' . $fileName, 'yag', 0, array( '$_FILES' => $_FILES ) );
            }

            $fileImporter = ImporterBuilder::getInstance()->getImporterInstanceByAlbum( $album );

            $fileImporter->setFilePath( $_FILES['Filedata']['tmp_name'] );
            $fileImporter->setOriginalFileName( $fileName );
            $fileImporter->setItemType( $_FILES['Filedata']['type'] );

            if ( $this->feUser ) {
                $fileImporter->setFeUser( $this->feUser );
            }

            $fileImporter->runImport();
        } catch ( Exception $e ) {
            // We are in ajax mode, no error goes to browser --> write to dev log
            $this->handleError( sprintf( 'An error occurred while uploading file: %s (%s)', $e->getMessage(), $e->getCode() ) );
        }


        $this->exit_status( 'OK' );
    }


    /**
     * @param $status
     */
    protected function exit_status( $status ) {
        echo json_encode( array( 'status' => $status ) );
        exit;
    }


    /**
     * Handles errors
     *
     * @param string $message
     */
    protected function handleError( $message ) {
        error_log( 'YAG Upload error: ' . $message );
        if ( TYPO3_DLOG ) {
            GeneralUtility::devLog( $message, 'yag', 3 );
        }
        ob_clean();

        header( "HTTP/1.1 500 Internal Server Error" );
        exit( 1 );
    }
}
