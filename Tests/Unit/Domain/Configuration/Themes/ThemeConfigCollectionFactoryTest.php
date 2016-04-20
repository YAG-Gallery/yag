<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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

namespace DL\Yag\Tests\Unit\Domain\Configuration\Themes;

use DL\Yag\Domain\Configuration\Theme\ThemeConfigCollectionFactory;
use DL\Yag\Tests\Unit\BaseTestCase;

/**
 * Factory for theme configuration
 *
 * @package Domain
 * @subpackage Configuration\Theme
 
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class ThemeConfigCollectionFactoryTest extends BaseTestCase
{
    public function setUp()
    {
        $this->initConfigurationBuilderMock();
    }

    /**
      * @test
      */
    public function getInstance()
    {
        $themeCollection = ThemeConfigCollectionFactory::getInstance($this->configurationBuilder);

        $this->assertTrue(is_a($themeCollection, 'DL\\Yag\\Domain\\Configuration\\Theme\\ThemeConfigCollection'), 'ThemeCollection is of Type ' . get_class($themeCollection));
        $this->assertTrue($themeCollection->hasItem('default'), 'Default theme is not part of the collection!');
    }
}
