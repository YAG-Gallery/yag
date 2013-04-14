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
 * Testcase for pid detector
 *
 * @package Tests
 * @subpackage Utility
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class Tx_Yag_Tests_Utility_PidDetector_testcase extends Tx_Yag_Tests_BaseTestCase {

	/** @test */
	public function modeCanBeSetInConstructAndGetModeReturnsMode() {
		$pidDetector = new Tx_Yag_Utility_PidDetector(Tx_Yag_Utility_PidDetector::FE_MODE);
		$this->assertEquals($pidDetector->getMode(), Tx_Yag_Utility_PidDetector::FE_MODE);
	}



    /** @test */
    public function constructCreatesInstanceForCorrectModeIfCalledWithoutMode() {
        $pidDetector = new Tx_Yag_Utility_PidDetector();
        $this->assertEquals($pidDetector->getMode(), Tx_Yag_Utility_PidDetector::BE_YAG_MODULE_MODE);
    }



	/**
	 * Where do we get PIDs from
	 *
	 * 1. In Frontend
	 *    - From TS
	 *    - From Flexform
	 *    => From settings
	 *
	 * 2. In Backend
	 *    - In Yag module: From selected PID / from TS on selected PID
	 *    - In Content Element: From mountpoints of be_user / from TS on selected PID
	 */

	/** @test */
	public function getPidsReturnsCorrectPidsInFrontendEnvironment() {
		$this->fakeFeEnvironment();
		$this->markTestIncomplete();
	}



	/** @test */
	public function getPidsReturnsCorrectPidsForYagModule() {
		$this->fakeYagModuleEnvironment();
		$this->markTestIncomplete();
	}



	/** @test */
	public function getPidsReturnsCorrectPidsForContentModule() {
		$this->fakeContentElementFormEnvironment();
		$this->markTestIncomplete();
	}



	/** @test */
	public function getPidsReturnsCorrectPidsForManualMode() {
		$testArray = array(1,2,3,4);
		$pidDetector = new Tx_Yag_Utility_PidDetector(Tx_Yag_Utility_PidDetector::MANUAL_MODE);
		$pidDetector->setPids($testArray);
		$this->assertEquals($testArray, $pidDetector->getPids());
	}



	/** @test */
	public function getCurrentPageIsYagPageThrowsExceptionIfNotInBeMode() {
		$pidDetector = new Tx_Yag_Utility_PidDetector(Tx_Yag_Utility_PidDetector::FE_MODE);
		try {
			$pidDetector->getCurrentPageIsYagPage();
		} catch(Exception $e) {
			return;
		}
		$this->fail("No exception has been thrown when trying to call Tx_Yag_Utility_PidDetector::getCurrentPageIsYagPage in non-backend mode.");
	}



	/** @test */
	public function getCurrentPageIsYagPageReturnsTrueIfCurrentPageIsYagPage() {
		$pidDetector = $this->getMock('Tx_Yag_Utility_PidDetector', array('getPageRecords'),array(Tx_Yag_Utility_PidDetector::BE_YAG_MODULE_MODE), '', TRUE);
		$pidDetector->expects($this->any())
				->method('getPageRecords')
				->will($this->returnValue(
					array(
						array('uid' => 1, 'title' => 'nomatter'),
						array('uid' => 2, 'title' => 'nomatter')
					)
				)
		);
		$tmpId = $_GET['id'];
		$_GET['id'] = 1;
		$this->assertTrue($pidDetector->getCurrentPageIsYagPage());
		$_GET['id'] = $tmpId;
	}



	/** @test */
	public function getCurrentPageIsYagPageReturnsFalseIfCurrentPageIsNoYagPage() {
		$pidDetector = $this->getMock('Tx_Yag_Utility_PidDetector', array('getPageRecords'),array(Tx_Yag_Utility_PidDetector::BE_YAG_MODULE_MODE), '', TRUE);
		$pidDetector->expects($this->any())
				->method('getPageRecords')
				->will($this->returnValue(
					array(
						array('uid' => 1, 'title' => 'nomatter'),
						array('uid' => 2, 'title' => 'nomatter')
					)
				)
		);
		$tmpId = $_GET['id'];
		$_GET['id'] = 5;
		$this->assertFalse($pidDetector->getCurrentPageIsYagPage());
		$_GET['id'] = $tmpId;
	}



	/**
	 * Fakes settings for FE environment
	 *
	 * For testing pid detector in frontend environment, we have to fake some settings:
	 * - TS settings
	 *
	 * @return void
	 */
	protected function fakeFeEnvironment() {

	}



	protected function fakeYagModuleEnvironment() {

	}



	protected function fakeContentElementFormEnvironment() {
		
	}
	
}
?>