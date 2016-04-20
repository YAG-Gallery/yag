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
 * Class implements Tag domain object
 *
 * @package    Domain
 * @subpackage Model
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
class Tag extends AbstractEntity implements DomainModelInterface {
    /**
     * name
     *
     * @var string
     * @validate NotEmpty
     */
    protected $name;


    /**
     * count
     *
     * @var integer
     */
    protected $count;

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName( $name ) {
        $this->name = $name;
    }

    /**
     * @return integer
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @param integer $count
     *
     * @return void
     */
    public function setCount( $count ) {
        $this->count = $count;
    }

    /**
     * Increase the current count
     */
    public function increaseCount() {
        $this->count ++;
    }


    /**
     * Decrease the current count
     */
    public function decreaseCount() {
        if ( $this->count > 0 ) {
            $this->count --;
        }
    }
}
