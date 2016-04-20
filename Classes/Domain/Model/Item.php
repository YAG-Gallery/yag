<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
 *            Daniel Lienert <typo3@lienert.cc>
 *
 *  All rights reserved
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

namespace DL\Yag\Domain\Model;

use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\Configuration\Image\ResolutionConfig;
use DL\Yag\Domain\FileSystem\ResolutionFileCacheFactory;
use DL\Yag\Domain\Repository\ItemMetaRepository;
use DL\Yag\Domain\Repository\ResolutionFileCacheRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Gallery implements Item domain object. An item is anything that can be
 * attached to an album as content.
 *
 * @author     Daniel Lienert <typo3@lienert.cc>
 * @author     Michael Knoll <mimi@kaktusteam.de>
 * @package    Domain
 * @subpackage Model
 */
class Item extends AbstractEntity implements DomainModelInterface {
    /**
     * Title of item
     *
     * @var string $title
     */
    protected $title;


    /**
     * filename of item
     *
     * @var string $filename
     */
    protected $filename;


    /**
     * @var string The original filename at import time
     */
    protected $originalFilename;


    /**
     * Description of item
     *
     * @var string $description
     */
    protected $description;


    /**
     * Date of item
     *
     * @var \DateTime $date
     */
    protected $date;


    /**
     * URI of item's source
     *
     * @var string $sourceuri
     */
    protected $sourceuri;


    /**
     * Holds md5 hash of original image
     *
     * @var string
     */
    protected $filehash;


    /**
     * Type of item
     *
     * @var string $itemType
     */
    protected $itemType;


    /**
     * Width of item
     *
     * @var integer $width
     */
    protected $width;


    /**
     * Height of item
     *
     * @var integer $height
     */
    protected $height;


    /**
     * Filesize of item
     *
     * @var integer $filesize
     */
    protected $filesize;


    /**
     * UID of fe user that owns item
     *
     * @var integer $feUserUid
     */
    protected $feUserUid;


    /**
     * UID of fe group that owns item
     *
     * @var integer $feGroupUid
     */
    protected $feGroupUid;


    /**
     * Holds album to which item belongs to
     *
     * @var \DL\Yag\Domain\Model\Album $album
     */
    protected $album;


    /**
     * Holds meta data for item
     *
     * @lazy
     * @var \DL\Yag\Domain\Model\ItemMeta $itemMeta
     */
    protected $itemMeta;


    /**
     * Holds an sorting id for an item within an album
     *
     * @var int
     */
    protected $sorting;


    /**
     * tags
     * @lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DL\Yag\Domain\Model\Tag> $tags
     */
    protected $tags;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DL\Yag\Domain\Model\Category>
     * @lazy
     */
    protected $categories;


    /**
     * This property only exists to convince the property mapper to use the correspondent setter
     *
     * @var string
     */
    protected $tagsFromCSV;


    /**
     * @var string
     */
    protected $link;


    /**
     * @var \DateTime
     */
    protected $crdate;


    /**
     * @var \DateTime
     */
    protected $tstamp;


    /**
     * @var float
     */
    protected $rating;


    /**
     * @var ObjectManager
     */
    protected $objectManager;


    public function __construct() {
        $this->initStorageObjects();
    }


    public function __wakeUp() {
        if ( ! $this->objectManager instanceof ObjectManager ) {
            $this->objectManager = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' );
        } // TYPO3 4.5 Fix
    }


    /**
     * @param ObjectManager $objectManager
     */
    public function injectObjectManager( ObjectManager $objectManager ) {
        $this->objectManager = $objectManager;
    }


    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage instances.
     *
     * @return void
     */
    protected function initStorageObjects() {
        $this->tags       = new ObjectStorage();
        $this->categories = new ObjectStorage();
    }


    /**
     * Setter for title
     *
     * @param string $title Title of item
     *
     * @return void
     */
    public function setTitle( $title ) {
        $this->title = $title;
    }


    /**
     * Getter for title
     *
     * @return string Title of item
     */
    public function getTitle() {
        return $this->title;
    }


    /**
     * Setter for filename
     *
     * @param string $filename filename of item
     *
     * @return void
     */
    public function setFilename( $filename ) {
        $this->filename = $filename;
    }


    /**
     * Getter for filename
     *
     * @return string filename of item
     */
    public function getFilename() {
        return $this->filename;
    }


    /**
     * Setter for description
     *
     * @param string $description Description of item
     *
     * @return void
     */
    public function setDescription( $description ) {
        $this->description = $description;
    }


    /**
     * Getter for description
     *
     * @return string Description of item
     */
    public function getDescription() {
        return $this->description;
    }


    /**
     * Setter for date
     *
     * @param \DateTime $date Date of item
     *
     * @return void
     */
    public function setDate( $date ) {
        $this->date = $date;
    }


    /**
     * Getter for date
     *
     * @return \DateTime Date of item
     */
    public function getDate() {
        return $this->date;
    }


    /**
     * Setter for source uri
     *
     * @param string $sourceURI URI of item's source
     *
     * @return void
     */
    public function setSourceuri( $sourceURI ) {
        $this->sourceuri = $sourceURI;
    }


    /**
     * Getter for sourceURI
     *
     * @return string URI of item's source
     */
    public function getSourceuri() {
        return $this->sourceuri;
    }


    /**
     * Setter for itemType
     *
     * @param string $itemType Type of item
     *
     * @return void
     */
    public function setItemType( $itemType ) {
        $this->itemType = $itemType;
    }


    /**
     * Getter for itemType
     *
     * @return string Type of item
     */
    public function getItemType() {
        return $this->itemType;
    }


    /**
     * Setter for width
     *
     * @param integer $width Width of item
     *
     * @return void
     */
    public function setWidth( $width ) {
        $this->width = $width;
    }


    /**
     * Getter for width
     *
     * @return integer Width of item
     */
    public function getWidth() {
        return $this->width;
    }


    /**
     * Setter for height
     *
     * @param integer $height Height of item
     *
     * @return void
     */
    public function setHeight( $height ) {
        $this->height = $height;
    }


    /**
     * Getter for height
     *
     * @return integer Height of item
     */
    public function getHeight() {
        return $this->height;
    }


    /**
     * Setter for fileSize
     *
     * @param integer $fileSize FileSize of item
     *
     * @return void
     */
    public function setFilesize( $fileSize ) {
        $this->filesize = $fileSize;
    }


    /**
     * Getter for filesize
     *
     * @return integer Filesize of item
     */
    public function getFilesize() {
        return $this->filesize;
    }


    /**
     * Setter for feUserUid
     *
     * @param integer $feUserUid UID of fe user that owns item
     *
     * @return void
     */
    public function setFeUserUid( $feUserUid ) {
        $this->feUserUid = $feUserUid;
    }


    /**
     * Getter for feUserUid
     *
     * @return integer UID of fe user that owns item
     */
    public function getFeUserUid() {
        return $this->feUserUid;
    }


    /**
     * Setter for feGroupUid
     *
     * @param integer $feGroupUid UID of fe group that owns item
     *
     * @return void
     */
    public function setFeGroupUid( $feGroupUid ) {
        $this->feGroupUid = $feGroupUid;
    }


    /**
     * Getter for feGroupUid
     *
     * @return integer UID of fe group that owns item
     */
    public function getFeGroupUid() {
        return $this->feGroupUid;
    }


    /**
     * Setter for album
     *
     * @param Album $album Holds album to which item belongs to
     *
     * @return void
     */
    public function setAlbum( Album $album ) {
        $this->album = $album;
    }


    /**
     * Getter for album
     *
     * @return Album Holds album to which item belongs to
     */
    public function getAlbum() {
        return \Tx_PtExtbase_Div::getLazyLoadedObject( $this->album );
    }


    /**
     * Setter for md5 file hash
     *
     * @param string $filehash
     */
    public function setFilehash( $filehash ) {
        $this->filehash = $filehash;
    }


    /**
     * Getter for md5 file hash
     *
     * @return string
     */
    public function getFilehash() {
        return $this->filehash;
    }


    /**
     * Setter for itemMeta
     *
     * @param ItemMeta $itemMeta Holds meta data for item
     *
     * @return void
     */
    public function setItemMeta( ItemMeta $itemMeta ) {
        $this->itemMeta = $itemMeta;
        if ( $itemMeta->getCaptureDate() instanceof \DateTime ) {
            $this->setDate( $itemMeta->getCaptureDate() );
        }
    }


    /**
     * Getter for itemMeta
     *
     * @return ItemMeta Holds meta data for item
     */
    public function getItemMeta() {
        \Tx_PtExtbase_Div::getLazyLoadedObject( $this->itemMeta );
        if ( ! $this->itemMeta instanceof ItemMeta ) {
            $this->itemMeta = $this->objectManager->get( 'DL\\Yag\\Domain\\Model\\ItemMeta' );
        }

        return $this->itemMeta;
    }


    /**
     * @param float $rating
     */
    public function setRating( $rating ) {
        $this->rating = $rating;
    }


    /**
     * @return float
     */
    public function getRating() {
        return $this->rating;
    }


    /**
     * Get image path by resolution config
     *
     * @param ResolutionConfig $resolutionConfig
     *
     * @return ResolutionFileCache
     */
    public function getResolutionByConfig( $resolutionConfig ) {
        if ( $resolutionConfig != null ) {
            return ResolutionFileCacheFactory::getInstance()->getItemFileResolutionPathByConfiguration( $this, $resolutionConfig );
        } else {
            return $this->getOriginalResolution();
        }
    }


    /**
     * Return an array of all resolutions of the currently active theme
     *
     * @return array
     */
    public function getResolutions() {
        $resolutionConfigs = ConfigurationBuilderFactory::getInstance()
                                                        ->buildThemeConfiguration()
                                                        ->getResolutionConfigCollection();

        $resolutions = array();

        foreach ( $resolutionConfigs as $resolutionName => $resolutionConfig ) {
            $resolutions[ $resolutionName ] = $this->getResolutionByConfig( $resolutionConfig );
        }

        return $resolutions;
    }


    /**
     * Get a resolutionFile that points to the original file path
     *
     * @return ResolutionFileCache
     */
    public function getOriginalResolution() {
        $resolutionFile = new ResolutionFileCache(
            $this,
            $this->sourceuri,
            $this->width,
            $this->height,
            100
        );

        return $resolutionFile;
    }


    /**
     * Getter for sorting
     *
     * @return int Sorting of item within an album
     */
    public function getSorting() {
        return $this->sorting;
    }


    /**
     * Setter for sorting. Sets position of item within an album
     *
     * @param int $sorting
     */
    public function setSorting( $sorting ) {
        $this->sorting = $sorting;
    }


    /**
     * Deletes item and its cached files from.
     *
     * @param bool $deleteCachedFiles If set to true, file cache for item is also deleted
     */
    public function delete( $deleteCachedFiles = true ) {
        // If we delete an item, we have to check, whether it has been the thumb of an album
        $resetThumb = false;

        if ( $this->getAlbum()->getThumb() !== null && $this->getAlbum()->getThumb()->getUid() == $this->getUid() ) {
            $resetThumb = true;
        }

        $this->objectManager->get( 'DL\\Yag\\Domain\\FileSystem\\FileManager' )->removeImageFileFromAlbumDirectory( $this );
        if ( $deleteCachedFiles ) {
            $this->deleteCachedFiles();
        }

        if ( $this->getItemMeta() ) {
            $itemMetaRepository = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\ItemMetaRepository' );
            /* @var $itemMetaRepository ItemMetaRepository */
            $itemMetaRepository->remove( $this->getItemMeta() );
        }

        $this->album->removeItem( $this );

        if ( $resetThumb ) {
            $this->album->setThumbToTopOfItems();
        }

        $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\AlbumRepository' )->update( $this->album );

        $itemRepository = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\ItemRepository' );
        /* @var $itemRepository ItemRepository */
        $itemRepository->remove( $this );
    }


    /**
     * Deletes cached files for item
     */
    public function deleteCachedFiles() {
        $resolutionFileCacheRepository = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\ResolutionFileCacheRepository' );
        /* @var $resolutionFileCacheRepository ResolutionFileCacheRepository */
        $resolutionFileCacheRepository->removeByItem( $this );
    }


    /**
     * Set this item as album thumb, if no thumbnail for album is existing
     *
     */
    public function setItemAsAlbumThumbIfNotExisting() {
        if ( $this->album->getThumb() == null ) {
            $this->album->setThumb( $this );
        }
    }


    /**
     * Returns TRUE if item is thumb of associated album, 0 else
     *
     * @return boolean TRUE if item is thumb of associated album
     */
    public function getIsAlbumThumb() {
        if ( $this->getAlbum() instanceof Album
             && $this->getAlbum()->getThumb() instanceof Item
             && $this->getAlbum()->getThumb()->getUid() === $this->uid
        ) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function setCategories( $categories ) {
        $this->categories = $categories;
    }


    /**
     * @return ObjectStorage
     */
    public function getCategories() {
        return $this->categories;
    }


    /**
     * Returns 1 if image is landscape, else returns 0
     *
     * @return int
     */
    public function getIsLandscape() {
        if ( $this->width > $this->height ) {
            return 1;
        } else {
            return 0;
        }
    }


    /**
     * @param $tagsAsCSV
     */
    public function setTagsFromCSV( $tagsAsCSV ) {
        $tags        = array_filter( GeneralUtility::trimExplode( ',', $tagsAsCSV ) );
        $currentTags = clone $this->tags;

        foreach ( $currentTags as $tag ) {
            /** @var Tag $tag */
            if ( ! in_array( trim( $tag->getName() ), $tags ) ) {
                $tag->decreaseCount();
                $this->tags->detach( $tag );
            }
        }

        foreach ( $tags as $tagName ) {
            $tagIsExistent = false;

            foreach ( $this->tags as $existentTag ) {
                /** @var Tag $existentTag */
                if ( $existentTag->getName() == $tagName ) {
                    $tagIsExistent = true;
                }
            }

            if ( ! $tagIsExistent ) {
                $tagToBeAdded = new Tag();

                $tagToBeAdded->setName( $tagName );
                $this->addTag( $tagToBeAdded );
            }
        }
    }


    /**
     * Add a list of tags separated by comma
     *
     * @param string $tagsAsCSV
     */
    public function addTagsFromCSV( $tagsAsCSV ) {
        $tags = array_filter( GeneralUtility::trimExplode( ',', $tagsAsCSV ) );

        foreach ( $tags as $tagName ) {
            $tag = new Tag();

            $tag->setName( $tagName );

            $this->addTag( $tag );
        }
    }


    /**
     * Build a csv string of all tags
     *
     * @param  string $separator
     *
     * @return string
     */
    public function getTagsSeparated( $separator = ', ' ) {
        $tagNames = array();

        foreach ( $this->tags as $tag ) {
            $tagNames[] = $tag->getName();
        }

        return implode( $separator, $tagNames );
    }


    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DL\Yag\Domain\Model\Tag>
     */
    public function getTags() {
        return $this->tags;
    }


    /**
     * @param $tags
     *
     * @return void
     */
    public function setTags( $tags ) {
        $this->tags = $tags;
    }


    /**
     * Add Tag if it is not already existing and update counter
     *
     * @param Tag the Tag to be added
     *
     * @return void
     */
    public function addTag( Tag $tag ) {
        $tagRepository = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\TagRepository' );
        $existingTag   = $tagRepository->findOneByName( $tag->getName() );
        /** @var Tag $existingTag */

        if ( $existingTag === null || $tag === $existingTag ) {
            $tag->setCount( 1 );
            $this->tags->attach( $tag );
        } else {
            $existingTag->increaseCount();
            $this->tags->attach( $existingTag );
        }
    }


    /**
     * @param Tag the Tag to be removed
     *
     * @return void
     */
    public function removeTag( Tag $tagToRemove ) {
        $tagRepository = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\TagRepository' );
        $existingTag   = $tagRepository->findOneByName( $tagToRemove->getName() );
        /** @var Tag $existingTag */

        if ( $existingTag instanceof Tag ) {
            $existingTag->decreaseCount();
        }

        $this->tags->detach( $tagToRemove );
    }


    /**
     * Returns true, if this image is owned by current fe_user
     *
     * @return bool
     */
    public function getIsMine() {
        if ( TYPO3_MODE == 'FE' && ! empty( $GLOBALS['TSFE']->fe_user->user['uid'] ) ) {
            $isMine = ( $GLOBALS['TSFE']->fe_user->user['uid'] == $this->feUserUid );

            return $isMine;
        }

        return false;
    }


    /**
     * @param string $link
     */
    public function setLink( $link ) {
        $this->link = $link;
    }


    /**
     * @return string
     */
    public function getLink() {
        return $this->link;
    }


    /**
     * @param string $originalFilename
     */
    public function setOriginalFilename( $originalFilename ) {
        $this->originalFilename = $originalFilename;
    }


    /**
     * @return string
     */
    public function getOriginalFilename() {
        return $this->originalFilename;
    }

    /**
     * @param \DateTime $crdate
     */
    public function setCrdate( $crdate ) {
        $this->crdate = $crdate;
    }

    /**
     * @return \DateTime
     */
    public function getCrdate() {
        return $this->crdate;
    }

    /**
     * @param \DateTime $tstamp
     */
    public function setTstamp( $tstamp ) {
        $this->tstamp = $tstamp;
    }

    /**
     * @return \DateTime
     */
    public function getTstamp() {
        return $this->tstamp;
    }
}
