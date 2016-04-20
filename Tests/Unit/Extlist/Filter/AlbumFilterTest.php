<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012-2013 punkt.de GmbH - Karlsruhe, Germany - http://www.punkt.de
*  Authors: Daniel Lienert
*  All rights reserved
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

namespace DL\Yag\Tests\Unit\Extlist\Filter;

use DL\Yag\Domain\Context\YagContext;
use DL\Yag\Domain\Context\YagContextFactory;
use DL\Yag\Extlist\Filter\AlbumFilter;
use DL\Yag\Tests\Unit\BaseTestCase;

class AlbumFilterTest extends BaseTestCase
{
    /**
     * @var AlbumFilter
     */
    protected $albumFilter;


    /**
     * @var YagContext
     */
    protected $yagContext;


    public function setUp()
    {
        $this->initConfigurationBuilderMock();

        $this->yagContext = YagContextFactory::createInstance('test');

        $filterConfig = $this->yagContext->getItemListContext()
            ->getConfigurationBuilder()
            ->buildFilterConfiguration()
            ->getFilterBoxConfig('internalFilters')
            ->getFilterConfigByFilterIdentifier('albumFilter');

        $albumFilterProxyClass = $this->buildAccessibleProxy('DL\\Yag\\Extlist\\Filter\\AlbumFilter');

        $this->albumFilter = new $albumFilterProxyClass();
        $this->albumFilter->injectFilterConfig($filterConfig);
    }


    /**
     * @test
     */
    public function buildFilterCriteriaWithAlbumUidSet()
    {
        YagContextFactory::getInstance()->setAlbumUid(1);

        $this->albumFilter->init();

        $filterQuery = $this->albumFilter->getFilterQuery();

        $criteriaArray = $filterQuery->getCriterias();

        $this->assertTrue(is_array($criteriaArray));

        $this->assertCount(1, $criteriaArray);

        $criteria = current($criteriaArray); /** @var \Tx_PtExtlist_Domain_QueryObject_SimpleCriteria $criteria */

        $this->assertEquals(1, $criteria->getValue());
    }



    /**
     * @test
     */
    public function buildFilterCriteriaForAllFieldsWithZeroAlbumUid()
    {
        YagContextFactory::getInstance()->setAlbumUid(0);

        $this->albumFilter->init();

        $filterQuery = $this->albumFilter->getFilterQuery();

        $criteriaArray = $filterQuery->getCriterias();

        $this->assertCount(0, $criteriaArray);
    }
}
