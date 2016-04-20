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

namespace DL\Yag\Domain\Configuration\Image;

use DL\Yag\Domain\Configuration\ConfigurationBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class implementing factory for collection of filterbox configurations
 *
 * @author     Daniel Lienert <lienert@punkt.de>
 * @package    Domain
 * @subpackage Configuration\Image
 */
class ResolutionConfigCollectionFactory {
    /**
     * @param ConfigurationBuilder $configurationBuilder
     * @param                      $resolutionSettings
     *
     * @return ResolutionConfigCollection
     */
    public static function getInstance( ConfigurationBuilder $configurationBuilder, $resolutionSettings ) {
        $resolutionConfigCollection = new ResolutionConfigCollection();

        foreach ( $resolutionSettings as $resolutionName => $resolutionSetting ) {
            $resolutionSetting['name'] = $configurationBuilder->getTheme() . '.' . $resolutionName;
            $resolutionConfig          = new ResolutionConfig( $configurationBuilder, $resolutionSetting );
            $resolutionConfigCollection->addResolutionConfig( $resolutionConfig, $resolutionName );
        }

        return $resolutionConfigCollection;
    }

    /**
     * @static
     *
     * @param ConfigurationBuilder $configurationBuilder
     *
     * @return ResolutionConfigCollection
     */
    public static function getInstanceOfRegistrySelectedThemes( ConfigurationBuilder $configurationBuilder ) {
        $resolutionConfigCollection = self::getInstanceOfAllThemes( $configurationBuilder );

        $themesToBuild  = array( 'backend' );
        $selectedThemes = unserialize( GeneralUtility::makeInstance( 'TYPO3\\CMS\\Core\\Registry' )->get( 'tx_yag', 'rfcSelectedThemes', serialize( array() ) ) );

        if ( ! array_key_exists( '*', $selectedThemes ) ) {
            foreach ( $selectedThemes as $themeName => $isSelected ) {
                if ( $isSelected ) {
                    $themesToBuild[] = $themeName;
                }
            }

            $resolutionConfigCollection = $resolutionConfigCollection->extractCollectionByThemeList( $themesToBuild );
        }

        return $resolutionConfigCollection;
    }

    /**
     * @static
     *
     * @param ConfigurationBuilder $configurationBuilder
     *
     * @return ResolutionConfigCollection
     */
    public static function getInstanceOfAllThemes( ConfigurationBuilder $configurationBuilder ) {
        $allSettings = $configurationBuilder->getOrigSettings();
        $themes      = $allSettings['themes'];

        $resolutionConfigCollection = new ResolutionConfigCollection();

        foreach ( $themes as $themeName => $theme ) {
            if ( array_key_exists( 'resolutionConfigs', $theme ) && is_array( $theme['resolutionConfigs'] ) ) {
                foreach ( $theme['resolutionConfigs'] as $resolutionName => $resolutionSetting ) {
                    $resolutionSetting['name'] = $themeName . '.' . $resolutionName;
                    $resolutionConfig          = new ResolutionConfig( $configurationBuilder, $resolutionSetting );
                    $resolutionConfigCollection->addResolutionConfig( $resolutionConfig, $resolutionSetting['name'] );
                }
            }
        }

        return $resolutionConfigCollection;
    }
}
