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
 * Testcase for configuration builder factory
 *
 * @package Tests
 * @subpackage Domain\Configuration
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class Tx_Yag_Tests_Domain_Configuration_ConfigurationBuilderFactoryTest extends Tx_Yag_Tests_BaseTestCase {
	
    /**
     * @test
     */
    public function classExists() {
        $this->assertTrue(class_exists('Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory'));        
    }
     
}

?>