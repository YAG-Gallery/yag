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

use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\Model\Album;

/**
 * Builder for Zip importer
 *
 * @package    Domain
 * @subpackage Import\ZipImporter
 * @author     Michael Knoll <mimi@kaktusteam.de>
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
class ImporterBuilder extends \DL\Yag\Domain\Import\ImporterBuilder {
    /**
     * Holds a singleton instance of this class
     *
     * @var ImporterBuilder
     */
    protected static $instance = null;


    /**
     * Factory method for getting an instance of this class as a singleton
     *
     * @return ImporterBuilder Singleton instance of zip importer builder
     */
    public static function getInstance() {
        if ( self::$instance === null ) {
            self::$instance = new self( ConfigurationBuilderFactory::getInstance() );
        }

        return self::$instance;
    }

    /**
     * If either the extension zip is loaded or if we have a valid unzip executable return true
     *  and false if not.
     *
     * @static
     * @return bool
     */
    public static function checkIfImporterIsAvailable() {
        return extension_loaded( 'zip' ) || self::checkAndReturnUnzipExecutable();
    }

    /**
     * Returns an instance of zip impoter for a given album
     *
     * @param Album  $album
     * @param string $filePath Path to zip file
     *
     * @return Importer Instance of lightroom importer
     */
    public function getZipImporterInstanceForAlbumAndFilePath( Album $album, $filePath ) {
        $zipImporter = $this->createImporterForAlbum( 'Importer', $album );

        /* @var $zipImporter Importer */
        $zipImporter->setZipFilename( $filePath );
        $zipImporter->setUnzipExecutable( self::checkAndReturnUnzipExecutable() );

        return $zipImporter;
    }

    /**
     * If the unzip executable is defined, available and executable it returns it
     *
     * @static
     * @return bool|string
     */
    protected static function checkAndReturnUnzipExecutable() {
        // if zipArchive is not installed try the unzip command provided by TYPO3
        $unzipPath = trim( $GLOBALS['TYPO3_CONF_VARS']['BE']['unzip_path'] );
        if ( substr( $unzipPath, - 1 ) !== '/' && is_dir( $unzipPath ) ) {
            // Make sure the path ends with a slash
            $unzipPath .= '/';
        }

        if ( is_executable( $unzipPath . 'unzip' ) ) {
            return $unzipPath . 'unzip';
        }

        return false;
    }
}
