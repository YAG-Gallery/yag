<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Daniel Lienert
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

namespace DL\Yag\ViewHelpers\Form;

use TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper;

class CategoryViewHelper extends SelectViewHelper {
    /**
     * @var array
     */
    protected static $categoryDataCache = array();
    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * Initialize arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments() {
        parent::initializeArguments();

        $this->registerTagAttribute( 'categoryPid', 'integer', 'The Pid, where the categories should be taken from', true );
        $this->overrideArgument( 'options', 'array', 'Associative array with internal IDs as key, and the values are displayed in the select box', false );
    }


    /**
     * @return string
     */
    public function render() {
        $this->arguments['options'] = $this->buildOptions( $this->buildCategoryData() );

        return parent::render();
    }


    /**
     * @param $categories
     *
     * @return array
     */
    protected function buildOptions( $categories ) {
        $options = array();

        foreach ( $categories as $category ) {
            /** @var \TYPO3\CMS\Extbase\Domain\Model\Category $category */
            $options[ $category->getUid() ] = $category->getTitle();
        }

        return $options;
    }


    /**
     * @return array
     */
    protected function buildCategoryData() {
        $pid = (int) $this->arguments['categoryPid'];

        if ( ! array_key_exists( $pid, self::$categoryDataCache ) ) {
            self::$categoryDataCache[ $pid ] = $this->categoryRepository->findByPid( $pid );
        }

        return self::$categoryDataCache[ $pid ];
    }
}
