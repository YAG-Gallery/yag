<?php
/***************************************************************
 * Copyright notice
 *
 *   2010 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
 * All rights reserved
 *
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace DL\Yag\Domain\ImageProcessing;

use DL\Yag\Domain\Configuration\Image\ResolutionConfig;
use DL\Yag\Domain\Configuration\ImageProcessing\ImageProcessorConfiguration;
use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Domain\FileSystem\HashFileSystem;
use DL\Yag\Domain\Model\Item;
use DL\Yag\Domain\Model\ResolutionFileCache;
use DL\Yag\Domain\Repository\ResolutionFileCacheRepository;
use DL\Yag\Utility\PidDetector;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Abstract image processor
 *
 * @package    Domain
 * @subpackage ImageProcessing
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
abstract class AbstractProcessor implements ProcessorInterface {
    /**
     * Holds configuration for image processor
     *
     * @var ImageProcessorConfiguration
     */
    protected $processorConfiguration;


    /**
     * Holds an instance of hash file system for this gallery
     *
     * @var HashFileSystem
     */
    protected $hashFileSystem;


    /**
     * @var ConfigurationManagerInterface
     */
    protected $configurationManager;


    /**
     * @var ResolutionFileCacheRepository
     */
    protected $resolutionFileCacheRepository;


    /**
     * @var Div
     */
    protected $fileSystemDiv;


    /**
     * @var PidDetector
     */
    protected $pidDetector;


    /**
     * @param PidDetector $pidDetector
     */
    public function injectPidDetector( PidDetector $pidDetector ) {
        $this->pidDetector = $pidDetector;
    }


    /**
     * @param Div $fileSystemDiv
     */
    public function injectFileSystemDiv( Div $fileSystemDiv ) {
        $this->fileSystemDiv = $fileSystemDiv;
    }


    /**
     * @param ConfigurationManagerInterface $configurationManager
     */
    public function injectConfigurationManager( ConfigurationManagerInterface $configurationManager ) {
        $this->configurationManager = $configurationManager;
    }


    /**
     * @param ResolutionFileCacheRepository $resolutionFileCacheRepository
     */
    public function injectResolutionFileCacheRepository( ResolutionFileCacheRepository $resolutionFileCacheRepository ) {
        $this->resolutionFileCacheRepository = $resolutionFileCacheRepository;
    }


    /**
     * @param ImageProcessorConfiguration $processorConfiguration
     */
    public function _injectProcessorConfiguration( ImageProcessorConfiguration $processorConfiguration ) {
        $this->processorConfiguration = $processorConfiguration;
    }


    /**
     * @param HashFileSystem $hashFileSystem
     */
    public function _injectHashFileSystem( HashFileSystem $hashFileSystem ) {
        $this->hashFileSystem = $hashFileSystem;
    }


    /**
     *
     * Init the concrete image processor
     */
    public function init() {
    }


    public function __construct() {
        $this->fileSystemDiv = GeneralUtility::makeInstance( 'DL\\Yag\\Domain\\FileSystem\\Div' ); // Somehow this particular inject does not work??!
    }


    /**
     * (non-PHPdoc)
     * @see ProcessorInterface::generateResolution()
     *
     * @param Item|Item        $origFile
     * @param ResolutionConfig $resolutionConfiguration
     *
     * @return ResolutionFileCache
     */
    public function generateResolution( Item $origFile, ResolutionConfig $resolutionConfiguration ) {
        $resolutionFile = new ResolutionFileCache( $origFile, '', 0, 0, $resolutionConfiguration->getParameterHash() );

        $this->processFile( $resolutionConfiguration, $origFile, $resolutionFile );

        $this->resolutionFileCacheRepository->add( $resolutionFile );

        return $resolutionFile;
    }


    /**
     * Process a file and set the resulting path in the resolution file object
     *
     * @param ResolutionConfig    $resolutionConfiguration
     * @param Item                $origFile
     * @param ResolutionFileCache $resolutionFile
     */
    abstract protected function processFile( ResolutionConfig $resolutionConfiguration, Item $origFile, ResolutionFileCache $resolutionFile );


    /**
     * Build and return the target file path of the resolution file
     *
     * @param string $extension
     * @param string $imageName
     *
     * @return string $targetFilePath
     */
    protected function generateAbsoluteResolutionPathAndFilename( $extension = 'jpg', $imageName = '' ) {

        // We need an UID for the item file
        $nextUid = $this->resolutionFileCacheRepository->getCurrentUid();

        // Get a path in the hash filesystem
        $resolutionFileName = $this->getMeaningfulTempFilePrefix( $imageName ) . substr( uniqid( $nextUid . '_' ), 0, 16 );
        $targetFilePath     = $this->hashFileSystem->createAndGetAbsolutePathById( $nextUid ) . '/' . $resolutionFileName . '.' . $extension;

        return $targetFilePath;
    }


    /**
     * @param $imageName
     *
     * @return string
     */
    protected function getMeaningfulTempFilePrefix( $imageName ) {
        if ( $this->processorConfiguration->getMeaningfulTempFilePrefix() > 0 && $imageName != '' ) {
            $cleanFileName = $this->fileSystemDiv->cleanFileName( $imageName );

            if ( $GLOBALS['TYPO3_CONF_VARS']['SYS']['UTF8filesystem'] ) {
                $t3libCsInstance = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Core\\Charset\\CharsetConverter' );
                /** @var $t3libCsInstance \TYPO3\CMS\Core\Charset\CharsetConverter */
                $meaningfulPrefix = $t3libCsInstance->substr( 'utf-8', $cleanFileName, 0, $this->processorConfiguration->getMeaningfulTempFilePrefix() );
            } else {
                $meaningfulPrefix = substr( $cleanFileName, 0, $this->processorConfiguration->getMeaningfulTempFilePrefix() );
            }

            $meaningfulPrefix .= '_';

            return $meaningfulPrefix;
        }

        return '';
    }
}
