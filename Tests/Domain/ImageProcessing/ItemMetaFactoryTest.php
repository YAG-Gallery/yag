<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Class implements tests for image processor
 *
 * @package Tests
 * @subpackage Domain/ImageProcessing
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Tests_Domain_ImageProcessing_ItemMetaFactoryTest extends Tx_Yag_Tests_BaseTestCase {

	/**
	 * @test
	 */
	public function createItemMetaObjectFromFile() {
		$filePath = t3lib_div::getFileAbsFileName($this->getTestItemObject()->getSourceuri());
		$itemMetaFactory = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')->get('Tx_Yag_Domain_Import_MetaData_ItemMetaFactory'); /** @var Tx_Yag_Domain_Import_MetaData_ItemMetaFactory $itemMetaFactory */
		$itemMeta = $itemMetaFactory->createItemMetaForFile($filePath);

		$this->assertTrue(is_a($itemMeta, 'Tx_Yag_Domain_Model_ItemMeta'));
	}

}
?>