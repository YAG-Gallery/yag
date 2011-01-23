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
 * Class holds settings and objects for yag gallery.
 *
 * @package Domain
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_YagContext implements Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface {

	/**
	 * Holds constant for gallery UID field in session data
	 */
	const GALLERY_UID = 'galleryUid';
	
	
	
	/**
	 * Holds constant for album UID field in session data
	 */
	const ALBUM_UID = 'albumUid';
	
	

	/**
	 * Holds constant for item UID field in session data
	 */
	const ITEM_UID = 'itemUid';
	
	
	
	/**
	 * Holds constant for identifier for gallery list in typoscript configuration
	 */
	const GALLERY_LIST_ID = 'galleryList';
	
	
	
	/**
	 * Holds constant for identifier for album list in typoscript configuration
	 */
	const ALBUM_LIST_ID = 'albumList';
	
	
	
	/**
	 * Holds constant for identifier for itemlist in typoscript configuration
	 */
	const ITEM_LIST_ID = 'itemList';
	
	
	
	/**
	 * Holds a constant for identifier for rsslist in typoscript configuration
	 */
	const RSS_LIST_ID = 'albumListRss';
	
	
	
	/**
	 * Holds an instance of yag configuration builder
	 *
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder;
	
	
	
	/**
	 * Holds a singleton instance of this class
	 *
	 * @var Tx_Yag_Domain_YagContext
	 */
	private static $instance = null;
	
	
	
	/**
	 * Holds an array of session data
	 *
	 * @var array
	 */
	protected $sessionData;
	
	
	
	/**
	 * Holds an instance of gallery object we are currently working upon
	 *
	 * @var Tx_Yag_Domain_Model_Gallery
	 */
	protected $selectedGallery = null;
	
	
	
	/**
	 * Holds an instance of album object we are currentyl working upon
	 *
	 * @var Tx_Yag_Domain_Model_Album
	 */
	protected $selectedAlbum = null;
	
	
	
	/**
	 * Holds instance of item object we are currently working upon
	 *
	 * @var Tx_Yag_Domain_Model_Album
	 */
	protected $selectedItem = null;
	
	
	
	/**
	 * Holds an instance of extlist context fo gallery list
	 *
	 * @var Tx_Yag_Extlist_ExtlistContext
	 */
	protected $gallerylistExtlistContext = null;
	
	
	
	/**
	 * Holds an instance of extlist context for album list
	 *
	 * @var Tx_Yag_Extlist_ExtlistContext
	 */
	protected $albumlistExtlistContext = null;
	
	
	
	/**
	 * Holds an instance of extlist context for item list
	 *
	 * @var Tx_Yag_Extlist_ExtlistContext
	 */
	protected $itemlistExtlistContext = null;
	
	
	
	/**
	 * Holds an instance of extlist context for rss feed list
	 *
	 * @var Tx_Yag_Extlist_ExtlistContext
	 */
	protected $rsslistExtlistContext = null;
	
	
	
	/**
	 * Holds an instance of current MVC request
	 *
	 * @var Tx_Extbase_MVC_Request
	 */
	protected $request;
	
	
	
	/**
	 * Holds an instance of current rbac user
	 *
	 * @var Tx_Rbac_Domain_Model_User
	 */
	protected $rbacUser = null;
	
	
	
	/**
	 * Returns a singleton instance of this class
	 *
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @return Tx_Yag_Domain_YagContext Singleton instance of Tx_Yag_Domain_YagContext
	 */
	public static function getInstance(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		if (self::$instance === null) {
			self::$instance = new Tx_Yag_Domain_YagContext($configurationBuilder);
			$sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
			$sessionPersistenceManager->registerObjectAndLoadFromSession(self::$instance);
			self::$instance->initBySessionData();
		}
		return self::$instance;
	}
	
	
	
	/**
	 * Injector for MVC request
	 *
	 * @param Tx_Extbase_MVC_Request $request
	 */
	public function injectRequest(Tx_Extbase_MVC_Request $request) {
		$this->request = $request;
	}
	
	
	
	/**
	 * Creates gallery list extlist context
	 *
	 */
	protected function createGalleryListExtlistContext() {
		$this->gallerylistExtlistContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByCustomConfiguration(
		    $this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::GALLERY_LIST_ID), self::GALLERY_LIST_ID);
	}
	
	
	
	/**
	 * Creates album list extlist context
	 *
	 */
	protected function createAlbumListExtlistContext() {
		$this->albumlistExtlistContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByCustomConfiguration(
		    $this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::ALBUM_LIST_ID), self::ALBUM_LIST_ID);
	}
	
	
	
	/**
	 * Creates itemlist extlist context
	 *
	 */
	protected function createItemlistExtlistContext() {
		$this->itemlistExtlistContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByCustomConfiguration(
			    $this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::ITEM_LIST_ID), self::ITEM_LIST_ID);
	}
	
	
	
	/**
	 * Creates rsslist extlist context
	 *
	 */
	protected function createRsslistExtlistContext() {
		if ($this->rsslistExtlistContext === null) {
			$this->rsslistExtlistContext = new Tx_Yag_Extlist_ExtlistContext(
			    $this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::RSS_LIST_ID), self::RSS_LIST_ID);
		}
	}
	
	
	
	/**
	 * We hide constructor to force usage of getInstance()
	 * 
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 */
	protected function __construct(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder){
		$this->configurationBuilder = $configurationBuilder;
	}
	
	
	
	/**
	 * Initializes current object
	 *
	 */
	protected function init() {
		$this->initBySessionData();
	}
	
	
	
	/**
	 * Returns namespace for this object used to identify its data in session
	 *
	 * @return String Namespace of this object
	 */
	public function getObjectNamespace() {
		// TODO think about better namespace, if more than one gallery instance is used per page
		return 'tx_yag';
	}
	
	
	
	/**
	 * @see Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface::injectSessionData()
	 *
	 * @param array $sessionData
	 */
	public function injectSessionData(array $sessionData) {
		$this->sessionData = $sessionData;
	}
	
	
	
	/**
	 * @see Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface::persistToSession()
	 *
	 */
	public function persistToSession() {
        return array();
	}
	
	
	
	/**
	 * Initializes context by session data
	 *
	 */
	protected function initBySessionData() {

	}
	

	
	/**
	 * Getter for selected album
	 *
	 * @return Tx_Yag_Domain_Model_Album
	 */
	public function getSelectedAlbum() {
		$filter = $this->getAnyDataBackend()->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('albumFilter');
        /* @var $filter Tx_Yag_Extlist_Filter_GalleryFilter */
        return t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository')->findByUid($filter->getAlbumUid());
	}
	
	
	/**
	 * TODO: replace this by a reliable method .. 
	 * 
	 */
	public function getAnyDataBackend() {
		if($this->itemlistExtlistContext) return $this->itemlistExtlistContext->getDataBackend();
		if($this->albumlistExtlistContext) return $this->albumlistExtlistContext->getDataBackend();
		if($this->gallerylistExtlistContext) return $this->gallerylistExtlistContext->getDataBackend();
	}
	
	
	
	/**
	 * Getter for selected gallery
	 *
	 * @return Tx_Yag_Domain_Model_Gallery
	 */
	public function getSelectedGallery() {
        $filter = $this->getAnyDataBackend()->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('galleryFilter');
        /* @var $filter Tx_Yag_Extlist_Filter_GalleryFilter */
        return t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository')->findByUid($filter->getGalleryUid()); 
	}
	
	
	
	/**
	 * Getter for selected item
	 *
	 * @return Tx_Yag_Domain_Model_Item
	 */
	public function getSelectedItem() {
		return $this->selectedItem;
	}
	
	
	
	/**
	 * Resets selected album
	 */
	public function resetSelectedAlbum() {
		$this->selectedAlbum = null;
	}
	
	
	
	/**
	 * Resets selected gallery
	 */
	public function resetSelectedGallery() {
		$this->selectedGallery = null;
	}
	
	
	
	/**
	 * Resets selected item
	 */
	public function resetSelectedItem() {
		$this->selectedItem = null;
	}
	
	
	
	/**
	 * Resets all selections in current context
	 */
	public function resetAll() {
		$this->resetSelectedAlbum();
		$this->resetSelectedGallery();
		$this->resetSelectedItem();
	}
	
	
	
	/**
	 * Getter for gallery list context
	 *
	 * @return Tx_Yag_Extlist_ExtlistContext
	 */
	public function getGalleryListContext() {
		$this->createGalleryListExtlistContext();
		return $this->gallerylistExtlistContext;
	}
	
	
	
	/**
	 * Getter for album list context
	 *
	 * @return Tx_Yag_Extlist_ExtlistContext
	 */
	public function getAlbumListContext() {
		$this->createAlbumListExtlistContext();
		return $this->albumlistExtlistContext;
	}
	
	
	
	/**
	 * Getter for itemlist context
	 *
	 * @return Tx_Yag_Extlist_ExtlistContext
	 */
	public function getItemlistContext() {
		$this->createItemlistExtlistContext();
		return $this->itemlistExtlistContext;
	}
	
	
	
	/**
	 * Getter for rsslist context
	 *
	 * @return Tx_Yag_Extlist_ExtlistContext
	 */
	public function getRsslistContext() {
		$this->createRsslistExtlistContext();
		return $this->rsslistExtlistContext;
	}
	
	
	
	/**
	 * Getter for MVC request
	 *
	 * @return Tx_Extbase_MVC_Request
	 */
	public function getRequest() {
		return $this->request;
	}
	
	
	
	/**
	 * Returns controller name of current GP vars
	 *
	 * @return string Name of controller of current GP vars
	 */
	public function getGpVarControllerName() {
		// TODO use prefix from some kind of variable here!
		return $_GET['tx_yag_pi1']['controller'];
	}
	
	
	
	/**
	 * Returns action name of current GP vars
	 *
	 * @return string Name of action of current GP vars
	 */
	public function getGpVarActionName() {
		// TODO use prefix from some kind of variable here!
		return $_GET['tx_yag_pi1']['action'];
	}
	
	
	
	/**
	 * Setter for rbac user
	 *
	 * @param Tx_Rbac_Domain_Model_User $rbacUser
	 */
	public function setRbacUser(Tx_Rbac_Domain_Model_User $rbacUser) {
		$this->rbacUser = $rbacUser;
	}
	
	
	
	/**
	 * Getter for current rbac user
	 *
	 * @return Tx_Rbac_Domain_Model_User
	 */
	public function getRbacUser() {
		return $this->rbacUser;
	}
	
}
 
?>