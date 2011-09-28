<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <knoll@punkt.de>
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
 * Testcase for directory importer
 *
 * @package Tests
 * @subpackage Domain\Import\DirectoryImporter
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Tests_Domain_Import_MetaData_ExifParser_testcase extends Tx_Yag_Tests_BaseTestCase {

	protected $exifArray;


	public function setUp() {
		$this->exifArray = array('ShutterSpeedValue' => '8643856/1000000');
	}

	/**
	 * @test
	 */
	public function classExists() {
		$this->assertTrue(class_exists('Tx_Yag_Domain_Import_MetaData_ExifParser'));
	}


	/**
	 * @test
	 */
	public function calculateShutterSpeed() {
		$exifParserMock = $this->getExifParserMock();
		$shutterSpeed = $exifParserMock->_callRef('calculateShutterSpeed', $this->exifArray);

		$this->assertEquals($shutterSpeed, '1/400s');
	}


	


	/**
	 * @return Tx_Yag_Domain_Import_MetaData_ExifParser
	 */
	protected function getExifParserMock() {
		$proxyClassName = $this->buildAccessibleProxy('Tx_Yag_Domain_Import_MetaData_ExifParser');
		return new $proxyClassName;
	}
	
}

?>