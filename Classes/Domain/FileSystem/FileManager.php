<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2012 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
use DL\Yag\Domain\Model\Item;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class implements a file manager for handling file system operations in yag g
 *
 * @author     Daniel Lienert
 * @package    Domain
 * @subpackage FileSystem
 */
class FileManager implements SingletonInterface {
    /**
     * Remove the file if it is located within its album path.
     * That means, it does not remove files located in an other directory (like files imported by the directory
     * importer)
     *
     * @param Item $item
     */
    public function removeImageFileFromAlbumDirectory( Item $item ) {
        $albumPath     = $this->getOrigFileDirectoryPathForAlbum( $item->getAlbum() );
        $imageFilePath = Div::makePathAbsolute( $item->getSourceuri() );
        if ( GeneralUtility::isFirstPartOfStr( $imageFilePath, $albumPath ) && file_exists( $imageFilePath ) ) {
            unlink( $imageFilePath );
        }
    }


    /**
     * @param Album $album
     */
    public function removeAlbumDirectory( Album $album ) {
        $albumPath = $this->getOrigFileDirectoryPathForAlbum( $album );
        Div::rRMDir( $albumPath );
    }


    /**
     * Creates path for original files on server.
     * If path does not exist, it will be created if given parameter is true.
     *
     * @param Album $album
     * @param bool  $createIfNotExists If set to true, directory will be created if it does not exist
     *
     * @return string Path for original images (absolute)
     * @throws Exception
     */
    public function getOrigFileDirectoryPathForAlbum( Album $album, $createIfNotExists = true ) {
        $path = ConfigurationBuilderFactory::getInstance()->buildExtensionConfiguration()->getOrigFilesRootAbsolute() . '/' . $album->getUid() . '/';

        if ( $createIfNotExists ) {
            $success = Div::checkDirAndCreateIfMissing( $path );
            if ( ! $success ) {
                throw new Exception( sprintf( 'The original file path %s  for album %s could not be created!', $path, $album->getUid() ), 1404452464 );
            }
        }

        return $path;
    }
}
