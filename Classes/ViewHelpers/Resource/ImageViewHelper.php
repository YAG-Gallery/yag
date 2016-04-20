<?php
/***************************************************************
 * Copyright notice
 *
 *   2010 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
 * All rights reserved
 *
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace DL\Yag\ViewHelpers\Resource;

use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\Configuration\Image\ResolutionConfig;
use DL\Yag\Domain\Model\Item;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Viewhelper for rendering an URL of an image for a given item and a given resolution.
 *
 * Example:
 *
 * <yag:resource.image item="{item}" resolutionName="thumb">
 *
 * Only renders URL, no link action!
 *
 * @package    ViewHelpers
 * @subpackage Resource
 * @author     Daniel Lienert <typo3@lienert.cc>
 * @author     Michael Knoll <mimi@kaktusteam.de>
 */
class ImageViewHelper extends AbstractViewHelper {
    /**
     * @param Item    $item
     * @param null    $resolutionName
     * @param null    $width
     * @param null    $height
     * @param null    $quality
     * @param boolean $absolute
     *
     * @return string
     */
    public function render( Item $item, $resolutionName = null, $width = null, $height = null, $quality = null, $absolute = false ) {
        if ( $resolutionName ) {
            $resolutionConfig = ConfigurationBuilderFactory::getInstance()
                                                           ->buildThemeConfiguration()
                                                           ->getResolutionConfigCollection()->getResolutionConfig( $resolutionName );
        } elseif ( $width || $height ) {
            $resolutionSettings = array(
                'width'   => $width,
                'height'  => $height,
                'quality' => $quality
            );
            $resolutionConfig   = new ResolutionConfig( ConfigurationBuilderFactory::getInstance(), $resolutionSettings );
        } else {
            $resolutionConfig = null;
        }

        $imageResolution = $item->getResolutionByConfig( $resolutionConfig );

        if ( $absolute == true ) {
            $imageSource = $this->controllerContext->getRequest()->getBaseUri() . $imageResolution->getPath();
        } else {
            $imageSource = TYPO3_MODE === 'BE' ? '../' . $imageResolution->getPath() : $GLOBALS['TSFE']->absRefPrefix . $imageResolution->getPath();
        }


        return $imageSource;
    }
}
