<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <lienert@punkt.de>, Michael Knoll <knoll@punkt.de>
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
 * Testcase for yag utility class
 *
 * @package yag
 * @subpackage Tests\Utility
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Tests_Utility_UtilityTest extends Tx_Yag_Tests_BaseTestCase {
	
	/**
	 * Holds fake array for testing 
	 *
	 * @var array
	 */
	protected $settings = array(
	   'firstKey' => array(
	       array('secondKey' => 'value')
	   )
	);
	
	

	/**
	 * @test
	 */
	public function getArrayContentByTsKeyReturnsStringOnScalarValue() {
		$this->assertEquals(Tx_Yag_Utility_Utility::getArrayContentByTsKey($this->settings, 'firstKey.secondKey'), $this->settings['firstKey']['secondKey']);
	}
	
	
	
	/**
	 * @test
	 */
	public function getArrayContentByTsKeyReturnsArrayOnArrayValue() {
		$this->assertEquals(Tx_Yag_Utility_Utility::getArrayContentByTsKey($this->settings, 'firstKey'), $this->settings['firstKey']);
	}
	
	

	/**
	 * @test
	 */
	public function getArrayContentByTsKeyReturnsNullPerDefault() {
		$this->assertEquals(Tx_Yag_Utility_Utility::getArrayContentByTsKey($this->settings, 'asfa.sdf.asdf'), null);
	}
	
	
	
	/**
	 * @test
	 */
	public function getArrayContentByTsKeyThrowsExceptionIfNoSettingsAvailable() {
		try {
			Tx_Yag_Utility_Utility::getArrayContentByTsKey($this->settings, 'asfa.sdf.asdf', false);
		} catch(Exception $e) {
			return;
		}
		$this->fail('No exception has been thrown on non-existing key!');
	}
	
}

?>