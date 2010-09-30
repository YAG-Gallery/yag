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


abstract class Tx_Yag_Lib_AbstractPager implements Tx_Yag_Lib_PagerInterface {
	
	/**
	 * Holds the number of items to be shown on one page
	 * @var int
	 */
	protected $itemsPerPage = 10;
	
	
	
	/**
	 * Holds current page number (starts with 1)
	 * @var int
	 */
	protected $currentPageNumber;
	
	
	
	/**
	 * Holds maximum amount of items
	 * @var int
	 */
	protected $maxItems = 1000;
	
	
	
	/**
	 * Holds number of pages
	 * @var int
	 */
	protected $amountPages;
	
	
	
	/**
	 * Holds number of items
	 * @var int
	 */
	protected $totalItemCount;
	
	
	
	/**
	 * Holds item collection to generate pager for
	 * @var Tx_Extbase_Persistence_ObjectStorage
	 */
	protected $itemCollection;
	
	
	
	/**
	 * Holds strategy for pager
	 * @var Tx_Yag_Lib_AbstractPagerStrategy
	 */
	protected $pagerStrategy;
	
	
	
	/**
	 * Set pager status from requestSettings object
	 *
	 * @param Tx_Yag_Lib_PagerRequestSettings $pagerRequestSettings    Request settings to set status from
	 * @return void
	 */
	public function setRequestSettings(Tx_Yag_Lib_PagerRequestSettings $pagerRequestSettings) {
		$this->currentPageNumber = $pagerRequestSettings->currentPageNumber;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getAmountPages() {
		return $this->amountPages;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getCurrentPageNumber() {
		return $this->currentPageNumber;
	}
	
	
	
	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage
	 */
	public function getItemCollection() {
		return $this->itemCollection;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getItemsPerPage() {
		return $this->itemsPerPage;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getMaxItems() {
		return $this->maxItems;
	}
	
	
	
	/**
	 * @return Tx_Yag_Lib_AbstractPagerStrategy
	 */
	public function getPagerStrategy() {
		return $this->pagerStrategy;
	}
	
	
	
	/**
	 * @return int
	 */
	public function getTotalItemCount() {
		return $this->totalItemCount;
	}
	
	
	
	/**
	 * @param int $amountPages
	 */
	public function setAmountPages($amountPages) {
		$this->amountPages = $amountPages;
	}
	
	
	
	/**
	 * @param int $currentPageNumber
	 */
	public function setCurrentPageNumber($currentPageNumber) {
		$this->currentPageNumber = $currentPageNumber;
	}
	
	
	
	/**
	 * @param Tx_Extbase_Persistence_ObjectStorage $itemCollection
	 */
	public function setItemCollection($itemCollection) {
		$this->itemCollection = $itemCollection;
	}
	
	
	
	/**
	 * @param int $itemsPerPage
	 */
	public function setItemsPerPage($itemsPerPage) {
		$this->itemsPerPage = $itemsPerPage;
	}
	
	
	
	/**
	 * @param int $maxItems
	 */
	public function setMaxItems($maxItems) {
		$this->maxItems = $maxItems;
	}
	
	
	
	/**
	 * @param Tx_Yag_Lib_AbstractPagerStrategy $pagerStrategy
	 */
	public function setPagerStrategy($pagerStrategy) {
		$this->pagerStrategy = $pagerStrategy;
	}
	
	
	
	/**
	 * @param int $totalItemCount
	 */
	public function setTotalItemCount($totalItemCount) {
		$this->totalItemCount = $totalItemCount;
	}

}

?>
