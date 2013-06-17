<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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

/**
 * Testcase for Importbuilder
 *
 * @package Tests
 * @subpackage Domain\Import
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Tests_Domain_Import_ImportBuilderTest extends Tx_Yag_Tests_BaseTestCase {

	/**
	 * @var Tx_Yag_Domain_Import_ImporterBuilder
	 */
	protected $importerBuilder;

	public function setUp() {
		$this->initConfigurationBuilderMock();
		$this->importerBuilder = Tx_Yag_Domain_Import_ImporterBuilder::getInstance();
	}

	/**
	 * @test
	 */
	public function createImporter() {

		$accessibleImporter = $this->buildAccessibleProxy('Tx_Yag_Domain_Import_FileImporter_Importer');

		$importer = $this->importerBuilder->createImporter($accessibleImporter);

		$this->assertInstanceOf($accessibleImporter, $importer);
		$this->assertInstanceOf('Tx_Yag_Domain_Configuration_ConfigurationBuilder', $importer->_get('configurationBuilder'));
		$this->assertInstanceOf('Tx_Extbase_Persistence_Manager', $importer->_get('persistenceManager'));
		$this->assertInstanceOf('Tx_Yag_Domain_ImageProcessing_AbstractProcessor', $importer->_get('imageProcessor'));
		$this->assertInstanceOf('Tx_Yag_Domain_Repository_ItemRepository', $importer->_get('itemRepository'));
		$this->assertInstanceOf('Tx_Yag_Domain_Repository_ItemMetaRepository', $importer->_get('itemMetaRepository'));
		$this->assertInstanceOf('Tx_Extbase_Persistence_Manager', $importer->_get('persistenceManager'));
		$this->assertInstanceOf('Tx_Yag_Domain_FileSystem_FileManager', $importer->_get('fileManager'));

	}
	
}

?>