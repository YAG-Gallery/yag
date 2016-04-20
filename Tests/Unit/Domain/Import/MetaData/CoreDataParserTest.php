<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2014 Daniel Lienert <typo3@lienert.cc>
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

use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Domain\Import\MetaData\CoreDataParser;
use DL\Yag\Tests\Unit\BaseTestCase;

/**
 * Testcase for directory importer
 *
 * @package Tests
 * @subpackage Domain\Import\DirectoryImporter
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class CoreDataParserTest extends BaseTestCase
{
    /**
     * @var CoreDataParser
     */
    protected $coreDataParser;


    public function setUp()
    {
        parent::setUp();

        $accessibleClassName = $this->buildAccessibleProxy('DL\\Yag\\Domain\\Import\\MetaData\\CoreDataParser');
        $this->coreDataParser = $this->objectManager->get($accessibleClassName);
    }

    
    /**
     * @test
     */
    public function classExists()
    {
        $this->assertTrue(class_exists('DL\\Yag\\Domain\\Import\\MetaData\\CoreDataParser'));
    }


    /**
     * @test
     */
    public function parseCoreData()
    {
        $item = $this->getTestItemObject();

        $actual = $this->coreDataParser->parseCoreData(Div::makePathAbsolute($item->getSourceuri()));

        $this->assertEquals(240, $actual['dpi']);
        $this->assertTrue(in_array($actual['colorSpace'], array('RGB', 'sRGB')));
    }


    public function parseDPIDataProvider()
    {
        return array(
            '720000/10000' => array('data' => array('X Resolution' => '720000/10000'), 'expected' => 72),
        );
    }


    /**
     * @test
     *
     * @param $data
     * @param $expected
     * @dataProvider parseDPIDataProvider
     */
    public function parseDPI($data, $expected)
    {
        $actual = $this->coreDataParser->_call('parseDPI', $data);
        $this->assertEquals($expected, $actual);
    }
}
