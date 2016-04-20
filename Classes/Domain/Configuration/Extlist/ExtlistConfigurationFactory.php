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

namespace DL\Yag\Domain\Configuration\Extlist;

use DL\Yag\Domain\Configuration\ConfigurationBuilder;

/**
 * Factory for extlist configuration
 *
 * @package    Domain
 * @subpackage Configuration\Extlist
 * @author     Daniel Lienert <typo3@lienert.cc>
 * @author     Michael Knoll <mimi@kaktusteam.de>
 */
class ExtlistConfigurationFactory {
    /**
     * Returns an instance of extlist configuration
     *
     * @param ConfigurationBuilder $configurationBuilder
     *
     * @return ExtlistConfiguration
     */
    public static function getInstance( ConfigurationBuilder $configurationBuilder ) {
        $extlistSettings = $configurationBuilder->getSettingsForConfigObject( 'extlist' );

        return new ExtlistConfiguration( $configurationBuilder, $extlistSettings );
    }
}
