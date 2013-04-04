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
 * Testcase for configuration builder
 *
 * @package Tests
 * @subpackage Domain\Configuration
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class Tx_Yag_Tests_Domain_Configuration_ConfigurationBuilderTest extends Tx_Yag_Tests_BaseTestCase {

	/**
	 * Holds fixture for this testcase
	 *
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
    protected $fixture;
    
    
    
    /**
     * Sets up fixture for this testcase
     *
     */
    public function setUp() {
        $settings = Tx_Yag_Tests_DefaultTsConfig::getInstance()->tsConfigArray;
        $this->fixture = new Tx_Yag_Domain_Configuration_ConfigurationBuilder($settings['plugin']['tx_yag']['settings']);  
    }
    
    
    
	/**
	 * @test
	 */
	public function classExists() {
        $this->assertTrue(class_exists('Tx_Yag_Domain_Configuration_ConfigurationBuilder'));		
	}
    
    
    
    /**
     * @test
     */
    public function buildCrawlerConfigurationReturnsCrawlerConfigurationForTsConfiguration() {
        $crawlerConfiguration = $this->fixture->buildCrawlerConfiguration();
        $this->assertTrue(is_a($crawlerConfiguration, 'Tx_Yag_Domain_Configuration_Import_CrawlerConfiguration'));
    }
    
    
    
    /**
     * @test
     */
    public function buildImageProcessorConfigurationReturnsImageProcessorConfiguration() {
    	$imageProcessorConfiguration = $this->fixture->buildImageProcessorConfiguration();
    	$this->assertTrue(is_a($imageProcessorConfiguration, 'Tx_Yag_Domain_Configuration_ImageProcessing_ImageProcessorConfiguration'));
    }
}
?>