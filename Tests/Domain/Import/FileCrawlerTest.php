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
 * Testcase for File Crawler
 *
 * @package Tests
 * @subpackage Domain\Import
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class Tx_Yag_Tests_Domain_Import_FileCrawlerTest extends Tx_Yag_Tests_BaseTestCase {

	/**
	 * Holds an instance of file crawler to be tested
	 *
	 * @var Tx_Yag_Domain_Import_FileCrawler
	 */
	protected $fixture;
	
	
	
	/**
	 * Sets up testcase
	 */
	public function setUp() {
		$configurationBuilder = Tx_Yag_Tests_DefaultTsConfig::getInstance()->getDefaultConfigurationBuilder();
        $this->fixture = new Tx_Yag_Domain_Import_FileCrawler($configurationBuilder->buildCrawlerConfiguration());
	}
	
	
	
	/**
	 * @test
	 */
	public function classExists() {
		$this->assertTrue(class_exists('Tx_Yag_Domain_Import_FileCrawler'));
	}
	
	
	
	/**
	 * @test
	 */
	public function getFilesForGivenDirectoryThrowsExceptionForNonExistingDirectory() {
		try {
			$this->fixture->getFilesForGivenDirectory('asdfasdfasdf');
		} catch(Exception $e) {
			return;
		}
		$this->fail('No Exception has been thrown on non-existing directory');
	}
	
	
	
	/**
	 * @test
	 */
	public function getFilesForGivenDirectoryThrowsNoExceptionForExistingDirectory() {
		try {
			$this->fixture->getFilesForGivenDirectory(getcwd());
		} catch(Exception $e) {
	        $this->fail('An Exception has been thrown on an existing directory');
        }
	}
	
	
	
	/**
	 * @test
	 */
	public function getFilesForGivenDirectoryReturnsFilesForDirectory() {
		$testingDirectory = PATH_site . 'typo3conf/ext/yag/Tests/Domain/Import/FilesForCrawlerTest';
		$crawledFiles = $this->fixture->getFilesForGivenDirectory($testingDirectory);
		$this->assertTrue(in_array($testingDirectory.'/test1.jpg', $crawledFiles));
		$this->assertTrue(in_array($testingDirectory.'/test2.jpg', $crawledFiles));
		$this->assertTrue(in_array($testingDirectory.'/test3.jpeg', $crawledFiles));
		$this->assertTrue(!in_array($testingDirectory.'/test4.nonjpg', $crawledFiles));
	}
	
}

?>