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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Base testcase for all yag testcases
 *
 * @package Tests
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
abstract class Tx_Yag_Tests_BaseTestCase extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var string
     */
    protected $extensionName = 'yag';

    /**
     * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
     */
    protected $configurationBuilder;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;



    public function setUp()
    {
        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
    }


    /**
     * @return Tx_Yag_Domain_Model_Item
     */
    protected function getTestItemObject()
    {
        $item = new Tx_Yag_Domain_Model_Item();
        $album = new Tx_Yag_Domain_Model_Album();
        $gallery = new Tx_Yag_Domain_Model_Gallery();

        $album->setGallery($gallery);
        $item->setAlbum($album);

        $item->setSourceuri(substr(ExtensionManagementUtility::extPath($this->extensionName) . 'Tests/Unit/TestImages/', strlen(PATH_site)) . 'testImage.jpg');


        return $item;
    }


    /**
     * @param null $settings
     */
    protected function initConfigurationBuilderMock($settings = null)
    {
        if (!$settings) {
            $tsFilePath = ExtensionManagementUtility::extPath($this->extensionName) . 'Configuration/TypoScript/setup.txt';
            $typoscript = Tx_PtExtbase_Div::loadTypoScriptFromFile($tsFilePath);
            $settings = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Service\\TypoScriptService')->convertTypoScriptArrayToPlainArray($typoscript);
            $settings = $settings['plugin']['tx_yag']['settings'];
        }

        Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::injectSettings($settings);
        $this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance('test', 'default');
    }
}
