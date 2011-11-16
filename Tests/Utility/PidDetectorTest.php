<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
	public function modeCanBeSetInConstructorAndIsReturnedByGetMode() {
		$pidDetector = new Tx_Yag_Utility_PidDetector(Tx_Yag_Utility_PidDetector::FE_MODE);
		$this->assertEquals($pidDetector->getMode(), Tx_Yag_Utility_PidDetector::FE_MODE);
	}



	/** @test */
	public function constructorThrowsExceptionsIfCalledWithUnknownMode() {
		$this->setExpectedException('Exception');
		$pidDetector = new Tx_Yag_Utility_PidDetector('fuckoff');
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