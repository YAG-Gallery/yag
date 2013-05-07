<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
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
class Tx_Yag_Domain_Repository_TagRepository extends Tx_Yag_Domain_Repository_AbstractRepository {


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

	

	/**
	 * Build an array of tags while respecting current filterSettings
	 *
	 * @return array
	 */
	public function getTagsByCurrentItemListFilterSettings() {

		$dataBackend = Tx_Yag_Domain_Context_YagContextFactory::getInstance()->getItemlistContext()->getDataBackend();

		$statement[] = '
			SELECT COUNT(*) as tagCount, tag.name
			FROM tx_yag_domain_model_tag tag
			INNER JOIN tx_yag_item_tag_mm mm ON mm.uid_foreign = tag.uid
			INNER JOIN tx_yag_domain_model_item item ON mm.uid_local = item.uid
			INNER JOIN tx_yag_domain_model_album album ON item.album = album.uid';

		$filterBoxWhere = $this->getWhereClauseFromFilterboxes($dataBackend->getFilterboxCollection());
		$statement[] = $filterBoxWhere;

		$statement[] = $filterBoxWhere ? 'AND' : 'WHERE';

		$statement[] = ' item.hidden = 0 AND item.deleted = 0
							 AND album.deleted = 0 AND album.hidden = 0';

		$statement[] = 'GROUP BY tag.name';

		$statement[] = 'ORDER BY tagCount DESC';

		$statement = implode(" \n", $statement);
		$statement = str_replace('__self__', 'item',$statement);

		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);

		$result = $query->statement($statement)->execute();
		
		return $result;
	}

	

	/**
	 * @param $filterBoxCollection
	 * @return string whereClauseSbippet
	 */
	public function getWhereClauseFromFilterboxes($filterBoxCollection) {
		$whereClauses = array();
		foreach ($filterBoxCollection as $filterBox) { /* @var $filterBox Tx_PtExtlist_Domain_Model_Filter_Filterbox */
			foreach($filterBox as $filter) {  /* @var $filter Tx_PtExtlist_Domain_Model_Filter_FilterInterface */
				$whereClauses[] = Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter::interpretQuery($filter->getFilterQuery());
			}
		}
		$whereClauses = array_filter($whereClauses);
		$whereClauseString = sizeof($whereClauses) > 0 ?  implode(') AND (', $whereClauses) : '';
		return $whereClauseString;
	}
}
?>