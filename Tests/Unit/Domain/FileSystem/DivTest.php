<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2014 Daniel Lienert <typo3@lienert.cc>
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

namespace DL\Yag\Tests\Unit\Domain\FileSystem;

use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Tests\Unit\BaseTestCase;

/**
 * Testcase for filesystem div
 *
 * @package Tests
 * @subpackage Domain\FileSystem
 * @author Daniel Lienert
 */
class DivTest extends BaseTestCase
{
    /**
     * @var Div
     */
    protected $fileSystemDiv;

    /**
     * @var string
     */
    protected $testDirectory;


    public function setUp()
    {
        $this->testDirectory = \Tx_PtExtbase_Utility_Files::concatenatePaths(array(__DIR__, 'workspace'));
        mkdir($this->testDirectory);

        $this->fileSystemDiv = new Div();
    }

    public function tearDown()
    {
        \Tx_PtExtbase_Utility_Files::removeDirectoryRecursively($this->testDirectory);
    }


    /**
     * @return array
     */
    public function checkDirAndCreateIfMissingDataProvider()
    {
        $this->testDirectory = \Tx_PtExtbase_Utility_Files::concatenatePaths(array(__DIR__, 'workspace'));

        return array(
            'alreadyExisting' => array('directoryToCreate' => $this->testDirectory),
            'notExisting' => array('directoryToCreate' => \Tx_PtExtbase_Utility_Files::concatenatePaths(array($this->testDirectory, 'test1'))),
            'notExistingDeep' => array('directoryToCreate' => \Tx_PtExtbase_Utility_Files::concatenatePaths(array($this->testDirectory, 'test1', 'test2'))),
        );
    }

    /**
     * @test
     * @dataProvider checkDirAndCreateIfMissingDataProvider
     */
    public function checkDirAndCreateIfMissing($directoryToCreate)
    {
        $result = $this->fileSystemDiv->checkDirAndCreateIfMissing($directoryToCreate);

        $this->assertTrue($result);
        $this->assertTrue(is_dir($directoryToCreate));
    }
}
