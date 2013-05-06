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
 * Testcase for Abstract Importer
 *
 * @package Tests
 * @subpackage Domain\Import
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Tests_Domain_Import_AbstractImporterTest extends Tx_Yag_Tests_BaseTestCase {

	/**
	 * @var Tx_Yag_Domain_Import_AbstractImporter
	 */
	protected $fixture;
	
	
	
	/**
	 * Sets up testcase
	 */
	public function setUp() {
		$this->fixture = $this->getMockForAbstractClass($this->buildAccessibleProxy('Tx_Yag_Domain_Import_AbstractImporter'));
	}
	
	
	
	/**
	 * @test
	 */
	public function classExists() {
		$this->assertTrue(class_exists('Tx_Yag_Domain_Import_AbstractImporter'));
	}



	/**
	 * @return array
	 */
	public function processTitleFromFileNameDataProvider() {
		return array(
			array('fileName' => 'Cambodia.jpg', 'expectedTitle' => 'Cambodia'),
			array('fileName' => 'cambodia.jpg', 'expectedTitle' => 'Cambodia'),
			array('fileName' => 'Angkor_Wat.jpg', 'expectedTitle' => 'Angkor Wat'),
			array('fileName' => 'Angkor.Wat.jpg', 'expectedTitle' => 'Angkor Wat'),
		);
	}



	/**
	 * @test
	 * @param $fileName
	 * @param $expectedTitle
	 * @dataProvider processTitleFromFileNameDataProvider
	 */
	public function processTitleFromFileName($fileName, $expectedTitle) {
		$actual = $this->fixture->_call('processTitleFromFileName', $fileName);
		$this->assertEquals($expectedTitle, $actual);
	}

	

	/**
	 * @test
	 */
	public function processStringFromMetaData() {

		$titleFormat = array(
			'_typoScriptNodeValue' => 'TEXT',
			'dataWrap' => '{field:fileName} by {field:artist}'
		);

		$itemMeta = new Tx_Yag_Domain_Model_ItemMeta();
		$itemMeta->setCaptureDate(new DateTime('2012-10-08'));
		$itemMeta->setArtist('Daniel Lienert');

		$item = new Tx_Yag_Domain_Model_Item();
		$item->setOriginalFilename('test.jpg');
		$item->setFilename('test.jpg');
		$item->setItemMeta($itemMeta);

		$formattedString = $this->fixture->_call('processStringFromMetaData', $item, $titleFormat);

		$this->assertEquals('Test by Daniel Lienert', $formattedString);

	}


	/**
	 * @test
	 */
	public function processStringFromMetaDataWithOverwrite() {

		$this->markTestSkipped('Single Run of test passes whereas two tests in row semm to have a side effect on the cObj creation / usage');

		$titleFormat = array(
			'_typoScriptNodeValue' => 'TEXT',
			'dataWrap' => '{field:fileName} by {field:artist}'
		);

		$itemMeta = new Tx_Yag_Domain_Model_ItemMeta();
		$itemMeta->setCaptureDate(new DateTime('2012-10-08'));
		$itemMeta->setArtist('Daniel Lienert');

		$item = new Tx_Yag_Domain_Model_Item();
		$item->setOriginalFilename('test.jpg');
		$item->setFilename('test.jpg');
		$item->setItemMeta($itemMeta);

		$overWriteVars = array('artist' => 'Daniel');

		$formattedString = $this->fixture->_call('processStringFromMetaData', $item, $titleFormat, $overWriteVars);

		$this->assertEquals('Test by Daniel', $formattedString);

	}

}

?>