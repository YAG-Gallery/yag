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

namespace DL\Yag\Tests\Unit\Domain\Import\MetaData;

use DL\Yag\Domain\Import\MetaData\ExifParser;
use DL\Yag\Tests\Unit\BaseTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Testcase for directory importer
 *
 * @package Tests
 * @subpackage Domain\Import\DirectoryImporter
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class ExifParserTest extends BaseTestCase
{
    /**
     * @return array
     */
    public function exifDataProvider()
    {
        return array(
            'TestSet1' => array(
                'exifData' => array(
                    'ShutterSpeedValue' => '8643856/1000000',
                    'DateTimeOriginal' => '2010:11:05 14:11:37',
                ),
                'parseResult' => array(
                    'ShutterSpeedValue' => '1/400s',
                    'DateTimeOriginal' => '2010:11:05 14:11:37',
                )
            )
        );
    }


    
    /**
     * @test
     */
    public function classExists()
    {
        $this->assertTrue(class_exists('DL\\Yag\\Domain\\Import\\MetaData\\ExifParser'));
    }


    /**
     * @test
     */
    public function readExifData()
    {
        $filePath = GeneralUtility::getFileAbsFileName($this->getTestItemObject()->getSourceuri());
        if (function_exists('exif_read_data')) {
            $exifArray = exif_read_data($filePath);
        }

        $this->assertTrue(is_array($exifArray));
    }


    /**
     * @test
     * @dataProvider exifDataProvider
     */
    public function calculateCaptureTimeStamp($exifData, $parseResult)
    {
        $exifParserMock = $this->getExifParserMock();
        $captureTimeStamp = $exifParserMock->_callRef('calculateCaptureTimeStamp', $exifData);

        $this->assertEquals($captureTimeStamp, 1288962697);
    }


    /**
     * @test
     * @dataProvider exifDataProvider
     */
    public function calculateShutterSpeed($exifData, $parseResult)
    {
        $exifParserMock = $this->getExifParserMock();
        $shutterSpeed = $exifParserMock->_callRef('calculateShutterSpeed', $exifData);

        $this->assertEquals($shutterSpeed, $parseResult['ShutterSpeedValue']);
    }


    /**
     * @return ExifParser
     */
    protected function getExifParserMock()
    {
        $proxyClassName = $this->buildAccessibleProxy('DL\\Yag\\Domain\\Import\\MetaData\\ExifParser');
        return new $proxyClassName;
    }
}
