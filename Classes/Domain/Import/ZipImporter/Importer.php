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

namespace DL\Yag\Domain\Import\ZipImporter;

use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Domain\Import\AbstractImporter;
use DL\Yag\Domain\Import\DirectoryImporter\ImporterBuilder;
use TYPO3\CMS\Core\Utility\CommandUtility;

/**
 * Zip Importer for YAG gallery. Enables importing images from ZIP files
 *
 * @package    Domain
 * @subpackage Import\ZipImporter
 * @author     Michael Knoll <mimi@kaktusteam.de>
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
class Importer extends AbstractImporter {
    /**
     * Holds path to zipFile
     *
     * @var string
     */
    protected $zipFilename;


    /**
     * Holds number of items that were imported during last import
     *
     * @var int
     */
    protected $itemsImported = 0;


    /**
     * @var string
     */
    protected $unzipExecutable;


    /**
     * Setter for zip filename. Sets filename (full path) of zip
     * file to be imported.
     *
     * @param string $zipFilename Filname of zip file to be imported
     */
    public function setZipFilename( $zipFilename ) {
        $this->zipFilename = $zipFilename;
    }


    /**
     * @param $unzipExecutable
     */
    public function setUnzipExecutable( $unzipExecutable ) {
        $this->unzipExecutable = $unzipExecutable;
    }


    /**
     * Runs actual import. Unpacks zip file to a directory and
     * runs directory importer to actually import the files contained
     * in zip file.
     */
    public function runImport() {
        // Unpack zip file
        $tempDir = Div::tempdir( sys_get_temp_dir(), 'yag_zip_extraction' );
        $this->unzipArchive( $this->zipFilename, $tempDir );

        // Initialize directory crawler on extracted file's directory and run import
        $directoryImporter = ImporterBuilder::getInstance()->getInstanceByDirectoryAndAlbum( $tempDir, $this->album );
        $directoryImporter->setMoveFilesToOrigsDirectoryToTrue(); // Files will be moved to origs directory before they are processed
        $directoryImporter->setCrawlRecursive( true );
        $directoryImporter->runImport();

        $this->itemsImported = $directoryImporter->getItemsImported();
    }


    /**
     * @param $zipPathAndFileName string
     * @param $tempDir            string
     *
     * @return bool
     * @throws Exception
     */
    protected function unzipArchive( $zipPathAndFileName, $tempDir ) {

        // check if the PHP module ZipArchive is loaded and use it
        if ( extension_loaded( 'zip' ) ) {
            $zip = new ZipArchive;

            if ( $zip->open( $zipPathAndFileName ) === true ) {
                $zip->extractTo( $tempDir );
                $zip->close();
            } else {
                throw new Exception( 'Error while trying to extract a zip archive using the PHP module ZipArchive', 1294159795 );
            }
        }


        // call the unzip executable if set
        if ( $this->unzipExecutable && is_executable( $this->unzipExecutable ) ) {
            $cmd = $this->unzipExecutable . ' -qq "' . $zipPathAndFileName . '" -d "' . $tempDir . '"';
            CommandUtility::exec( $cmd );
        }
    }


    /**
     *
     */
    public function isAvailable() {
    }


    /**
     * Returns number of items that were imported during last import
     *
     * @return int
     */
    public function getItemsImported() {
        return $this->itemsImported;
    }
}
