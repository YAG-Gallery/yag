<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*            
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


class Tx_Yag_Lib_AlbumPager extends Tx_Yag_Lib_AbstractPager {
	
	/**
	 * Holds a reference to a image repository
	 * @var Tx_Yag_Domain_Repository_ImageRepository
	 */
	protected $imageRepository;
	
	
	
	/**
	 * Holds a special page for showing 'all' pages
	 * @var string
	 */
	protected $allPage = 'all';
	
	
	
	/**
	 * Returns 'all' page for showing all pages
	 *
	 * @return string
	 */
	public function getAllPage() {
		return $this->allPage;
	}
	
	
	
	/**
	 * Returns a query object to handle limit set by pager
	 * @see Tx_Yag_Lib_PagerInterface::getCriteria()
	 * 
	 * @return Tx_Extbase_Persistence_QueryInterface   Query that handles limit set by pager
	 */
	public function getCriteria() {
		$query = $this->imageRepository->createQuery();
		$query->setLimit($this->itemsPerPage);
		$query->setOffset(($this->currentPageNumber - 1) * $this->itemsPerPage);
		return $query;
	}
	
	
	
	/**
	 * Renders HTML source for pager
	 * @see Tx_Yag_Lib_PagerInterface::render()
	 * 
	 * @return string Rendered HTML source for pager
	 */
	public function render() {
		return 'pager';
	}
	
	
	
	/**
	 * Returns an array of pages with types
	 * 
	 * @return array   Array of pages ($pageNr => $type)
	 */
	public function getPages() {
		$pages = new Tx_Extbase_Persistence_ObjectStorage();
		$numberOfPages = ceil($this->totalItemCount / $this->itemsPerPage);
		for ($i = 1; $i <= $numberOfPages; $i++) {
			if ($i == 1)
			    $pages->attach(new Tx_Yag_Lib_Pager_Page(1, Tx_Yag_Lib_Pager_Page::PAGE_TYPE_FIRST));
			elseif ($i == $numberOfPages) 
			    $pages->attach(new Tx_Yag_Lib_Pager_Page($i, Tx_Yag_Lib_Pager_Page::PAGE_TYPE_LAST));
			else 
			    $pages->attach(new Tx_Yag_Lib_Pager_Page($i, Tx_Yag_Lib_Pager_Page::PAGE_TYPE_NORMAL));
		}
		return $pages;
	}

}

?>
