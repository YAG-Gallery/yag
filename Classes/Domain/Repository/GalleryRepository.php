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
 * Repository for Tx_Yag_Domain_Model_gallery
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Yag_Domain_Repository_GalleryRepository extends Tx_Extbase_Persistence_Repository {
	
	/**
	 * Returns array of galleries for a given page id
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
	
}

?>