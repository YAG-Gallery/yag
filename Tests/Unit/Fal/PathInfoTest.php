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

namespace DL\Yag\Tests\Unit\Fal;

use DL\Yag\Tests\Unit\BaseTestCase;
use TYPO3\CMS\Yag\Fal\Driver\PathInfo;

/**
 * Testcase for testing performance of yag gallery
 *
 * Comment out line in testPerformance() to make this test actually working!
 *
 * @package Tests
 * @subpackage Fal
 * @author Daniel Lienert <typo3@lienert.cc>
 */

class PathInfoTest extends BaseTestCase
{
    /**
     * @var PathInfo
     */
    protected $pathInfo;


    public function setUp()
    {
        parent::setUp();
        $this->pathInfo = $this->objectManager->get('TYPO3\\CMS\\Yag\\Fal\\Driver\\PathInfo');
    }


    public function pathDataProvider()
    {
        return array(
            'root' => array('type' => PathInfo::INFO_PID,
                'pid' => '',
                'galleryUid' => '',
                'albumUid' => '',
                'itemUid' => '',
                'expectedPath' =>  '/'
            ),
            'pid'        => array('type' => PathInfo::INFO_PID,    'pid' => '1', 'galleryUid' => '', 'albumUid' => '', 'itemUid' => '', 'expectedPath' =>  '/1'),
            'gallery'    => array('type' => PathInfo::INFO_GALLERY, 'pid' => '1', 'galleryUid' => '2', 'albumUid' => '', 'itemUid' => '', 'expectedPath' =>  '/1/2'),
            'album'    => array('type' => PathInfo::INFO_ALBUM, 'pid' => '1', 'galleryUid' => '2', 'albumUid' => '3', 'itemUid' => '', 'expectedPath' =>  '/1/2/3'),
            'item'    => array('type' => PathInfo::INFO_ITEM, 'pid' => '1', 'galleryUid' => '2', 'albumUid' => '3', 'itemUid' => '4', 'expectedPath' =>  '/1/2/3/4'),
        );
    }


    /**
     * @test
     * @dataProvider pathDataProvider
     *
     * @param $type
     * @param $pid
     * @param $galleryUid
     * @param $albumUid
     * @param $itemUid
     * @param $expectedPath
     */
    public function pathInfoTest($type, $pid, $galleryUid, $albumUid, $itemUid, $expectedPath)
    {
        $this->pathInfo->setPathType($type)
            ->setPid($pid)
            ->setGalleryUId($galleryUid)
            ->setAlbumUid($albumUid)
            ->setItemUid($itemUid);

        $this->assertEquals($expectedPath, $this->pathInfo->getYagDirectoryPath());
    }
}
