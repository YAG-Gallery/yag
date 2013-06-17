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
 * Testcase for hash filesystem
 *
 * @package Tests
 * @subpackage Domain\FileSystem
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class Tx_Yag_Tests_Domain_FileSystem_HashFileSystemTest extends Tx_Yag_Tests_BaseTestCase {
	
	/**
	 * Holds an instance of hash file system for testing
	 *
	 * @var Tx_Yag_Domain_Filehandling_HashFileSystem
	 */
	protected $fixture;
	
	
	
	/**
	 * Sets up testcase
	 */
	public function setUp() {
		$this->fixture = new Tx_Yag_Domain_FileSystem_HashFileSystem('fileadmin');
	}
	
	
	
	/**
	 * @test
	 */
	public function hashFileSystemThrowsExceptionOnConstructForNonExistingDirectory() {
		try{
			new Tx_Yag_Domain_FileSystem_HashFileSystem('asdfasdfasdf');
		} catch(Exception $e) {
			return;
		}
		$this->fail('No Exception has been thrown on trying to construct hfs with non existing directory');
	}
	
	
	
	/**
	 * @test
	 */
	public function getRelativePathByIdReturnsCorrectPathForGivenIdLessThan100() {
		$this->assertEquals($this->fixture->getRelativePathById(1),'00');
		$this->assertEquals($this->fixture->getRelativePathById(99),'00');
	}
	
	
	
	/**
	 * @test
	 */
	public function getRelativePathByIdReturnsCorrectPathForGivenIdAbove100() {
		$this->assertEquals($this->fixture->getRelativePathById(100),'01');
		$this->assertEquals($this->fixture->getRelativePathById(10999), '01/09');
	}
	
	
	
	/**
	 * @test
	 */
	public function getAbsolutePathByIdReturnsCorrectPathForGivenId() {
		$this->assertEquals(PATH_site . $this->fixture->getAbsolutePathById(1), PATH_site . 'fileadmin/00');
	}
     
}

?>