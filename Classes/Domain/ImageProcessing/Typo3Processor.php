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

namespace DL\Yag\Domain\ImageProcessing;

use DL\Yag\Domain\Configuration\Image\ResolutionConfig;
use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Domain\Model\Item;
use DL\Yag\Domain\Model\ResolutionFileCache;
use DL\Yag\Exception\InvalidPath;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Class implements image processor
 *
 * @package    Domain
 * @subpackage ImageProcessing
 * @author     Michael Knoll <mimi@kaktsuteam.de>
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
class Typo3Processor extends AbstractProcessor {
    /**
     * @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController contains a backup of the current
     *      $GLOBALS['TSFE'] if used in BE mode
     */
    protected $tsfeBackup;


    /**
     * @var string
     */
    protected $workingDirectoryBackup;


    /**
     * (non-PHPdoc)
     * @see AbstractProcessor::processFile()
     *
     * @param ResolutionConfig    $resolutionConfiguration
     * @param Item                $origFile
     * @param ResolutionFileCache $resolutionFile
     *
     * @return TYPO3\CMS\Core\Resource\ProcessedFile
     * @throws Exception
     * @throws InvalidPath
     */
    protected function processFile( ResolutionConfig $resolutionConfiguration, Item $origFile, ResolutionFileCache $resolutionFile ) {
        if ( TYPO3_MODE === 'BE' ) {
            $this->simulateFrontendEnvironment();
        }

        // check if the item has a source uri set
        if ( trim( $origFile->getSourceuri() ) == '' ) {
            throw new InvalidPath( 'No Source URI set for Item ' . $origFile->getUid(), 1357896895 );
        }

        $expectedDirectoryForOrigImage = Div::makePathAbsolute( Div::getPathFromFilePath( $origFile->getSourceuri() ) );
        $sourcePathAndFileName         = $origFile->getSourceuri();

        // check for source directory to be existing
        if ( ! file_exists( $expectedDirectoryForOrigImage ) ) {
            // we "re-create" missing directory so that file-not-found can be handled correctly
            // even if the directory has been deleted (by accident) and we can display
            // a file-not-found image instead of an Exception
            if ( ! mkdir( $expectedDirectoryForOrigImage, 0777, true ) ) {
                throw new Exception( 'Tried to create new directory ' . $expectedDirectoryForOrigImage . ' but could not create this directory!', 1345272425 );
            }
        }

        // check for source file to be existing
        if ( ! file_exists( Div::makePathAbsolute( $sourcePathAndFileName ) ) || ! is_readable( Div::makePathAbsolute( $sourcePathAndFileName ) ) ) {
            // if the original image for processed image is missing, we use the file-not-found file as source
            $sourcePathAndFileName = $this->processorConfiguration->getConfigurationBuilder()->buildSysImageConfiguration()->getSysImageConfig( 'imageNotFound' )->getSourceUri();
        }

        $processedFile = $this->getImageResource( $origFile, $sourcePathAndFileName, $resolutionConfiguration );

        $resultImagePathAbsolute = $processedFile->getForLocalProcessing();
        $imageTarget             = $this->generateAbsoluteResolutionPathAndFilename( end( explode( ".", $resultImagePathAbsolute ) ), $origFile->getTitle() );

        // check if we have a file
        if ( ! file_exists( $resultImagePathAbsolute ) || ! is_file( $resultImagePathAbsolute ) ) {
            throw new Exception( sprintf( "
				TYPO3 image processor was not able to create an output image.
				SourceImagePath: %s,
				ResultImagePath: %s",
                Div::makePathAbsolute( $sourcePathAndFileName ), $resultImagePathAbsolute ), 1300205628 );
        }

        if ( $resultImagePathAbsolute == $processedFile->getOriginalFile()->getForLocalProcessing() ) {
            // the image was not processed, take the original file
            copy( $resultImagePathAbsolute, $imageTarget );
        } else {
            rename( $resultImagePathAbsolute, $imageTarget );
        }

        // Make sure, that expected image exists
        if ( ! file_exists( $imageTarget ) ) {
            throw new Exception( sprintf( 'The result image of the image processing was not moved from the creation path %s to the expected target path %s', $resultImagePathAbsolute, Div::makePathAbsolute( $imageTarget ) ), 1393382624 );
        }

        // set resolutionFileObject
        $resolutionFile->setPath( $imageTarget );
        $resolutionFile->setWidth( $processedFile->getProperty( 'width' ) );
        $resolutionFile->setHeight( $processedFile->getProperty( 'height' ) );

        if ( TYPO3_MODE === 'BE' ) {
            $this->resetFrontendEnvironment();
        }

        return $processedFile;
    }


    /**
     * Wrapper for cObj->getImageResource in FE and BE
     *
     * @param Item             $origFile              The original image
     * @param string           $sourcePathAndFileName Must be used to access the file, as it may be overwritten if the
     *                                                original file was not found
     * @param ResolutionConfig $resolutionConfiguration
     *
     * @return TYPO3\CMS\Core\Resource\ProcessedFile
     */
    protected function getImageResource( Item $origFile, $sourcePathAndFileName, ResolutionConfig $resolutionConfiguration ) {
        $typoScriptSettings = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Service\\TypoScriptService' )->convertPlainArrayToTypoScriptArray( $resolutionConfiguration->getSettings() );

        $contentObject = $this->configurationManager->getContentObject();
        /** @var $contentObject \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer */

        if ( $resolutionConfiguration->getMode() == 'GIFBUILDER' ) {
            $gifBuilderData = [
                'yagImage'        => $sourcePathAndFileName,
                'yagImageTitle'   => $origFile->getTitle(),
                'yagImageUid'     => $origFile->getUid(),
                'yagAlbumUid'     => $origFile->getAlbum()->getUid(),
                'yagAlbumTitle'   => $origFile->getAlbum()->getName(),
                'yagGalleryUid'   => $origFile->getAlbum()->getGallery()->getUid(),
                'yagGalleryTitle' => $origFile->getAlbum()->getGallery()->getName()
            ];

            $contentObject->start( $gifBuilderData );
            $imageResource = $contentObject->getImgResource( 'GIFBUILDER', $typoScriptSettings );
        } else {
            $fileObject    = $this->getResourceFactory()->retrieveFileOrFolderObject( $sourcePathAndFileName );
            $imageResource = $contentObject->getImgResource( $fileObject, $typoScriptSettings );
        }

        //   $this->typo3CleanUp($imageResource);

        return $imageResource['processedFile'];
    }


    /**
     * As we have our own resolution file cache system
     * we dont want to polute the TYPO3 cache_imagesizes table.
     * So we remove the generated image (messy, but the only way ...)
     *
     * @param $imageResource array File description
     */
    protected function typo3CleanUp( $imageResource ) {


        $GLOBALS['TYPO3_DB']->exec_DELETEquery(
            'cf_cache_imagesizes',
            'filename = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr( $imageResource[3], 'cf_cache_imagesizes' )
        );

        unset( $GLOBALS['TSFE']->tmpl->fileCache[ $imageResource['fileCacheHash'] ] );
    }


    /**
     * Prepares $GLOBALS['TSFE'] for Backend mode
     * This somewhat hacky work around is currently needed because the getImgResource() function of tslib_cObj relies
     * on those variables to be set
     *
     * @return void
     */
    protected function simulateFrontendEnvironment() {
        $this->tsfeBackup = isset( $GLOBALS['TSFE'] ) ? $GLOBALS['TSFE'] : null;

        // set the working directory to the site root
        $this->workingDirectoryBackup = getcwd();
        chdir( PATH_site );

        $currentPid = (int) current( $this->pidDetector->getPids() );
        GeneralUtility::makeInstance( \Tx_PtExtbase_Utility_FakeFrontendFactory::class )->createFakeFrontEnd( $currentPid );

        $typoScriptSetup              = $this->configurationManager->getConfiguration( ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT );
        $GLOBALS['TSFE']->tmpl->setup = $typoScriptSetup;
        $GLOBALS['TSFE']->config      = $typoScriptSetup;
        $GLOBALS['TSFE']->sys_page    = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Frontend\\Page\\PageRepository' );
    }


    /**
     * Resets $GLOBALS['TSFE'] if it was previously changed by simulateFrontendEnvironment()
     *
     * @return void
     * @author Bastian Waidelich <bastian@typo3.org>
     * @see    simulateFrontendEnvironment()
     */
    protected function resetFrontendEnvironment() {
        $GLOBALS['TSFE'] = $this->tsfeBackup;
        chdir( $this->workingDirectoryBackup );
    }


    /**
     * Get instance of FAL resource factory
     *
     * @return ResourceFactory
     */
    protected function getResourceFactory() {
        return ResourceFactory::getInstance();
    }
}
