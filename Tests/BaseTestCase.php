<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <knoll@punkt.de>
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
 * Base testcase for all yag testcases
 *
 * @package Tests
 * @author Michael Knoll <knoll@punkt.de>
 */
abstract class Tx_Yag_Tests_BaseTestCase extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @var string
	 */
	protected $extensionName = 'yag';


	/**
	 * @return Tx_Yag_Domain_Model_Item
	 */
	protected function getTestItemObject() {
		$item = new Tx_Yag_Domain_Model_Item();
		$item->setSourceuri('EXT:yag/Tests/TestImages/testImage.jpg');

		return $item;
	}
}
?>