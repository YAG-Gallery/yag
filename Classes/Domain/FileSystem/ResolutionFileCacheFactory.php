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

namespace DL\Yag\Domain\FileSystem;

use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\FileSystem\ResolutionFileCache;
use DL\Yag\Domain\ImageProcessing\ProcessorFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package    Domain
 * @subpackage FileSystem
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
class ResolutionFileCacheFactory {
    /**
     * Holds an instance of the FileRepository to access the gallery files
     *
     * @var ResolutionFileCache
     */
    protected static $instance = null;


    /**
     * Factory method for file repository
     *
     * @return ResolutionFileCache
     */
    public static function getInstance() {
        $configurationBuilder = ConfigurationBuilderFactory::getInstance();

        if ( self::$instance === null ) {
            $objectManager = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' );
            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            self::$instance = $objectManager->get( 'DL\\Yag\\Domain\\FileSystem\\ResolutionFileCache', $objectManager );

            $hashFileSystem = HashFileSystemFactory::getInstance();
            self::$instance->_injectHashFileSystem( $hashFileSystem );

            $imageProcessor = ProcessorFactory::getInstance( $configurationBuilder );
            self::$instance->_injectImageProcessor( $imageProcessor );

            self::$instance->_injectConfigurationBuilder( ConfigurationBuilderFactory::getInstance() );
        }

        return self::$instance;
    }
}
