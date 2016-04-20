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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class implements a ResolutionItemFileRelation domain object. For each item a file is stored
 * for each resolution an item is associated with by its album. This class implements an
 * attributed association that combines an item, its resolution and the according item file for this
 * resolution.
 *
 * @author     Michael Knoll <mimi@kaktusteam.de>
 * @author     Daniel Lienert <typo3@lienert.cc>
 * @package    Domain
 * @subpackage Model
 */
class ResolutionFileCache extends AbstractEntity implements DomainModelInterface {
    /**
     * Width of cached file
     *
     * @var integer $width
     */
    protected $width;


    /**
     * Height of cached file
     *
     * @var integer $height
     */
    protected $height;


    /**
     * Path to cached file
     *
     * @var string $path
     */
    protected $path;


    /**
     * Item to which resolution file cache belongs to
     *
     * @lazy
     * @var \DL\Yag\Domain\Model\Item $item
     */
    protected $item;


    /**
     * Identifies this resolution
     *
     * @var string $paramhash
     */
    protected $paramhash;


    /**
     * Constructor for resolution item file relation
     *
     * @param Item   $item   Item for which file is cached
     * @param string $path   Path to cached file
     * @param int    $width  Width of cached file
     * @param int    $height Height of cached file
     * @param        $paramhash
     */
    public function __construct( Item $item = null, $path = '', $width = 0, $height = 0, $paramhash = '' ) {
        $this->item      = $item;
        $this->path      = $path;
        $this->height    = $height;
        $this->width     = $width;
        $this->paramhash = $paramhash;
    }

    /**
     * Getter for width
     *
     * @return integer Width of cached file
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Setter for width
     *
     * @param integer $width Width of cached file
     *
     * @return void
     */
    public function setWidth( $width ) {
        $this->width = $width;
    }

    /**
     * Getter for height
     *
     * @return integer Height of cached file
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Setter for height
     *
     * @param integer $height Height of cached file
     *
     * @return void
     */
    public function setHeight( $height ) {
        $this->height = $height;
    }

    /**
     * Getter for path
     *
     * @return string Path to cached file
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Setter for path
     *
     * @param string $path Path to cached file
     *
     * @return void
     */
    public function setPath( $path ) {
        $this->path = $path;
    }

    /**
     * Getter for paramhash
     *
     * @return string $paramhash
     */
    public function getparamhash() {
        return $this->paramhash;
    }

    /**
     * Setter for the paramhash
     *
     * @paramhash string $name Name of this config
     * @param $paramhash
     */
    public function setparamhash( $paramhash ) {
        $this->paramhash = $paramhash;
    }

    /**
     * Getter for item
     *
     * @return Item Item to which resolution file cache belongs to
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * Setter for item
     *
     * @param Item $item Item to which resolution file cache belongs to
     *
     * @return void
     */
    public function setItem( Item $item ) {
        $this->item = $item;
    }
}
