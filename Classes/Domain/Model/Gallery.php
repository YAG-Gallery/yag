<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Michael Knoll <mimi@kaktusteam.de>
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

use DL\Yag\Domain\Repository\GalleryRepository;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class implements Gallery domain object
 *
 * @package    Domain
 * @subpackage Model
 */
class Gallery extends AbstractEntity implements DomainModelInterface {
    /**
     * Name of gallery
     *
     * @var string $name
     */
    protected $name;


    /**
     * If set to true, gallery will be hidden
     *
     * @var int
     */
    protected $hidden;


    /**
     * Description of gallery
     *
     * @var string $description
     */
    protected $description;


    /**
     * Date of gallery
     *
     * @var \DateTime $date
     */
    protected $date;


    /**
     * UID of fe user that owns gallery
     *
     * @var integer $feUserUid
     */
    protected $feUserUid;


    /**
     * UID of fe group that owns gallery
     *
     * @var integer $feGroupUid
     */
    protected $feGroupUid;


    /**
     * Holds albums for this gallery
     *
     * @lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DL\Yag\Domain\Model\Album> $albums
     */
    protected $albums;


    /**
     * Holds an album which is used as thumbnail for gallery
     *
     * @lazy
     * @var \DL\Yag\Domain\Model\Album $thumbAlbum
     */
    protected $thumbAlbum;


    /**
     * Sorting for gallery
     *
     * @var int
     */
    protected $sorting;


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
        $this->setDate( new \DateTime() );
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
        $this->albums = new ObjectStorage();
    }


    /**
     * Setter for name
     *
     * @param string $name Name of gallery
     *
     * @return void
     */
    public function setName( $name ) {
        $this->name = $name;
    }


    /**
     * Getter for name
     *
     * @return string Name of gallery
     */
    public function getName() {
        return $this->name;
    }


    /**
     * Setter for description
     *
     * @param string $description Description of gallery
     *
     * @return void
     */
    public function setDescription( $description ) {
        $this->description = $description;
    }


    /**
     * Getter for description
     *
     * @return string Description of gallery
     */
    public function getDescription() {
        return $this->description;
    }


    /**
     * Setter for date
     *
     * @param \DateTime $date Date of gallery
     *
     * @return void
     */
    public function setDate( \DateTime $date = null ) {
        $this->date = $date;
    }


    /**
     * Getter for date
     *
     * @return \DateTime Date of gallery
     */
    public function getDate() {
        return $this->date;
    }


    /**
     * Setter for feUserUid
     *
     * @param integer $feUserUid UID of fe user that owns gallery
     *
     * @return void
     */
    public function setFeUserUid( $feUserUid ) {
        $this->feUserUid = $feUserUid;
    }


    /**
     * Getter for feUserUid
     *
     * @return integer UID of fe user that owns gallery
     */
    public function getFeUserUid() {
        return $this->feUserUid;
    }


    /**
     * Setter for feGroupUid
     *
     * @param integer $feGroupUid UID of fe group that owns gallery
     *
     * @return void
     */
    public function setFeGroupUid( $feGroupUid ) {
        $this->feGroupUid = $feGroupUid;
    }


    /**
     * Getter for feGroupUid
     *
     * @return integer UID of fe group that owns gallery
     */
    public function getFeGroupUid() {
        return $this->feGroupUid;
    }


    /**
     * Setter for albums
     *
     * @param ObjectStorage $albums
     *
     * @internal param $ \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DL\Yag\Domain\Model\Album> $albums Holds albums
     *           for this gallery
     */
    public function setAlbums( ObjectStorage $albums ) {
        $this->albums = $albums;
    }


    /**
     * Getter for albums
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DL\Yag\Domain\Model\Album> Holds albums for this gallery
     */
    public function getAlbums() {
        return $this->albums;
    }


    /**
     * Adds a Album
     *
     * @param Album the Album to be added
     *
     * @return void
     */
    public function addAlbum( Album $album ) {
        $this->albums->attach( $album );
    }


    /**
     * Removes a Album
     *
     * @param Album the Album to be removed
     *
     * @return void
     */
    public function removeAlbum( Album $albumToRemove ) {
        $this->albums->detach( $albumToRemove );
    }


    /**
     * Returns an album designated as thumbnail for this gallery
     * If the album thumb was marked as hidden, return the first not hidden album
     *
     * @return Album Thumbnail album for gallery
     */
    public function getThumbAlbum() {
        $album = \Tx_PtExtbase_Div::getLazyLoadedObject( $this->thumbAlbum );

        if ( ! ( $album instanceof Album ) ) {
            if ( $this->albums->count() > 0 ) {
                $album = $this->albums->current();
            }
        }

        return $album;
    }


    /**
     * Setter for thumb album of this gallery. Given album is set as gallery thumb.
     *
     * @param Album $thumbAlbum
     */
    public function setThumbAlbum( Album $thumbAlbum ) {
        $this->thumbAlbum = $thumbAlbum;
    }


    /**
     * Getter for sorting
     *
     * @return int Sorting of gallery
     */
    public function getSorting() {
        return $this->sorting;
    }


    /**
     * Setter for gallery sorting
     *
     * @param int $sorting Sorting of gallery
     */
    public function setSorting( $sorting ) {
        $this->sorting = $sorting;
    }


    /**
     * Returns number of albums attached to this gallery
     *
     * @return int Number of albums attached to this gallery
     */
    public function getAlbumCount() {
        return count( $this->albums );
    }


    /**
     * Deletes an gallery. Deletes all albums, if parameter is set to true
     *
     * @param bool $deleteAlbums If set to true, all albums of gallery will be deleted
     */
    public function delete( $deleteAlbums = true ) {
        if ( $deleteAlbums ) {
            foreach ( $this->albums->toArray() as $album ) {
                /* @var $album Album */
                $this->removeAlbum( $album );
                $album->delete();
            }
        }

        $galleryRepository = $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\GalleryRepository' );
        /* @var $galleryRepository GalleryRepository */
        $galleryRepository->remove( $this );
    }


    /**
     * Sets thumb album to top of album
     */
    public function setThumbAlbumToTopOfAlbums() {
        if ( $this->albums->count() > 0 ) {
            $this->thumbAlbum = $this->albums->current();
        } else {
            $this->thumbAlbum = null;
        }
    }


    /**
     * Returns number of items in gallery
     *
     * @return int Number of items in gallery
     */
    public function getItemCount() {
        return $this->objectManager->get( 'DL\\Yag\\Domain\\Repository\\ItemRepository' )->countItemsInGallery( $this );
    }


    /**
     * @param int $hidden
     */
    public function setHidden( $hidden ) {
        $this->hidden = $hidden;
    }


    /**
     * @return int
     */
    public function getHidden() {
        return $this->hidden;
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
}
