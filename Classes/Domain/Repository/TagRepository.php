<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Michael Knoll <mimi@kaktusteam.de>
*  			Daniel Lienert <daniel@lienert.cc>
*  			
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
 * Class implements tag repository
 *
 * @package Domain
 * @subpackage repository
 * @author Daniel Lienert <daniel@lienert.cc>
 */


/**
 * Repository for Tx_Yag_Domain_Model_Tag
 */
class Tx_Yag_Domain_Repository_TagRepository extends Tx_Extbase_Persistence_Repository {

	
	/**
	 * Add tag only if it is not existing already
	 * 
	 * (non-PHPdoc)
	 * @see Classes/Persistence/Tx_Extbase_Persistence_Repository::add()
	 */
	public function add($tag) {
		$existingTag = $this->findOneByName($tag->getName());
		if($existingTag === NULL) {
			parent::add($tag);
		}
	}
}
?>