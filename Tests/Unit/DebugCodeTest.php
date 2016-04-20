<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 punkt.de GmbH - Karlsruhe, Germany - http://www.punkt.de
 *  Authors: Daniel Lienert, Michael Knoll
 *  All rights reserved
 *
 *  For further information: http://extlist.punkt.de <extlist@punkt.de>
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

namespace DL\Yag\Tests\Unit;

use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Testcase to find debug code in the extension
 *
 * @author  Daniel Lienert
 * @package Tests
 */
class DebugCodeTest extends UnitTestCase {
    /**
     * @var string Put the extension name here
     */
    protected $extensionName = 'yag';

    /**
     * @var string
     */
    protected $sourceDirectory = __DIR__ . '/../../';

    /**
     * @return array
     */
    public function debugStringDataProvider() {
        return array(
            'Search for print_r in code!'  => array( 'debugCommand' => 'print_r' ),
            'Search for var_dump in code!' => array( 'debugCommand' => 'var_dump' ),
        );
    }

    /**
     * @test
     * @dataProvider debugStringDataProvider
     *
     * @var $debugCommand
     */
    public function checkForForgottenDebugCode( $debugCommand ) {
        $searchPath = $this->sourceDirectory . 'Classes';

        $result = `fgrep -i -r "$debugCommand" "$searchPath" | grep ".php"`;
        $lines  = explode( "\n", trim( $result ) );

        foreach ( $lines as $line ) {
            if ( ! empty( $line ) && ! stristr( $line, $searchPath . 'Tests' ) ) {
                $this->fail( 'Found ' . $debugCommand . ': ' . $line );
            }
        }
    }
}
