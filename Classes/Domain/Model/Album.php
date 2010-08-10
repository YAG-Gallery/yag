<?php

/***************************************************************
*  Copyright notice
*
*  (c) "now" could not be parsed by DateTime constructor. Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*  			 
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

/**
 * Album containing multiple images
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


/**
 * An album
 * 
 * @scope prototype
 * @entity
 */
class Tx_Yag_Domain_Model_Album extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * title
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;
	
	
	
	/**
	 * description
	 * @var string
	 */
	protected $description;
	
	
	
	/**
	 * date
	 * @var integer
	 */
	protected $date;
	
	
	
	/**
	 * images belonging to this album
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Image>
	 */
	protected $images;
	
	
	
	/**
	 * cover image file object
	 * @var Tx_Yag_Domain_Model_Image
	 */
	protected $cover;
	
	
	
	/**
	 * width of single images in this album
	 * @var int
	 */
	protected $singleWidth;
	
	
	
	/**
	 * height of single images in this album
	 * @var int
	 */
	protected $singleHeight;
	
	
	
	/**
	 * width of thumbs in this album
	 * @var int
	 */
	protected $thumbWidth;
	
	
	
	/**
	 * height of thumbs in this album
	 * @var int
	 */
	protected $thumbHeight;
	
	
	
	/**
	 * Constructor. Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 */
	public function __construct() {
		$this->images = new Tx_Extbase_Persistence_ObjectStorage();
	}
	
	
    
	/**
	 * Returns images according to pager settings
	 *
	 * @param Tx_Yag_Lib_AlbumPager $pager Pager to page 
	 * @return Tx_Extbase_Persistence_ObjectStorage    Collection of images
	 */
	public function getPagedImages(Tx_Yag_Lib_PagerInterface $pager) {
		// Show all pages, if requested
		if ($pager->getCurrentPageNumber() == 'all') {
			return $this->images;
		}
		
		// page number starts with 1, so first offset should be 0!
		$offset = ($pager->getCurrentPageNumber() - 1) * $pager->getItemsPerPage();
		$limit = $pager->getItemsPerPage();
		$pagedImages = new Tx_Extbase_Persistence_ObjectStorage();
		$i = 1;
		foreach($this->images as $image) {
			if ($i >= $offset && $limit > 0) {
				$pagedImages->attach($image);
				$limit--;
			}
			$i++; 
		}
		return $pagedImages;
	}


	
	/**
	 * Getter for title
	 *
	 * @return string title
	 */
	public function getTitle() {
		return $this->title;
	}
	
	

	/**
	 * Setter for title
	 *
	 * @param string $title title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}
	
	
	
	/**
	 * Getter for description
	 *
	 * @return string description
	 */
	public function getDescription() {
		return $this->description;
	}
	
	

	/**
	 * Setter for description
	 *
	 * @param string $description description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	
	
	/**
	 * Getter for date
	 *
	 * @return integer date
	 */
	public function getDate() {
		return $this->date;
	}
	
	

	/**
	 * Setter for date
	 *
	 * @param integer $date date
	 * @return void
	 */
	public function setDate($date) {
		$this->date = $date;
	}
	
	
	
	/**
	 * Getter for images
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Image> images
	 */
	public function getImages() {
		return $this->images;
	}
	
	

	/**
	 * Setter for images
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Yag_Domain_Model_Image> $images images
	 * @return void
	 */
	public function setImages(Tx_Extbase_Persistence_ObjectStorage $images) {
		$this->images = $images;
	}
	
	
	
    /**
     * Getter for cover image file object
     * 
     * @return Tx_Yag_Domain_Model_Image
     */
    public function getCover() {
        return $this->cover;
    }
    
    
    
    /**
     * Setter for cover image file object
     * 
     * @param Tx_Yag_Domain_Model_Image $cover
     */
    public function setCover($cover) {
        $this->cover = $cover;
    }
    
    
    
	/**
	 * @return int
	 */
	public function getSingleHeight() {
		return $this->singleHeight;
	}
	
	
	
	/**
	 * @param int $singleHeight
	 */
	public function setSingleHeight($singleHeight) {
		$this->singleHeight = $singleHeight;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getSingleWidth() {
		return $this->singleWidth;
	}
	
	
	
	/**
	 * @param int $singleWidth
	 */
	public function setSingleWidth($singleWidth) {
		$this->singleWidth = $singleWidth;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getThumbHeight() {
		return $this->thumbHeight;
	}
	
	
	
	/**
	 * @param int $thumbHeight
	 */
	public function setThumbHeight($thumbHeight) {
		$this->thumbHeight = $thumbHeight;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getThumbWidth() {
		return $this->thumbWidth;
	}
	
	
	
	/**
	 * @param int $thumbWidth
	 */
	public function setThumbWidth($thumbWidth) {
		$this->thumbWidth = $thumbWidth;
	}

    
    
    /**
     * Sets cover image by image UID
     *
     * @param int $coverImageUid    UID of image to set as album's cover image
     */
    public function setCoverByUid($coverImageUid) {
    	$imageRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ImageRepository'); /* @var $imageRepository Tx_Yag_Domain_Repository_ImageRepository */
    	$newCoverImage = $imageRepository->findByUid(intval($coverImageUid));
    	$this->setCover($newCoverImage);
    }
    
    
	
    /**
     * Adds a new image to album's images
     *
     * @param Tx_Yag_Domain_Model_Image $image              Image to be added to the album
     * @param bool                      $avoidDuplicates    If set to true, an image won't be added, if it's already contained in the album
     */
    public function addImage(Tx_Yag_Domain_Model_Image $image, $avoidDuplicates = true) {
    	if ($avoidDuplicates) {
    	   foreach($this->images as $attachedImage) {  /* @var $attachedImage Tx_Yag_Domain_Model_Image */
    	       if ($image->getSingle()->getFilePath() == $attachedImage->getSingle()->getFilePath())
    	           return;	
    	   }
    	}
        $this->images->attach($image);
    }
    
    
    
    /**
     * Returns previous image in current album's images for given image
     *
     * @param Tx_Yag_Domain_Model_Image $image      Image to find predecessor for
     * @return Tx_Yag_Domain_Model_Image    Predecessor for given image
     */
    public function getPrevImage(Tx_Yag_Domain_Model_Image $image) {
    	$prevImage = null;
    	$i = 0;
    	foreach ($this->images as $currImage) {
    		if ($image == $currImage && $i == 0)
    		    // given image is first image in album's images
    		    return null;
    		elseif ($currImage == $image)  
    		    // given image is found, so return predecessor
    		    return $prevImage;
    		else 
    		    // given image is not found, so save current image for next loop run
    		    $prevImage = $currImage;
    		$i++;
    	}
    	return null;
    }
    
    
    
    /**
     * Returns next image in current album's images for given image
     *
     * @param Tx_Yag_Domain_Model_Image $image  Image to find successor for
     * @return Tx_Yag_Domain_Model_Image    Successor of given image
     */
    public function getNextImage(Tx_Yag_Domain_Model_Image $image) {
    	$i = 0;
    	$returnNext = false;
        foreach ($this->images as $currImage) {
        	if ($returnNext)
        	    return $currImage;
            if ($currImage == $image && $i < $this->images->count() - 1)
                $returnNext = true;
        }
        return null;
    }
    
    
    
    /**
     * Returns number of images in album
     *
     * @return int  Number of images in album
     */
    public function getImageCount() {
    	return $this->images->count();
    }
    
    
    
    /**
     * Updates images associated with album by a given
     * request array.
     *
     * @param array $requestArray   Request array with information of images
     * @return void
     */
    public function updateImagesByRequestArray($requestArray) { 
    	foreach($this->images as $image) { /* @var $image Tx_Yag_Domain_Model_Image */
    		if (array_key_exists($image->getUid(), $requestArray)) {
    			$image->updateImageByRequestParams($requestArray[$image->getUid()]);
    		}
    	}
    }
    
    
    
    /**
     * Deletes images from album that are marked to be deleted in 
     * requestArray
     *
     * @param array $requestArray   Request array with information of images
     */
    public function deleteImagesByRequestArray($requestArray) {
    	$imagesToRemove = array();
        foreach($this->images as $image) { /* @var $image Tx_Yag_Domain_Model_Image */
        	// check whether image should be deleted
            if (array_key_exists($image->getUid(), $requestArray)) {
            	if (array_key_exists('delete', $requestArray[$image->getUid()])) {
            		if ($requestArray[$image->getUid()]['delete'] == 1) {
            			$imagesToRemove[] = $image;
            		}
            	}
            }
        }
        foreach($imagesToRemove as $imageToRemove) {
        	$this->images->detach($imageToRemove);
        }
    }
    
}
?>