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
 * Testcase for abstract configuration
 *
 * @package yag
 * @subpackage Tests\Domain\Configuration
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_Yag_Domain_Configuration_AbstractConfigurationTest extends Tx_Yag_Tests_BaseTestCase {

	/**
	 * Dummy settings array for testing
	 *
	 * @var array
	 */
	protected $settings = array(
	    'key1' => array(
	        'key1' => 'test1',
	        'key2' => 'test2'
	    ),
	    'key2' => array(
	        'key1' => array(
	            'key1' => 'test3'
	        )
	    )
	);
	
	
	
	/**
	 * Holds instance of configuration object for testing
	 *
	 * @var Tx_Yag_Tests_Domain_Configuration_AbstractConfiguration_Stub
	 */
	protected $fixture;
	
	
	
	public function setUp() {
		$configurationBuilderMock = $this->getMock('Tx_Yag_Domain_Configuration_AbstractConfigurationBuilder', array(), array(), '', FALSE);
		$this->fixture = new Tx_Yag_Tests_Domain_Configuration_AbstractConfiguration_Stub($configurationBuilderMock);
	}
	
	
	
	/**
	 * @test
	 */
	public function getSettingsReturnsInjectedSettings() {
		$this->fixture->injectSettings($this->settings);
		$this->assertEquals($this->fixture->getSettings(), $this->settings);
	}
	
	
	
	/**
	 * @test
	 */
	public function getSettingsByTsKeyReturnsSetting() {
		$this->fixture->injectSettings($this->settings);
		$this->assertEquals($this->fixture->getSettingByTsKey('key2.key1.key1'), $this->settings['key2']['key1']['key1']);
	}
	
}



/**
 * Dummy class for testing only!
 */
require_once t3lib_extMgm::extPath('yag') . 'Classes/Domain/Configuration/AbstractConfiguration.php';
class Tx_Yag_Tests_Domain_Configuration_AbstractConfiguration_Stub extends Tx_Yag_Domain_Configuration_AbstractConfiguration {}


?>