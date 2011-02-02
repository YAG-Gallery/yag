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


/**
 * Class implements a page for a pager
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-22
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Lib_Pager_Page {
    
    const PAGE_TYPE_NORMAL = 'page_type_normal';
    const PAGE_TYPE_FIRST = 'page_type_first';
    const PAGE_TYPE_LAST = 'page_type_last';
    
    
    /**
     * Holds page number of page
     * @var int
     */
    public $pageNr;
    
    
    
    /**
     * Holds page type of page
     * @var string
     */
    public $pageType;
    
    
    /**
     * Constructor for page
     *
     * @param int $pageNr
     * @param string $pageType
     */
    public function __construct($pageNr, $pageType) {
    	$this->pageNr = $pageNr;
    	$this->pageType = $pageType;
    }
    
    
    
    /**
     * Returns page number of page
     *
     * @return int  Page number of page
     */
    public function getPageNr() {
    	return $this->pageNr;
    }
    
    
    
    /**
     * Returns page type of page
     * 
     * @return string Page type of page
     */
    public function getPageType() {
    	return $this->pageType;
    }
    
}

?>
