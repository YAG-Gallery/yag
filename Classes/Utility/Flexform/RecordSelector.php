<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <knoll@punkt.de>
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

require_once t3lib_extMgm::extPath('pt_tools').'res/staticlib/class.tx_pttools_div.php'; // pt_tools div class

/**
 * Class provides dataProvider for FlexForm select lists
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 * @package Utility
 */

class user_Tx_Yag_Utility_Flexform_RecordSelector {
	

	/**
	 * Album repository
	 *
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;
	
	
	/**
	 * Extbase Object Manager
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;
	
	
	/**
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory
	 */
	protected $configurationBuilder = NULL;
	
	
	/**
	 * Fluid Renderer
	 * @var Tx_Fluid_View_TemplateView
	 */
	protected $fluidRenderer = NULL;
	
	
	Const EXTENSION_NAME = 'yag'; 
	Const PLUGIN_NAME = 'Pi1';

	
	/**
	 * Init the extbase Context and the configurationBuilder
	 * 
	 * @param integer $pid
	 * @throws Exception
	 */
	protected function init($pid) {

		$configuration['extensionName'] = self::EXTENSION_NAME;
		$configuration['pluginName'] = self::PLUGIN_NAME;
		
		
		$bootstrap = t3lib_div::makeInstance('Tx_Extbase_Core_Bootstrap');
		$bootstrap->initialize($configuration);
		
		
		if(!$this->configurationBuilder) {
			
			$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager'); 
			
			try {
				// try to get the instance from factory cache
				$this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance('backend');
			} catch (Exception $e) {
				if(!$pid) throw new Exception('Need PID for initialation - No PID given! 1298928835');
					
				$settings = $this->getTyposcriptSettings($pid);
				Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::injectSettings($settings);
				$this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance('backend');
				
				$this->initBackendRequirements();
			}
		}
	}
	
	
	
	/**
	 * Get the typoscript loaded on the current page
	 * 
	 * @param $pid
	 */
	protected function getTyposcriptSettings($pid) {
		$typoScript = tx_pttools_div::returnTyposcriptSetup($pid, 'plugin.tx_yag.settings.');
		return  Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($typoScript);
	}	
	
	
	
	/**
	 * Load JQuery Files
	 * 
	 */
	public function initBackendRequirements() {
		$doc = $this->getDocInstance();
		$baseUrl = '../' . t3lib_extMgm::siteRelPath('yag');

		$pageRenderer = $doc->getPageRenderer();
		
		$compress = true;
		
		// Jquery
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/JQuery/jquery-1.5.1.min.js', 'text/javascript', $compress);
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/JQuery/jquery-ui-1.8.10.custom.min.js', 'text/javascript', $compress);
		
		$pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/JQuery/base.css', 'stylesheet', 'all', '', $compress);
		$pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css', 'stylesheet', 'all', '', $compress);
		
		// Backend
		$pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/Backend.css', 'stylesheet', 'all', '', $compress);
	}
	
	
	
	/**
	* Gets instance of template if exists or create a new one.
	* Saves instance in viewHelperVariableContainer
	*
	* @return template $doc
	*/
	public function getDocInstance() {
		if (!isset($GLOBALS['SOBE']->doc)) {
			$GLOBALS['SOBE']->doc = t3lib_div::makeInstance('template');
			$GLOBALS['SOBE']->doc->backPath = $GLOBALS['BACK_PATH'];
		}
		return $GLOBALS['SOBE']->doc;
	}
	
	
	
	/**
	 * get the current pid
	 * 
	 */
	protected function getCurrentPID($pid = 0) {
		if($pid > 0) return $pid;
		
		$pid = (int) $config['row']['pid'];
		if($pid > 0) return $pid;
		
		// UUUUhh !!
		$returnUrlArray = explode('id=', t3lib_div::_GP('returnUrl'));
		$pid = (int) array_pop($returnUrlArray); 
		return $pid;
	}
	
	
	
	/**
	 * Get Album List as JSON 
	 */
	public function getAlbumSelectList() {
		
		$this->init($this->getCurrentPID());
		
		$galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
		
		$galleryID = (int) t3lib_div::_GP('galleryUid');
		$albums = $galleryRepository->findByUid($galleryID)->getAlbums();
		
		$template = t3lib_div::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormAlbumList.html');
		$renderer = $this->getFluidRenderer();
		
		$renderer->setTemplatePathAndFilename($template);
		
		$renderer->assign('albums', $albums);		
		
		$content = $renderer->render();
		
		$this->extbaseShutdown();
		
		echo $content;
	}
	
	
	
	/**
	 * Get Image List as JSON 
	 */
	public function getImageSelectList() {
		
		$this->init($this->getCurrentPID());
		
		$albumRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_AlbumRepository');
		
		$albumID = (int) t3lib_div::_GP('albumUid');
		$images = $albumRepository->findbyUid($albumID)->getItems();
		
		$template = t3lib_div::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormImageList.html');
		$renderer = $this->getFluidRenderer();
		
		$renderer->setTemplatePathAndFilename($template);
		
		$renderer->assign('images', $images);		
		$content = $renderer->render();
		
		$this->extbaseShutdown();
		
		echo $content;
	}
	
	
	
	/**
	 * Render the selector for an album
	 * 
	 * @param unknown_type $PA
	 * @param unknown_type $fobj
	 */
	public function renderAlbumSelector(&$PA, &$fobj) {
		
		$this->init($this->getCurrentPID($PA['row']['pid']));
		
		$PA['elementID'] = 'field_' . md5($PA['itemFormElID']);
		$selectedAlbumUid = (int) $PA['itemFormElValue'];
		
		/* @var $galleryRepository Tx_Yag_Domain_Repository_GalleryRepository */
		$galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
		$galleries = $galleryRepository->findAll();
		
		if($selectedAlbumUid) {
			$albumRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_AlbumRepository');
			$selectedAlbum = $albumRepository->findByUid($selectedAlbumUid);
			if($selectedAlbum) {
				/* @var $selectedAlbum Tx_Yag_Domain_Model_Album */
				$selectedGalleries = $selectedAlbum->getGalleries();
				$selectedGallery = $selectedGalleries->current();
				
				if($selectedGallery) {
					$albums = $selectedGallery->getAlbums();	
				}
			}
		}
		
		
		$template = t3lib_div::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormAlbum.html');
		$renderer = $this->getFluidRenderer();
		
		$renderer->setTemplatePathAndFilename($template);
		
		$renderer->assign('galleries', $galleries);
		$renderer->assign('albums', $albums);
		$renderer->assign('selectedAlbumUid', $selectedAlbumUid);	
		$renderer->assign('selectedAlbum', $selectedAlbum);	
		$renderer->assign('selectedGallery', $selectedGallery);	
		$renderer->assign('PA', $PA);		
		
		$content = $renderer->render();

		//$this->extbaseShutdown();
		
		return $content;
	}
	
	
	
	/**
	 * Render gallery selector
	 * 
	 * @param unknown_type $PA
	 * @param unknown_type $fobj
	 */
	public function renderGallerySelector(&$PA, &$fobj) {
		
		$this->init($this->getCurrentPID($PA['row']['pid']));
		
		$PA['elementID'] = 'field_' . md5($PA['itemFormElID']);
		
		/* @var $galleryRepository Tx_Yag_Domain_Repository_GalleryRepository */
		$galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
		
		$galleries = $galleryRepository->findAll();
	
		$template = t3lib_div::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormGallery.html');
		$renderer = $this->getFluidRenderer();
		
		$renderer->setTemplatePathAndFilename($template);
		
		$renderer->assign('galleries', $galleries);
		$renderer->assign('PA', $PA);		
	
		$content = $renderer->render();
		
		//$this->extbaseShutdown();
		
		return $content;
	}
	
	
	
	/**
	 * Render the image Selector
	 * 
	 * @param unknown_type $PA
	 * @param unknown_type $fobj
	 */
	public function renderImageSelector(&$PA, &$fobj) {
		
		$this->init($PA['row']['pid']);
		
		$PA['elementID'] = 'field_' . md5($PA['itemFormElID']);
		$selectedImageUid = (int) $PA['itemFormElValue'];
		
		$template = t3lib_div::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormImage.html');
		$renderer = $this->getFluidRenderer();
		
		$renderer->setTemplatePathAndFilename($template);
		
		
		/* @var $galleryRepository Tx_Yag_Domain_Repository_GalleryRepository */
		$galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
		$galleries = $galleryRepository->findAll();
		
		if($selectedImageUid) {
			
			$itemRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository');
			$selectedImage = $itemRepository->findByUid($selectedImageUid);
			
			if($selectedImage) {
				/* @var $selectedImage Tx_Yag_Domain_Model_Item */
				
				$selectedAlbum = $selectedImage->getAlbum();
				
				$selectedGalleries = $selectedAlbum->getGalleries();
				/* @var $selectedGallery Tx_Yag_Domain_Model_Gallery */
				$selectedGallery = $selectedGalleries->current();
			
				$renderer->assign('selectedImage', $selectedImage);	
				$renderer->assign('selectedAlbum', $selectedAlbum);	
				$renderer->assign('selectedGallery', $selectedGallery);	
				
				$renderer->assign('albums', $selectedGallery->getAlbums());
				$renderer->assign('images', $selectedAlbum->getItems());
			}
		}
		
		$renderer->assign('galleries', $galleries);
		$renderer->assign('PA', $PA);
		
		$content = $renderer->render();
		
		$this->extbaseShutdown();
		
		return $content;
	}
	
	
	
	/**
	 * Build A Fluid Renderer
	 * @return Tx_Fluid_View_TemplateView
	 */
	protected function getFluidRenderer() {
		if(!$this->fluidRenderer) {	

			$configuration['extensionName'] = 'yag';
			$configuration['pluginName'] = 'Pi1';
			
			/* @var $request Tx_Extbase_MVC_Request */
			$request = $this->objectManager->get('Tx_Extbase_MVC_Request');
			$request->setControllerExtensionName(self::EXTENSION_NAME);
			$request->setPluginName(self::PLUGIN_NAME);
			
			$this->fluidRenderer = $this->objectManager->get('Tx_Fluid_View_TemplateView');
			$controllerContext = $this->objectManager->get('Tx_Extbase_MVC_Controller_ControllerContext');
			$controllerContext->setRequest($request);
			$this->fluidRenderer->setControllerContext($controllerContext);
		}
		
		return $this->fluidRenderer;
	}
	
	/**
	 * Do all methods to clean shutdown extbase
	 * 
	 */
	protected function extbaseShutdown() {
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager'); /* @var $persistenceManager Tx_Extbase_Persistence_Manager */
        $persistenceManager->persistAll();
        
        $reflectionService = t3lib_div::makeInstance('Tx_Extbase_Reflection_Service');
        $reflectionService->shutdown();
	}
	
}
?>