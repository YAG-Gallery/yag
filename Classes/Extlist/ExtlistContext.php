<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Class holds context for extlist settings and objects 
 *
 * @package Extlist
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Extlist_ExtlistContext {
	
	/**
	 * Holds an instance of list configuration for this context
	 *
	 * @var array
	 */
	protected $listSettings;

	/**
	 * Holds list identifier for list kept in context
	 *
	 * @var string
	 */
	protected $listIdentifier;
	
	
	
	/**
	 * Holds data backend for list identifier
	 *
	 * @var Tx_PtExtlist_Domain_DataBackend_DataBackendInterface
	 */
	protected $dataBackend = null;
	
	
	
	/**
	 * Holds an instance of renderer chain for this list
	 *
	 * @var Tx_PtExtlist_Domain_Renderer_RendererChain
	 */
	protected $rendererChain = null;
	
	
	
	/**
	 * Constructor for extlist context.
	 *
	 * @param array $listConfiguration Configuration settings for extlist (TS Array)
	 * @param string $listIdentifier Identifier for list
	 */
	public function __construct($listConfiguration, $listIdentifier) {
		$this->listIdentifier = $listIdentifier;
		$this->listSettings = $listConfiguration;
		$this->dataBackend = Tx_PtExtlist_Utility_ExternalPlugin::
            getDataBackendByCustomConfiguration($listConfiguration, $listIdentifier);
        $this->init();
	}
	
	
	
	/**
	 * Initializes context
	 *
	 */
	protected function init() {
		// Initialize renderer chain
		$this->rendererChain = Tx_PtExtlist_Domain_Renderer_RendererChainFactory::
		    getRendererChain($this->dataBackend->getConfigurationBuilder()->buildRendererChainConfiguration());
	}
	
	
	
	/**
	 * Returns renderer chain
	 *
	 * @return Tx_PtExtlist_Domain_Renderer_RendererChain
	 */
	public function getRendererChain() {
		return $this->rendererChain;
	}
	
	
	
	/**
	 * Returns data backend of list context
	 *
	 * @return Tx_PtExtlist_Domain_DataBackend_DataBackendInterface
	 */
	public function getDataBackend() {
		return $this->dataBackend;
	}
	
	
	
	/**
	 * Returns pager collection fo databacken for this list context
	 *
	 * @return Tx_PtExtlist_Domain_Model_Pager_PagerCollection
	 */
	public function getPagerCollection() {
		return $this->dataBackend->getPagerCollection();
	}
	
	
	
	/**
	 * Returns list object of this list context
	 *
	 * @return Tx_PtExtlist_Domain_Model_List_List
	 */
	public function getList() {
		return Tx_PtExtlist_Utility_ExternalPlugin::getListByDataBackend($this->dataBackend);
	}
	
	
	
	/**
	 * Returns list data for this list context
	 *
	 * @return Tx_PtExtlist_Domain_Model_List_ListData
	 */
	public function getListData() {
		return $this->getList()->getListData();
	}
	
	
	
	/**
	 * Returns rendered list data of current list context
	 *
	 * @return Tx_PtExtlist_Domain_Model_List_ListData
	 */
	public function getRenderedListData() {
		return $this->getRendererChain()->renderList($this->getListData());
	}
	
	
	
	/**
	 * Resets pager collection for list context
	 */
	public function resetPagerCollection() {
		$this->dataBackend->getPagerCollection()->reset();
	}
	
	
	
	/**
	 * Resets filterbox collection for list context
	 */
	public function resetFilterboxCollection() {
		$this->dataBackend->getFilterboxCollection()->reset();
	}
	
	

    /**
     * Returns gallery object currently set in gallery filter
     * 
     * @param Tx_Yag_Extlist_ExtlistContext $extlistContext Extlist context to get filters from
     * @return Tx_Yag_Domain_Model_Gallery Gallery currently used for filtering albums
     */
    public function getSelectedGallery() {
        $filter = $this->getDataBackend()->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('galleryFilter');
        /* @var $filter Tx_Yag_Extlist_Filter_GalleryFilter */
        return t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository')->findByUid($filter->getGalleryUid()); 
    }
    
    
    
    /**
     * Returns album object currently set in album filter
     * 
     * @param Tx_Yag_Extlist_ExtlistContext $extlistContext Extlist context to get filters from
     * @return Tx_Yag_Domain_Model_Album Album currently used for filtering items
     */
    public function getSelectedAlbum() {
        $filter = $this->getDataBackend()->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('albumFilter');
        /* @var $filter Tx_Yag_Extlist_Filter_GalleryFilter */
        return t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository')->findByUid($filter->getAlbumUid()); 
    }
    
    
        
    
	
}
 
?>