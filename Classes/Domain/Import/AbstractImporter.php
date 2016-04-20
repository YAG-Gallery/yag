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
use DL\Yag\Domain\Configuration\ConfigurationBuilder;
use DL\Yag\Domain\Configuration\Import\ImporterConfiguration;
use DL\Yag\Domain\FileSystem\FileManager;
use DL\Yag\Domain\ImageProcessing\AbstractProcessor;
use DL\Yag\Domain\Import\MetaData\ItemMetaFactory;
use DL\Yag\Domain\Model\Album;
use DL\Yag\Domain\Model\Item;
use DL\Yag\Domain\Repository\ItemRepository;
use Tx_Extbase_Domain_Model_FrontendUser;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\ArrayUtility;

/**
 * Base class for all YAG importers
 *
 * @package    Domain
 * @subpackage Import
 * @author     Daniel Lienert <typo3@lienert.cc>
 * @author     Michael Knoll <mimi@kaktusteam.de>
 */
abstract class AbstractImporter implements ImporterInterface {
    /**
     * Holds an instance of album content manager
     *
     * @var AlbumContentManager
     */
    protected $albumContentManager;


    /**
     * Holds an instance of configuration builder
     *
     * @var ConfigurationBuilder
     */
    protected $configurationBuilder;


    /**
     * Holds an instance of the importer configuraation
     *
     * @var ImporterConfiguration
     */
    protected $importerConfiguration;


    /**
     * Holds an instance of album to which items should be imported
     *
     * @var Album
     */
    protected $album;


    /**
     * Holds an instance of persistence manager
     *
     * @var PersistenceManager
     */
    protected $persistenceManager;


    /**
     * Holds an instance of image processor
     *
     * @var AbstractProcessor
     */
    protected $imageProcessor;


    /**
     * Holds an instance of item repository
     *
     * @var ItemRepository
     */
    protected $itemRepository;


    /**
     * Holds an instance of item meta repository
     *
     * @var ItemMetaRepository
     */
    protected $itemMetaRepository;


    /**
     * @var ItemMetaFactory
     */
    protected $itemMetaDataFactory;


    /**
     * If set to true, files found in the directory
     * are moved to the directory of original files for
     * the album before they are processed
     *
     * @var bool
     */
    protected $moveFilesToOrigsDirectory = false;


    /**
     * @var ObjectManager
     */
    protected $objectManager;


    /**
     * Holds fe_user
     *
     * @var Tx_Extbase_Domain_Model_FrontendUser
     */
    protected $feUser = null;


    /**
     * @var FileManager
     */
    protected $fileManager;


    /**
     * @var Div
     */
    protected $fileSystemDiv;


    /**
     * @param ObjectManager $objectManager
     */
    public function injectObjectManager( ObjectManager $objectManager ) {
        $this->objectManager = $objectManager;
    }


    /**
     * Injector for persistence manager
     *
     * @param PersistenceManager $persistenceManager
     */
    public function injectPersistenceManager( PersistenceManager $persistenceManager ) {
        $this->persistenceManager = $persistenceManager;
    }


    /**
     * @param FileManager $fileManager
     */
    public function injectFileManager( FileManager $fileManager ) {
        $this->fileManager = $fileManager;
    }


    /**
     * Injector for item repository
     *
     * @param ItemRepository $itemRepository
     */
    public function injectItemRepository( ItemRepository $itemRepository ) {
        $this->itemRepository = $itemRepository;
    }


    /**
     * @param ItemMetaRepository $itemMetaRepository
     */
    public function injectItemMetaRepository( ItemMetaRepository $itemMetaRepository ) {
        $this->itemMetaRepository = $itemMetaRepository;
    }


    /**
     * @param Div $fileSystemDiv
     */
    public function injectResolutionFileSystemDiv( Div $fileSystemDiv ) {
        $this->fileSystemDiv = $fileSystemDiv;
    }


    /**
     * @param ItemMetaFactory $itemMetaDataFactory
     */
    public function injectItemMetaDataFactory( ItemMetaFactory $itemMetaDataFactory ) {
        $this->itemMetaDataFactory = $itemMetaDataFactory;
    }


    /**
     * Injector for image processor
     *
     * @param AbstractProcessor $imageProcessor
     */
    public function setImageProcessor( AbstractProcessor $imageProcessor ) {
        $this->imageProcessor = $imageProcessor;
    }


    /**
     * Injector for album content manager
     *
     * @param AlbumContentManager $albumContentManager
     */
    public function setAlbumManager( AlbumContentManager $albumContentManager ) {
        $this->albumContentManager = $albumContentManager;
    }


    /**
     * Injector for configuration builder
     *
     * @param ConfigurationBuilder $configurationBuilder
     */
    public function setConfigurationBuilder( ConfigurationBuilder $configurationBuilder ) {
        $this->configurationBuilder = $configurationBuilder;
    }


    /**
     * Injector for importer Configuration
     *
     * @param $importerConfiguration
     */
    public function setImporterConfiguration( ImporterConfiguration $importerConfiguration ) {
        $this->importerConfiguration = $importerConfiguration;
    }


    /**
     * Sets album to which items should be imported
     *
     * @param Album $album
     */
    public function setAlbum( Album $album ) {
        $this->album = $album;
    }


    /**
     * Setter for fe_user object
     *
     * @abstract
     *
     * @param FrontendUser $feUser
     */
    public function setFeUser( FrontendUser $feUser ) {
        $this->feUser = $feUser;
    }


    /**
     * Imports a file given by its filepath. If an item object
     * is given, this one is used. Otherwise a new one is created.
     *
     * @param string     $filePath Absolute file path to file on server
     * @param Item $item     Item to attach file to
     *
     * @return Item Item created or used for import
     */
    protected function importFileByFilename( $filePath, $item = null ) {

        // Create new item if none is given
        if ( $item === null ) {
            $item = $this->objectManager->get( 'DL\\Yag\\Domain\\Model\\Item' );
            $item->setFeUserUid( $this->feUser->getUid() );
        }

        // Set sorting of item, if not yet given
        if ( ! $item->getSorting() > 0 ) {
            $item->setSorting( $this->album->getMaxSorting() + 1 );
        }

        $fileSizes        = getimagesize( $filePath );
        $relativeFilePath = $this->getRelativeFilePath( $filePath );

        $item->setSourceuri( $relativeFilePath );
        $item->setFilename( Div::getFilenameFromFilePath( $relativeFilePath ) );

        $item->setWidth( $fileSizes[0] );
        $item->setHeight( $fileSizes[1] );
        $item->setItemType( $fileSizes['mime'] );

        // Metadata
        if ( $this->importerConfiguration->getParseItemMeta() ) {
            try {
                $item->setItemMeta( $this->itemMetaDataFactory->createItemMetaForFile( $filePath ) );
            } catch ( Exception $e ) {
                GeneralUtility::sysLog( 'Error while extracting MetaData from "' . $filePath . '". Error was: ' . $e->getMessage(), 'yag', 2 );
            }

            if ( $this->importerConfiguration->getGenerateTagsFromMetaData() && is_a( $item->getItemMeta(), 'Model_ItemMeta' ) ) {
                try {
                    $item->addTagsFromCSV( $item->getItemMeta()->getKeywords() );
                } catch ( Exception $e ) {
                    GeneralUtility::sysLog( 'Error while saving KeyWords from"' . $filePath . '". Error was: ' . $e->getMessage(), 'yag', 2 );
                }
            }

            $item->setTitle( $this->processStringFromMetaData( $item, $this->importerConfiguration->getTitleFormat() ) );
            $item->setDescription( $this->processStringFromMetaData( $item, $this->importerConfiguration->getDescriptionFormat() ) );
        }

        $item->setAlbum( $this->album );

        $item->setFilesize( filesize( $filePath ) );
        $item->setItemAsAlbumThumbIfNotExisting();
        $item->setFilehash( md5_file( $filePath ) );
        $this->albumContentManager->addItem( $item );
        $this->itemRepository->add( $item );

        return $item;
    }


    /**
     * Replace the variables in the given format string with fileName or properties of the
     * itemMeta object.
     *
     * @param Item $item
     * @param string     $format
     * @param array      $additionalVars
     *
     * @return Item $item;
     */
    protected function processStringFromMetaData( Item $item, $format, $additionalVars = array() ) {
        if ( $item->getItemMeta() instanceof ItemMeta ) {
            $vars = $item->getItemMeta()->getAttributeArray();
        } else {
            $vars = array();
        }

        $vars['origFileName'] = $item->getOriginalFilename();
        $vars['fileName']     = $this->processTitleFromFileName( $item->getOriginalFilename() );

        $vars            = ArrayUtility::arrayMergeRecursiveOverrule( $vars, $additionalVars );
        $formattedString = \Tx_PtExtlist_Utility_RenderValue::renderDataByConfigArray( $vars, $format );

        return $formattedString;
    }


    /**
     * Returns relative base path of image
     *
     * if image resides in /var/www/htdocs/your_site_root/images/img001.jpg
     * this function will return images/img001.jpg
     *
     * @param string $filePath
     *
     * @return string
     */
    protected function getRelativeFilePath( $filePath ) {
        $basePath = Div::getT3BasePath();
        if ( substr( $filePath, 0, strlen( $basePath ) ) == $basePath ) {
            $filePath = substr( $filePath, strlen( $basePath ) );
        }

        return $filePath;
    }


    /**
     * Creates a new item object and persists it
     * so that we have an UID for it.
     *
     * @return Item Persisted item
     */
    protected function getNewPersistedItem() {
        $item = $this->objectManager->get( 'DL\\Yag\\Domain\\Model\\Item' );

        if ( $this->feUser ) {
            $item->setFeUserUid( $this->feUser->getUid() );
        }

        $this->itemRepository->add( $item );
        $this->persistenceManager->persistAll();

        return $item;
    }


    /**
     * Sets file mask to configured value for given file.
     *
     * Does not do anything if running on windows
     *
     * @param string $path Path to file to set mask for
     */
    protected function setFileMask( $path ) {
        // we cannot do this on windows
        if ( ! ( strtoupper( substr( PHP_OS, 0, 3 ) ) == "WIN" ) ) {
            chmod( $path, $this->importerConfiguration->getImportFileMask() );
        }
    }


    /**
     * Returns a file path for an image stored to directory with original files
     *
     * @param string $filename             Filename of file to get path for
     * @param bool   $createDirIfNotExists If true, directory will be created if it doesn't exist
     *
     * @return string Absolute path for filename in directory with original files
     */
    protected function getOrigFilePathForFile( $filename, $createDirIfNotExists = true ) {
        return $this->fileManager->getOrigFileDirectoryPathForAlbum( $this->album, $createDirIfNotExists ) . $filename;
    }


    /**
     * Moves a file from given filepath to directory for original images for album
     *
     * If an item is given, UID of item is used as filename for item in original items directory
     *
     * @param string     $filePath Full qualified filepath of file to move
     * @param Item $item     Item that should hold file (not modified, make sure to set sourceuri manually!
     *
     * @return string
     * @throws Exception
     */
    protected function moveFileToOrigsDirectory( $filePath, Item $item = null ) {

        // Create path to move file to
        $origsFilePath = $this->fileManager->getOrigFileDirectoryPathForAlbum( $this->album );
        $fileSuffix    = pathinfo( $filePath, PATHINFO_EXTENSION );

        if ( $item !== null ) {
            if ( $item->getOriginalFilename() ) {
                $origsFilePath .= $item->getUid() . '_' . $this->fileSystemDiv->cleanFileName( $item->getOriginalFilename() );
            } else {
                $origsFilePath .= $item->getUid() . '.' . $fileSuffix; // if we get an item, we use UID of item as a part of the filename
            }
        } else {
            $origsFilePath .= Div::getFilenameFromFilePath( $filePath ); // if we do not get one, we use filename of given filepart
        }

        if ( ! rename( $filePath, $origsFilePath ) ) {
            throw new Exception( 'Could not move file ' . $filePath . ' to ' . $origsFilePath, 1294176900 );
        }

        // Set appropriate file mask
        $this->setFileMask( $origsFilePath );

        return $origsFilePath;
    }


    /**
     * Extract an image title from the file name
     *
     * @param $fileName
     *
     * @return string
     */
    protected function processTitleFromFileName( $fileName ) {
        $title = implode( '.', array_slice( explode( '.', $fileName ), 0, - 1 ) );
        $title = ucfirst( $title );
        $title = str_replace( array( '.', '_' ), ' ', $title );

        return $title;
    }


    /**
     * Files will be moved to a directory containing original files
     * for album before they are processed
     */
    public function setMoveFilesToOrigsDirectoryToTrue() {
        $this->moveFilesToOrigsDirectory = true;
    }


    /**
     * Files won't be moved to a directory containing original files
     * for album before they are processed
     */
    public function setMoveFilesToOrigsDirectoryToFalse() {
        $this->moveFilesToOrigsDirectory = false;
    }


    /**
     * Runs everything, that should be done after import
     * is finished.
     */
    protected function runPostImportAction() {
        $this->albumContentManager->setAlbumAsGalleryThumbIfNotExisting();
        $this->persistenceManager->persistAll();
    }
}
