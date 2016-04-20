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

namespace DL\Yag\Tests\Unit\Domain\Import\DirectoryImporter;

use DL\Yag\Domain\Import\DirectoryImporter\Importer;
use DL\Yag\Tests\Unit\BaseTestCase;

/**
 * Testcase for directory importer
 *
 * @package Tests
 * @subpackage Domain\Import\DirectoryImporter
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class ImporterTest extends BaseTestCase
{
    /**
     * @test
     */
    public function constructThrowsExceptionOnNonExistingDirectory()
    {
        try {
            $importer = new Importer();
            $importer->setDirectory('asdfasdfasdf');
        } catch (\Exception $e) {
            return;
        }
        $this->fail('No Exception has been thrown on constructing with non-existing directory');
    }
    
    
    
    /**
     * @test
     */
    public function constructReturnsImporterForGivenDirectory()
    {
        $importer = new Importer();
        $importer->setDirectory(getcwd());
        $this->assertEquals($importer->getDirectory(), getcwd());
    }
}
