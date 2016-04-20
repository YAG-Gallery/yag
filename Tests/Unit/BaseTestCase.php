<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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

namespace DL\Yag\Tests\Unit;

use DL\Yag\Domain\Configuration\ConfigurationBuilder;
use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\Model\Album;
use DL\Yag\Domain\Model\Gallery;
use DL\Yag\Domain\Model\Item;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Base testcase for all yag testcases
 *
 * @package Tests
 * @author  Michael Knoll <mimi@kaktsuteam.de>
 */
abstract class BaseTestCase extends UnitTestCase {
    /**
     * @var string
     */
    protected $extensionName = 'yag';

    /**
     * @var string
     */
    protected $sourceDirectory = __DIR__ . '/../../';

    /**
     * @var ConfigurationBuilder
     */
    protected $configurationBuilder;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;


    public function setUp() {
        $this->objectManager = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' );
    }


    /**
     * @return Item
     */
    protected function getTestItemObject() {
        $item    = new Item();
        $album   = new Album();
        $gallery = new Gallery();

        $album->setGallery( $gallery );
        $item->setAlbum( $album );

        $item->setSourceuri( $this->sourceDirectory . 'Tests/Unit/TestImages/' . 'testImage.jpg' );

        return $item;
    }


    /**
     * @param null $settings
     */
    protected function initConfigurationBuilderMock( $settings = null ) {
        if ( ! $settings ) {
            $tsFilePath = $this->sourceDirectory . 'Configuration/TypoScript/setup.txt';
            $typoscript = \Tx_PtExtbase_Div::loadTypoScriptFromFile( $tsFilePath );
            $settings   = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Service\\TypoScriptService' )->convertTypoScriptArrayToPlainArray( $typoscript );
            $settings   = $settings['plugin']['tx_yag']['settings'];
        }

        ConfigurationBuilderFactory::injectSettings( $settings );
        $this->configurationBuilder = ConfigurationBuilderFactory::getInstance( 'test', 'default' );
    }
}
