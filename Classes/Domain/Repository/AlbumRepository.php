<?php
/***************************************************************
*  Copyright notice
*
*  (c)  2009 Michael Knoll <mimi@kaktusteam.de> - MKLV GbR
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
 * Class definition file for a repository for Tx_Yag_Domain_Model_Album
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */



/**
 * Class implements a repository for yag album objects
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Typo3
 * @subpackage yag
 * @since 2009-12-22
 */
class Tx_Yag_Domain_Repository_AlbumRepository extends Tx_Extbase_Persistence_Repository {
	
	/**
	 * Returns array of albums for a given page id
	 *
	 * @param int $pageId
	 * @return array Array of galleries for given page id
	 */
	public function findByPageId($pageId) {
		$query = $this->createQuery();
		return $query->matching($query->equals('pid', $pageId))
		             ->setOrderings(array('date' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
		             ->execute();
	}
	
	
	
	/**
	 * Removes an object from repository
	 *
	 * @param Tx_Yag_Domain_Model_Album $object
	 */
	public function remove($object) {
		$imageRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ImageRepository'); /* @var $imageRepository Tx_Yag_Domain_Repository_ImageRepository */
		foreach ($object->getImages() as $image) {
			$imageRepository->remove($image);
		}
		parent::remove($object);
	}
	
}

?>