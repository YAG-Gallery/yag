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

namespace DL\Yag\Domain\Import;

use DL\Yag\Domain\AlbumContentManager;
use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\ImageProcessing\ProcessorFactory;
use DL\Yag\Domain\Model\Album;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Factory for building importers
 *
 * @package    Domain
 * @subpackage Import
 * @author     Daniel Lienert <typo3@lienert.cc>
 * @author     Michael Knoll <mimi@kaktusteam.de>
 */
class ImporterBuilder {
    /**
     * Holds an instance of importer builder as singleton instance of class
     *
     * @var Import_ImporterBuilder
     */
    protected static $instance = null;


    /**
     * Holds an instance of configuration builder
     *
     * @var ConfigurationBuilder
     */
    protected $configurationBuilder;


    /**
     * Factory method for getting an instance of importer builder (singleton)
     *
     * @return Import_ImporterBuilder Singleton instance of importer builder
     */
    public static function getInstance() {
        if ( self::$instance === null ) {
            $configurationBuilder = ConfigurationBuilderFactory::getInstance();
            self::$instance       = new self( $configurationBuilder );
        }

        return self::$instance;
    }


    /**
     * Constructor for importer builder
     *
     * @param ConfigurationBuilder $configurationBuilder
     */
    protected function __construct( ConfigurationBuilder $configurationBuilder ) {
        $this->configurationBuilder = $configurationBuilder;
    }


    /**
     * Creates an instance of an importer
     *
     * @param string $importerClassName Class name of importer
     *
     * @return AbstractImporter Instance of importer class
     */
    public function createImporter( $importerClassName ) {
        $objectManager = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' );
        /** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */

        $importer = $objectManager->get( $importerClassName );
        /* @var $importer Import_AbstractImporter */
        $importer->setConfigurationBuilder( $this->configurationBuilder );
        $importer->setImporterConfiguration( $this->configurationBuilder->buildImporterConfiguration() );
        $importer->setImageProcessor( ProcessorFactory::getInstance( $this->configurationBuilder ) );

        return $importer;
    }


    /**
     * Creates an instance of an importer for a given album
     *
     * @param string $importerClassName Class name of importer
     * @param Album  $album
     *
     * @return Import_AbstractImporter Instance of importer class
     */
    public function createImporterForAlbum( $importerClassName, Album $album ) {
        $importer = $this->createImporter( $importerClassName );
        $importer->setAlbumManager( new AlbumContentManager( $album ) );
        $importer->setAlbum( $album );

        return $importer;
    }
}
