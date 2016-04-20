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
use DL\Yag\Extlist\Filter\GalleryFilter;
use DL\Yag\Tests\Unit\BaseTestCase;

class GalleryFilterTest extends BaseTestCase
{
    /**
     * @var GalleryFilter
     */
    protected $galleryFilter;


    /**
     * @var YagContext
     */
    protected $yagContext;


    public function setUp()
    {
        $this->initConfigurationBuilderMock();

        $galleryFilterProxyClass = $this->buildAccessibleProxy('DL\\Yag\\Extlist\\Filter\\GalleryFilter');

        $this->galleryFilter = new $galleryFilterProxyClass();

        $this->yagContext = YagContextFactory::createInstance('test');
        $filterConfig = $this->yagContext->getAlbumListContext()
            ->getConfigurationBuilder()
            ->buildFilterConfiguration()
            ->getFilterBoxConfig('internalFilters')
            ->getFilterConfigByFilterIdentifier('galleryFilter');

        $this->galleryFilter->injectFilterConfig($filterConfig);
    }


    /**
     * @test
     */
    public function buildFilterCriteriaForAllFieldsWithGalleryUidSetAndHideHidden()
    {
        YagContextFactory::getInstance()->setGalleryUid(1);

        $this->galleryFilter->init();

        $filterQuery = $this->galleryFilter->getFilterQuery();

        $criteriaArray = $filterQuery->getCriterias();

        $this->assertCount(1, $criteriaArray);

        $simpleCriteria = current($criteriaArray); /** @var \Tx_PtExtlist_Domain_QueryObject_AndCriteria $andCriteria */

        $this->assertEquals(1, $simpleCriteria->getValue());
    }



    /**
     * @test
     */
    public function buildFilterCriteriaForAllFieldsWithZeroAlbumUid()
    {
        YagContextFactory::getInstance()->setGalleryUid(0);

        $this->galleryFilter->init();

        $filterQuery = $this->galleryFilter->getFilterQuery();

        $criteriaArray = $filterQuery->getCriterias();

        $this->assertCount(0, $criteriaArray);
    }
}
