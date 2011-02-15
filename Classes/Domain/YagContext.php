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
 * @author Daniel Lienert <daniel@lienert.cc>
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
	 * Holds a singleton instances of this class for
	 * 
	 * - anonymous instances of plugin (no album or gallery uid is given in settings)
	 * - instances with album uid given in settings
	 * - instances with gallery uid given in settings
	 * 
	 * Organized as an array:
	 * 
	 * array('anonymous' => $anonymousInstance,
	 *       'albums' (array ($albumUid => $instanceForAlbumUid)),
	 *       'galleries' (array ($galleryUid => $instanceForGalleryUid))
	 * );
	 *
	 * @var array
	 */
	private static $instances = array();
	
	
	
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
	 * @var Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	protected $gallerylistExtlistContext = null;
	
	
	
	/**
	 * Holds an instance of extlist context for album list
	 *
	 * @var Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	protected $albumlistExtlistContext = null;
	
	
	
	/**
	 * Holds an instance of extlist context for item list
	 *
	 * @var Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	protected $itemlistExtlistContext = null;
	
	
	
	/**
	 * Holds an instance of extlist context for rss feed list
	 *
	 * @var Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	protected $rsslistExtlistContext = null;
	
	
	
	/**
	 * Holds an instance of current MVC ControllerContext
	 *
	 * @var Tx_Extbase_MVC_Controller_ControllerContext 
	 */
	protected $controllerContext;
	
	
	
	/**
	 * Holds an instance of current rbac user
	 *
	 * @var Tx_Rbac_Domain_Model_User
	 */
	protected $rbacUser = null;
	
	
	
	/**
	 * List identifier prefix used for create unique list identifiers
	 * if e.g. a gallery or an album has been selected in single-mode 
	 *
	 * @var string
	 */
	protected $listIdentifierSuffix = '';
	
	
	
	/**
	 * Returns a singleton instance of this class
	 *
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @return Tx_Yag_Domain_YagContext Singleton instance of Tx_Yag_Domain_YagContext
	 */
	public static function getInstance(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder,
	       $selectedAlbumUid = null,
	       $selectedGalleryUid = null) {
		// Check whether an albumUid has been set (most likely in Flexform)
		if ($selectedAlbumUid > 0) {
			return self::getInstanceForAlbumUid($configurationBuilder, $selectedAlbumUid);
		} 
		
		// Check whether a galleryUid has been set (most likely in Flexform)
		elseif ($selectedGalleryUid > 0) {
			return self::getInstanceForGalleryUid($configurationBuilder, $selectedGalleryUid);
		}
		
		// We return an anonymous instance (no albumUid and no galleryUid has been set)
		else {
			return self::getAnonymousInstance($configurationBuilder);
		}
		
	}
	
	
	
	/**
	 * Returns an instance of yag context for selected album uid
	 *
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @param int $selectedAlbumUid
	 * @return Tx_Yag_Domain_YagContext
	 */
	protected static function getInstanceForAlbumUid(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder, $selectedAlbumUid) {
		self::checkAlbumsExistInInstancesArray();
		if (!array_key_exists($selectedAlbumUid, self::$instances['albums'])) {
			self::$instances['albums'][$selectedAlbumUid] = new Tx_Yag_Domain_YagContext($configurationBuilder, 'albumUid' . $selectedAlbumUid);
            $sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
            $sessionPersistenceManager->registerObjectAndLoadFromSession(self::$instances['albums'][$selectedAlbumUid]);
            self::$instances['albums'][$selectedAlbumUid]->initBySessionData();
		}
		return self::$instances['albums'][$selectedAlbumUid];
	}
	
	
	
	/**
	 * Checks whether instances array has sub-array for album-instances
	 */
	private static function checkAlbumsExistInInstancesArray() {
		if (!array_key_exists('albums', self::$instances)) {
			self::$instances['albums'] = array();
		}
	}
	
	
	
	/**
	 * Returns an instance of yag context for selected gallery uis
	 *
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @param int $selectedGalleryUid
	 * @return Tx_Yag_Domain_YagContext
	 */
	protected static function getInstanceForGalleryUid(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder, $selectedGalleryUid) {
		self::checkGalleriesExistInInstancesArray();
		if (!array_key_exists($selectedGalleryUid, self::$instances['galleries'])) {
			self::$instances['galleries'][$selectedGalleryUid] = new Tx_Yag_Domain_YagContext($configurationBuilder, 'galleryUid' . $selectedGalleryUid);
            $sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
            $sessionPersistenceManager->registerObjectAndLoadFromSession(self::$instances['galleries'][$selectedGalleryUid]);
            self::$instances['galleries'][$selectedGalleryUid]->initBySessionData();
        }
        return self::$instances['galleries'][$selectedGalleryUid];
	}
	
	
	
	/**
	 * Checks whether instances array has sub-array for gallery-instances
	 */
	private static function checkGalleriesExistsInInstancesArray() {
		if (!array_key_exists('galleries', self::$instances)) {
			self::$instances['galleries'] = array();
		}
 	}
	
	
	
	/**
	 * Returns an anonymous instance for yag context
	 *
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @return Tx_Yag_Domain_YagContext
	 */
	protected static function getAnonymousInstance(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		if (!(array_key_exists('anonymous', self::$instances) && self::$instances['anonymous'] !== null)) {
            self::$instances['anonymous'] = new Tx_Yag_Domain_YagContext($configurationBuilder);
            $sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
            $sessionPersistenceManager->registerObjectAndLoadFromSession(self::$instances['anonymous']);
            self::$instances['anonymous']->initBySessionData();
        }
        return self::$instances['anonymous'];
	}
	
	
	
	/**
	 * We hide constructor to force usage of getInstance()
	 * 
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @param string $listIdentifierSuffix Set this property, if you want to add a suffix for list identifiers
	 */
	protected function __construct(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder, $listIdentifierSuffix = ''){
		#print_r('erzeuge yag context mit suffix: ' . $listIdentifierSuffix);
		$this->configurationBuilder = $configurationBuilder;
		$this->listIdentifierSuffix = $listIdentifierSuffix;
	}
	
	
	
	/**
	 * Injector for MVC request
	 *
	 * @param Tx_Extbase_MVC_Request $request
	 */
	public function injectControllerContext(Tx_Extbase_MVC_Controller_ControllerContext $controllerContext) {
		$this->controllerContext = $controllerContext;
	}
	
	
	
	/**
	 * Creates gallery list extlist context
	 *
	 */
	protected function createGalleryListExtlistContext() {
		$this->gallerylistExtlistContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByCustomConfiguration(
		    $this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::GALLERY_LIST_ID), 
		    self::GALLERY_LIST_ID . $this->listIdentifierSuffix);
	}
	
	
	
	/**
	 * Creates album list extlist context
	 *
	 */
	protected function createAlbumListExtlistContext() {
		$this->albumlistExtlistContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByCustomConfiguration(
		    $this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::ALBUM_LIST_ID), 
		    self::ALBUM_LIST_ID . $this->listIdentifierSuffix);
	}
	
	
	
	/**
	 * Creates itemlist extlist context
	 *
	 */
	protected function createItemlistExtlistContext() {
		$this->itemlistExtlistContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByCustomConfiguration(
			    $this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::ITEM_LIST_ID), 
			    self::ITEM_LIST_ID . $this->listIdentifierSuffix);
	}
	
	
	
	/**
	 * Creates rsslist extlist context
	 *
	 */
	protected function createRsslistExtlistContext() {
		if ($this->rsslistExtlistContext === null) {
			$this->rsslistExtlistContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByCustomConfiguration(
			    $this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::RSS_LIST_ID), 
			    self::RSS_LIST_ID . $this->listIdentifierSuffix);
		}
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
		// We use list identifier suffix here to create a unique identifier if more than one instance of a plugin is used on a page
		return 'tx_yag' . $this->listIdentifierSuffix;
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
		if($this->selectedAlbum == NULL) {
			$filter = $this->getItemlistContext()->getDataBackend()->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('albumFilter');
	        /* @var $filter Tx_Yag_Extlist_Filter_GalleryFilter */
	        $this->selectedAlbum = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository')->findByUid($filter->getAlbumUid());
		}
		
		return $this->selectedAlbum;
	}
	
	
	
	/**
	 * Getter for selected gallery
	 *
	 * @return Tx_Yag_Domain_Model_Gallery
	 */
	public function getSelectedGallery() {
		if($this->selectedGallery == NULL) {
			$filter = $this->getAlbumListContext()->getDataBackend()->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('galleryFilter');
	        
	        /* @var $filter Tx_Yag_Extlist_Filter_GalleryFilter */
	        $this->selectedGallery = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository')->findByUid($filter->getGalleryUid());	
		}
		 
		return $this->selectedGallery;
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
	 * @return Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	public function getGalleryListContext() {
		$this->createGalleryListExtlistContext();
		return $this->gallerylistExtlistContext;
	}
	
	
	
	/**
	 * Getter for album list context
	 *
	 * @return Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	public function getAlbumListContext() {
		$this->createAlbumListExtlistContext();
		return $this->albumlistExtlistContext;
	}
	
	
	
	/**
	 * Getter for itemlist context
	 *
	 * @return Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	public function getItemlistContext() {
		$this->createItemlistExtlistContext();
		return $this->itemlistExtlistContext;
	}
	
	
	
	/**
	 * Getter for rsslist context
	 *
	 * @return Tx_PtExtlist_ExtlistContext_ExtlistContext
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
		return $this->controllerContext->getRequest();
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