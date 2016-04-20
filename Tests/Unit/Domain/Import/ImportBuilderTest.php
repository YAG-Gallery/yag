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

namespace DL\Yag\Tests\Unit\Domain\Import;

use DL\Yag\Domain\Import\ImporterBuilder;
use DL\Yag\Tests\Unit\BaseTestCase;

/**
 * Testcase for Importbuilder
 *
 * @package Tests
 * @subpackage Domain\Import
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class ImportBuilderTest extends BaseTestCase
{
    /**
     * @var ImporterBuilder
     */
    protected $importerBuilder;

    public function setUp()
    {
        $this->initConfigurationBuilderMock();
        $this->importerBuilder = ImporterBuilder::getInstance();
    }

    /**
     * @test
     */
    public function createImporter()
    {
        $accessibleImporter = $this->buildAccessibleProxy('DL\\Yag\\Domain\\Import\\FileImporter\\Importer');

        $importer = $this->importerBuilder->createImporter($accessibleImporter);

        $this->assertInstanceOf($accessibleImporter, $importer);
        $this->assertInstanceOf('DL\\Yag\\Domain\\Configuration\\ConfigurationBuilder', $importer->_get('configurationBuilder'));
        $this->assertInstanceOf('DL\\Yag\\Domain\\ImageProcessing\\AbstractProcessor', $importer->_get('imageProcessor'));
        $this->assertInstanceOf('DL\\Yag\\Domain\\Repository˜˜ItemRepository', $importer->_get('itemRepository'));
        $this->assertInstanceOf('DL\\Yag\\Domain\\Repository\\ItemMetaRepository', $importer->_get('itemMetaRepository'));
        $this->assertInstanceOf('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager', $importer->_get('persistenceManager'));
        $this->assertInstanceOf('TDL\\Yag\\Domain\\FileSystem˜˜FileManager', $importer->_get('fileManager'));
    }
}
