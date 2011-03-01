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
		if(!$this->configurationBuilder) {

			$configuration['extensionName'] = self::EXTENSION_NAME;
			$configuration['pluginName'] = self::PLUGIN_NAME;
			
			
			$bootstrap = t3lib_div::makeInstance('Tx_Extbase_Core_Bootstrap');
			$bootstrap->initialize($configuration);
			
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
		
		// Jquery
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/JQuery/jquery-1.4.4.min.js', 'text/javascript', $compress);
		$pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/JQuery/jquery-ui-1.8.7.custom.min.js', 'text/javascript', $compress);
		
		$pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/JQuery/base.css', 'stylesheet', 'all', '', $compress);
		$pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css', 'stylesheet', 'all', '', $compress);
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
	 * 
	 * Get Album List as JSON 
	 */
	public function getAlbumSelectList() {
		
		$this->init(t3lib_div::_GP('PID'));
		
		$galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
		
		$galleryID = (int) t3lib_div::_GP('galleryUid');
		$albums = $galleryRepository->findByUid($galleryID)->getAlbums();
		
		$template = t3lib_div::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormAlbumList.html');
		$renderer = $this->getFluidRenderer();
		
		$renderer->setTemplatePathAndFilename($template);
		
		$renderer->assign('albums', $albums);		
		
		$content = $renderer->render();
		
		echo $content;
	}
	
	
	
	/**
	 * Render the selector for an album
	 * 
	 * @param unknown_type $PA
	 * @param unknown_type $fobj
	 */
	public function renderAlbumSelector(&$PA, &$fobj) {
		
		$this->init($PA['row']['pid']);
		
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
			}
			
			$albums = $selectedGallery->getAlbums();
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
		
		return $content;
		
	}
	
	
	
	/**
	 * Render gallery selector
	 * 
	 * @param unknown_type $PA
	 * @param unknown_type $fobj
	 */
	public function renderGallerySelector(&$PA, &$fobj) {
		
		$this->init($PA['row']['pid']);
		
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
		
		/* @var $galleryRepository Tx_Yag_Domain_Repository_GalleryRepository */
		$galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
		
		$galleries = $galleryRepository->findAll();
	
		$template = t3lib_div::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormImage.html');
		$renderer = $this->getFluidRenderer();
		
		$renderer->setTemplatePathAndFilename($template);
		
		$renderer->assign('galleries', $galleries);
		$renderer->assign('PA', $PA);		
		
		$content = $renderer->render();
		
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
	
}
?>