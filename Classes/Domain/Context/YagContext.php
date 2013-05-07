<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * @subpackage Context
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Context_YagContext implements Tx_PtExtbase_State_Session_SessionPersistableInterface, 
												Tx_PtExtbase_State_GpVars_GpVarsInjectableInterface {

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
	const XML_LIST_ID = 'albumListXML';
	

	/**
	 * @var string
	 */
	protected $pluginModeIdentifier;
	

	/**
	 * @var string
	 */
	protected $identifier;
	

	/**
	 * @var array 
	 */
	protected $sessionData;
	

	/**
	 * @var array 
	 */
	protected $gpVarData;


	/**
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder;


	/**
	 * Holds pid selected by flexform source selector widget
	 *
	 * @var int
	 */
	protected $selectedPid = NULL;


	/**
	 * @var Tx_Yag_Domain_Model_Gallery
	 */
	protected $selectedGallery = NULL;
	

	/**
	 * @var Tx_Yag_Domain_Model_Album
	 */
	protected $selectedAlbum = NULL;
	

	/**
	 * @var Tx_Yag_Domain_Model_Item
	 */
	protected $selectedItem = NULL;
	

	/**
	 * @var Tx_Extbase_MVC_Controller_ControllerContext 
	 */
	protected $controllerContext;


	/**
	 * @var integer
	 */
	protected $selectedGalleryUid;
	
	
	/**
	 * @var integer
	 */
	protected $selectedAlbumUid;

	
	/**
	 * @var integer
	 */
	protected $selectedItemUid;


	/**
	 * @var Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	protected $galleryListContext = NULL;


	/**
	 * @var Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	protected $albumListContext = NULL;


	/**
	 * @var Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	protected $itemListContext = NULL;


	/**
	 * @var Tx_Extbase_Object_Manager
	 */
	protected $objectManager;

	
	/** 
	 * @var string $identifer
	 */
	public function __construct($identifier) {
		$this->identifier = $identifier;
	}


	/**
	 * @param Tx_Extbase_Object_ObjectManager $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}


	
	/**
	 * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 */
	public function injectConfigurationBuilder(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		$this->configurationBuilder = $configurationBuilder;
	}
	
	
	
	/**
	 * @param Tx_Extbase_MVC_Controller_ControllerContext $controllerContext
	 */
	public function injectControllerContext(Tx_Extbase_MVC_Controller_ControllerContext $controllerContext) {
		$this->controllerContext = $controllerContext;
	}


	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/StateAdapter/Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface::injectSessionData()
	 */
	public function injectSessionData(array $sessionData) {
		$this->sessionData = $sessionData;
	}



	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/StateAdapter/Tx_PtExtlist_Domain_StateAdapter_GetPostVarInjectableInterface::injectGPVars()
	 */
	public function injectGPVars($GPVars) {
		$this->gpVarData = $GPVars;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/StateAdapter/Tx_PtExtlist_Domain_StateAdapter_IdentifiableInterface::getObjectNamespace()
	 */
	public function getObjectNamespace() {
		return $this->identifier;
	}
	
	
	
	/**
	 * Return context identifier
	 * 
	 */
	public function getIdentifier() {
		return $this->identifier;
	}
	
	
	
	/**
	 * Return context identifier 
	 */
	public function getContextIdentifier() {
		return $this->identifier;
	}
	
	
	
	/**
	 * Main init method
	 * 
	 */
	public function init() {
		$this->initByConfiguration();
		$this->initBySessionData();
		$this->initByGpVars();
	}
	
	
	
	/**
	 * Init the context by configuration
	 */
	protected function initByConfiguration() {
		$this->selectedGalleryUid = $this->configurationBuilder->buildContextConfiguration()->getSelectedGalleryUid();
		$this->selectedAlbumUid = $this->configurationBuilder->buildContextConfiguration()->getSelectedAlbumUid();
		$this->selectedItemUid = $this->configurationBuilder->buildContextConfiguration()->getSelectedItemUid();
		$this->selectedPid = $this->configurationBuilder->buildContextConfiguration()->getSelectedPid();
	}
	
	
	
	/**
	 * Init the context by session data
	 */
	protected function initBySessionData() {
		if(is_array($this->sessionData)) {
			if(array_key_exists('galleryUid', $this->sessionData)) {
				$this->selectedGalleryUid = (int) $this->sessionData['galleryUid'];
			}

			if(array_key_exists('albumUid', $this->sessionData)) {
				$this->selectedAlbumUid = (int) $this->sessionData['albumUid'];
			}
		}
	}
	
	
	
	/**
	 * Init the context by gptVars
	 */
	protected function initByGpVars() {
		if(array_key_exists('galleryUid', $this->gpVarData)) {
			$this->selectedGalleryUid = (int) $this->gpVarData['galleryUid'];
		}
		
		if(array_key_exists('albumUid', $this->gpVarData)) {
			$this->selectedAlbumUid = (int) $this->gpVarData['albumUid'];
		}
	}


	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/StateAdapter/Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface::persistToSession()
	 */
	public function persistToSession() {
		$this->sessionData['albumUid'] = $this->selectedAlbumUid;
		$this->sessionData['galleryUid'] = $this->selectedGalleryUid;

		return array_filter($this->sessionData);
	}
	
	
	
	/**
	 * @param Tx_Yag_Domain_Model_Gallery $gallery
	 */
	public function setGallery(Tx_Yag_Domain_Model_Gallery $gallery) {
		$this->selectedGallery = $gallery;
		$this->selectedGalleryUid = $gallery->getUid();
	}
	
	

	/**
	 * @param Tx_Yag_Domain_Model_Album $album
	 */
	public function setAlbum(Tx_Yag_Domain_Model_Album $album) {
		$this->selectedAlbum = $album;
		$this->selectedAlbumUid = $album->getUid();
	}
	
	
	
	/**
	 * @param Tx_Yag_Domain_Model_Item $item
	 */
	public function setItem(Tx_Yag_Domain_Model_Item $item) {
		$this->selectedItem = $item;
		$this->selectedItemUid = $item->getUid();
	}
	
	
	
	/**
	 * @param int $albumUid
	 */
	public function setAlbumUid($albumUid) {
		$this->selectedAlbumUid = $albumUid;
	}
	
	
	
	/**
	 * @param int $galleryUid
	 */
	public function setGalleryUid($galleryUid) {
		$this->selectedGalleryUid = $galleryUid;
	}
	
	
	
	/**
	 * @param int $itemUid
	 */
	public function setItemUid($itemUid) {
		$this->selectedItemUid = $itemUid;
	}
	
	
		
	/**
	 * @return Tx_Extbase_MVC_Controller_ControllerContext $controllerContext
	 */
	public function getControllerContext() {
		return $this->controllerContext;
	}
	
	
	
	/**
	 * @return Tx_Yag_Domain_Model_Gallery
	 */
	public function getGallery() {
		
		if(!$this->selectedGalleryUid) return NULL;
		
		if($this->selectedGallery instanceof Tx_Yag_Domain_Model_Gallery && $this->selectedGallery->getUid() == $this->selectedGalleryUid) {
			return $this->selectedGallery;
		} else {
			return $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository')->findByUid($this->selectedGalleryUid);
		}
	}
	
	
	
	/**
	 * @return int galleryUid
	 */
	public function getGalleryUid() {
		return $this->selectedGalleryUid;
	}
	
	
	
	/**
	 * @return Tx_Yag_Domain_Model_Album
	 */
	public function getAlbum() {
		
		if(!$this->selectedAlbumUid) return NULL;
		
		if($this->selectedAlbum instanceof Tx_Yag_Domain_Model_Album && $this->selectedAlbum->getUid() == $this->selectedAlbumUid) {
			return $this->selectedAlbum;
		} else {
			return $this->objectManager->get('Tx_Yag_Domain_Repository_AlbumRepository')->findByUid($this->selectedAlbumUid);
		}
	}
	
	
	
	/**
	 * @return int albumUid;
	 */
	public function getAlbumUid() {
		return $this->selectedAlbumUid;
	}
	
	
	
	/**
	 * @return Tx_Yag_Domain_Model_Item
	 */
	public function getItem() {
		
		if(!$this->selectedItemUid) return NULL;
		
		if($this->selectedItem instanceof Tx_Yag_Domain_Model_Item && $this->selectedItem->getUid() == $this->selectedItemUid) {
			return $this->selectedItem;
		} else {
			return $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository')->findByUid($this->selectedItemUid);
		}
	}
	
	
	
	/**
	 * @return int itemUid
	 */
	public function getItemUid() {
		return $this->selectedItemUid;
	}
	
	
	
	/**
	 * Getter for itemlist context
	 *
	 * @return Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	public function getItemListContext() {
		if($this->itemListContext === NULL) {
			$this->itemListContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByCustomConfiguration(
				$this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::ITEM_LIST_ID),
				self::ITEM_LIST_ID . $this->identifier, FALSE);
		}

		return $this->itemListContext;
	}
	
	
	
	/**
	 * Getter for gallery list extlist context
	 *
	 */
	public function getGalleryListContext() {
		if($this->galleryListContext === NULL) {
			$this->galleryListContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByCustomConfiguration(
				$this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::GALLERY_LIST_ID),
				self::GALLERY_LIST_ID . $this->identifier, FALSE);
		}

		return $this->galleryListContext;
	}
	
	
	
	/**
	 * Getter for album list extlist context
	 *
	 */
	public function getAlbumListContext() {
		if($this->albumListContext === NULL) {
			$this->albumListContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByCustomConfiguration(
				$this->configurationBuilder->buildExtlistConfiguration()->getExtlistSettingsByListId(self::ALBUM_LIST_ID),
				self::ALBUM_LIST_ID . $this->identifier, FALSE);
		}

		return $this->albumListContext;
	}
	
	
	
	/**
	 * Return a string, which defines the current plugin mode
	 * This string is a combination of default / the first defined Action/Controller definition
	 *
	 * @return string pluginModeIdentifer
	 */
	public function getPluginModeIdentifier() {
		
		if(!$this->pluginModeIdentifier) {
			$configurationManager = $this->objectManager->get('Tx_Extbase_Configuration_ConfigurationManagerInterface');
			$frameworkConfiguration = $configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
			$controllerConfiguration = $frameworkConfiguration['controllerConfiguration'];
			$defaultControllerName = current(array_keys($controllerConfiguration));
			$defaultActionName = current($controllerConfiguration[$defaultControllerName]['actions']);
			$pluginModeIdentifier = $defaultControllerName . '_' . $defaultActionName;
		}
		
		return $pluginModeIdentifier;
	}



	/**
	 * @return Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	public function getConfigurationBuilder() {
		return $this->configurationBuilder;
	}



	/**
	 * Returns pid selected in flexform source widget
	 *
	 * @return int
	 */
	public function getSelectedPid() {
		return $this->selectedPid;
	}
}
?>