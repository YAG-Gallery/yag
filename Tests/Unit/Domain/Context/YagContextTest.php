<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>
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

namespace DL\Yag\Tests\Unit\Domain\Context;

use DL\Yag\Domain\Context\YagContext;
use DL\Yag\Tests\Unit\BaseTestCase;

/**
 * TestCase for the YagContext
 *
 * @package Tests
 * @subpackage Domain\YagContext
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class YagContextTest extends BaseTestCase
{
    /**
     * @var YagContext
     */
    protected $yagContext;


    public function setUp()
    {
        $accessibleClassName = $this->buildAccessibleProxy('DL\\Yag\\Domain\\Context\\YagContext');
        $this->yagContext = new $accessibleClassName('test');

        $this->initConfigurationBuilderMock();
        $this->yagContext->_injectConfigurationBuilder($this->configurationBuilder);
    }



    /**
     * @test
     */
    public function isInStrictFilterModeReturnsTrue()
    {
        $this->yagContext->_set('pluginModeIdentifier', 'Gallery_showSingle');
        $actual = $this->yagContext->isInStrictFilterMode();

        $this->assertTrue($actual);
    }


    /**
     * @test
     */
    public function isInStrictFilterModeReturnsFalse()
    {
        $this->yagContext->_set('pluginModeIdentifier', 'SomeOtherKey');
        $actual = $this->yagContext->isInStrictFilterMode();

        $this->assertFalse($actual);
    }
}
