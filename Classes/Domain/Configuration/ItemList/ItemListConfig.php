<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>
*  			Michael Knoll <mimi@kaktusteam.de>
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
 * Class implements album configuration object for YAG.
 *
 * @package Domain
 * @subpackage Configuration\ItemList
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Configuration_ItemList_ItemListConfig extends Tx_PtExtbase_Configuration_AbstractConfiguration {

	/**
	 * Column count for item view
	 * 
	 * @var integer
	 */
	protected $columnCount;

	
	
	/**
	 * Items per Page
	 * 
	 * @var integer
	 */
	protected $itemsPerPage;


	/**
	 * @var boolean
	 */
	protected $useRandomFilter;
	
	
	/**
	 * Holds partial name used for rendering image thumbs
	 *
	 * @var string
	 */
	protected $imageThumbPartial;
	
	
	
	/**
     * Holds partial name used for rendering image thumbs in admin view
     *
     * @var string
     */
    protected $imageAdminThumbPartial;
    
    
    
    /**
     * Holds partial name / path used for rendering pager
     *
     * @var string
     */
    protected $pagerPartial;


	/**
	 * @var string
	 */
	protected $pagerIdentifier = 'default';


	/**
	 * @var string
	 */
	protected $linkMode = 'show';


	/**
	 * @var integer
	 */
	protected $linkTargetPageUid;


	/**
	 * @var string
	 */
	protected $linkTargetPluginMode;


	/**
	 * @var bool
	 */
	protected $zipDownloadActive = FALSE;


	/**
	 * @var array
	 */
	protected $zipDownloadSettings = array();


	
	/**
	 * Initializes configuration object (Template method)
	 */
	protected function init() {
		$this->setRequiredValue('imageThumbPartial', 'Required setting "imageThumbPartial" could not be found in item list settings! 1294407391');
		$this->setRequiredValue('pagerPartial', 'Required setting "pagerPartial" could not be found in item list settings! 1294407393');
		$this->setRequiredValue('imageAdminThumbPartial', 'Required setting "imageAdminThumbPartial" could not be found in item list settings! 1294407392');

		$this->setValueIfExists('itemsPerPage');
		$this->setValueIfExists('pagerIdentifier');
		$this->setValueIfExists('columnCount');

		$this->setValueIfExists('linkMode');
		$this->setValueIfExists('linkTargetPageUid');
		$this->setValueIfExists('linkTargetPluginMode');


		if(array_key_exists('zipDownload', $this->settings) && array_key_exists('active', $this->settings['zipDownload'])) {
			$this->settings['zipDownloadActive'] = $this->settings['zipDownload']['active'];
		}
		$this->setBooleanIfExistsAndNotNothing('zipDownloadActive');
		$this->setValueIfExists('zipDownload', 'zipDownloadSettings');


		$this->setBooleanIfExistsAndNotNothing('useRandomFilter');
	}
	
	
	
	/**
	 * Getter for partial for rendering thumbnails in itemlist
	 *
	 * @return string  Name of partial for thumbnails
	 */
	public function getImageThumbPartial() {
		return $this->imageThumbPartial;
	}
	
	
	
	/**
	 * Returns name / path for pager partial
	 *
	 * @return string
	 */
	public function getPagerPartial() {
		return $this->pagerPartial;
	}
    
    
    
    /**
     * Getter for partial for rendering admin thumbnails in itemlist
     *
     * @return string  Name of partial for thumbnails
     */
    public function getImageAdminThumbPartial() {
        return $this->imageAdminThumbPartial;
    }
	
	
	
	/**
	 * @return int columnCount
	 */
	public function getColumnCount() {
		return $this->columnCount;
	}
	

	
	/**
	 * Get the columns relative width
	 * @return int
	 */
	public function getColumnRelativeWidth() {
		return floor(100 / $this->columnCount);
	}

	
	
	/**
	 * @return int 
	 */
	public function getItemsPerPage() {
		return $this->itemsPerPage;
	}


	/**
	 * @return string
	 */
	public function getLinkMode() {
		return $this->linkMode;
	}


	/**
	 * @return int
	 */
	public function getLinkTargetPageUid() {
		return $this->linkTargetPageUid;
	}


	/**
	 * @return string
	 */
	public function getLinkTargetPluginMode() {
		return $this->linkTargetPluginMode;
	}

	/**
	 * @return boolean
	 */
	public function getUseRandomFilter() {
		return $this->useRandomFilter;
	}

	/**
	 * @return string
	 */
	public function getPagerIdentifier() {
		return $this->pagerIdentifier;
	}


	/**
	 * @return array
	 */
	public function getZipDownloadSettings() {
		return $this->zipDownloadSettings;
	}

	/**
	 * @return boolean
	 */
	public function getZipDownloadActive() {
		return $this->zipDownloadActive;
	}
}
?>