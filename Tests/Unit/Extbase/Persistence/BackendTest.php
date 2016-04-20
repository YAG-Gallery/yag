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

namespace DL\Yag\Tests\Unit\Extbase\Persistence;

use DL\Yag\Domain\Model\Item;
use DL\Yag\Tests\Unit\BaseTestCase;

/**
 * Testcase for album content manager
 *
 * @package Tests
 * @subpackage Extbase\Persistence
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class BackendTest extends BaseTestCase
{
    /** @test */
    public function determineStoragePageIdForNewRecordReturnsExpectedPid()
    {
        $pidDetectorMock = $this->getMock('DL\\Yag\\Utility\\PidDetector', array('getPids'), array(), '', false);
        $pidDetectorMock->expects($this->any())->method('getPids')->will($this->returnValue(array(1, 2, 3)));

        $backendMock = $this->getMock($this->buildAccessibleProxy('DL\\Yag\\Extbase\\Persistence\\Backend'), array('dummy'), array(), '', false);
        $backendMock->injectPidDetector($pidDetectorMock);

        $yagDomainModel = new Item();
        $determinedPid = $backendMock->_call('determineStoragePageIdForNewRecord', $yagDomainModel);

        $this->assertEquals(1, $determinedPid, 'Expected PID for domain model was 1 but we got ' . $determinedPid . ' instead!');
    }
}
