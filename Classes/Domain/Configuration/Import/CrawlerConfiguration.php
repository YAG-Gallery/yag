<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Class for crawler configuration
 *
 * @package Domain
 * @subpackage Configuration\Import
 * 
 * @author Michael Knoll <mimi@kaktsuteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Domain_Configuration_Import_CrawlerConfiguration extends Tx_PtExtbase_Configuration_AbstractConfiguration {
	
	/**
	 * Holds array of file types to be crawled by crawler
	 *
	 * @var array
	 */
	protected $fileTypes;

	
	
	/**
	 * Inits object
	 */
	protected function init() {
		$this->setRequiredValue('fileTypes', 'No fileTypes set in crawler configuration (Missing key "fileTypes") 1287241128');
	}
	
	
	
	/**
	 * Returns file types to be crawled for as regex pattern
	 *
	 * @return string
	 */
	public function getFileTypes() {
		return $this->fileTypes;
	}
	
}
?>