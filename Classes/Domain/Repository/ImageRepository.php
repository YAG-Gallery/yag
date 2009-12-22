<?php
/***************************************************************
*  Copyright notice
*
*  (c)  TODO - INSERT COPYRIGHT
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

/**
 * Class definition file for a repository for Tx_Yag_Domain_Model_Image
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */



/**
 * This class implements a repository for image objects
 * 
 * @package Typo3
 * @subpackage yag
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-22
 */
class Tx_Yag_Domain_Repository_ImageRepository extends Tx_Extbase_Persistence_Repository {
	
	/**
	 * Removes an image from repository
	 *
	 * @param object $image     Image to be removed from repository
	 */
	public function remove($image) {
		// remove dependent image files
		$imageFileRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ImageFileRepository'); /* @var $imageFileRepository Tx_Yag_Domain_Repository_ImageFileRepository */
		$imageFileRepository->remove($image->getOrig());
		$imageFileRepository->remove($image->getThumb());
		$imageFileRepository->remove($image->getSingle());
		// TODO how to remove mm relation with album?
		parent::remove($image);
	}
	
	
}
?>