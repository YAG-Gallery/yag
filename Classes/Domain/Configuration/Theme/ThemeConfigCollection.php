<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Daniel Lienert <lienert@punkt.de>, Michael Knoll <mimi@kaktsuteam.de>
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

namespace DL\Yag\Domain\Configuration\Theme;

/**
 * collection of resolution configs
 *
 * @package    Domain
 * @subpackage Configuration\Image
 *
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
class ThemeConfigCollection extends \Tx_PtExtbase_Collection_ObjectCollection {
    /**
     * @var string
     */
    protected $restrictedClassName = 'DL\\Yag\\Domain\\Configuration\\Theme\\ThemeConfiguration';


    /**
     * @param ThemeConfiguration $themeConfig
     * @param                    $themeName string
     *
     * @return void
     */
    public function addThemeConfig( ThemeConfiguration $themeConfig, $themeName ) {
        $this->addItem( $themeConfig, $themeName );
    }


    /**
     * @throws Exception ThemeConfiguration
     *
     * @param $themeName string
     *
     * @return mixed
     */
    public function getResolutionConfig( $themeName ) {
        if ( $this->hasItem( $themeName ) ) {
            return $this->getItemById( $themeName );
        } else {
            throw new Exception( 'The theme with name ' . $themeName . ' is not defined! 1316763550' );
        }
    }
}
