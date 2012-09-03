<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Class implements hook for tx_cms_layout
 *
 * @package Hooks
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class user_Tx_Yag_Hooks_CMSLayoutHook {
	
	Const EXTENSION_NAME = 'Yag'; 
	Const PLUGIN_NAME = 'web_YagTxYagM1';
	
	/**
	 * Plugin mode determined from switchableControllerAction
	 * @var string
	 */
	protected $pluginMode;
	
	
	/**
	 * @var string
	 */
	protected $theme;
	
	
	/**
	 * @var unknown_type
	 */
	protected $fluidRenderer;
	
	
	/**
	 * Render the Plugin Info
	 * 
	 * @param unknown_type $params
	 * @param unknown_type $pObj
	 */
	public function getExtensionSummary($params, &$pObj) {
		
		$data = t3lib_div::xml2array($params['row']['pi_flexform']);
		$this->init($data);
		
		$this->fluidRenderer->assign($this->pluginMode, TRUE);
		$this->fluidRenderer->assign('object', $this->getSelectedObject($data));
		$this->fluidRenderer->assign('caLabel', 'LLL:EXT:yag/Resources/Private/Language/locallang.xml:tx_yag_flexform_controllerAction.' . $this->pluginMode);
		$this->fluidRenderer->assign('theme', $this->theme);
		
		return $this->fluidRenderer->render();
	}
	
	
	
	/**
	 * Init some values
	 * 
	 * @param array $data
	 */
	protected function init($data) {
		
		$templatePathAndFilename = t3lib_div::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/PluginInfo.html');
		
		// Extbase
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager'); 
		$configuration['extensionName'] = self::EXTENSION_NAME;
		$configuration['pluginName'] = self::PLUGIN_NAME;
		$bootstrap = t3lib_div::makeInstance('Tx_Extbase_Core_Bootstrap');
		$bootstrap->initialize($configuration);
		
		// Fluid
		$this->fluidRenderer = $objectManager->create('Tx_Fluid_View_StandaloneView');
		$this->fluidRenderer->setTemplatePathAndFilename($templatePathAndFilename);

		// PluginMode
		if(is_array($data)) {
			$firstControllerAction = array_shift(explode(';', $data['data']['sDefault']['lDEF']['switchableControllerActions']['vDEF']));
			$this->pluginMode = str_replace('->', '_', $firstControllerAction);	

			// Theme
			$this->theme = $data['data']['sDefault']['lDEF']['settings.theme']['vDEF'];
		}
	}
	
	
	/**
	 * 
	 * Get the selected Object
	 */
	protected function getSelectedObject($data) {
		switch($this->pluginMode) {
			case 'Album_showSingle':
				$albumUid = (int) $data['data']['source']['lDEF']['settings.context.selectedAlbumUid']['vDEF'];
				if($albumUid) {
					$albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
					return $albumRepository->findByUid($albumUid);
				}
				break;
			case 'Gallery_showSingle':
				$galleryUid = (int) $data['data']['source']['lDEF']['settings.context.selectedGalleryUid']['vDEF'];
				if($galleryUid) {
					$galleryRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository');
					return $galleryRepository->findByUid($galleryUid);
				}
				break;
			case 'Item_showSingle':
				$itemUid = (int) $data['data']['source']['lDEF']['settings.context.selectedItemUid']['vDEF'];
				if($itemUid) {
					$itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
					return $itemRepository->findByUid($itemUid);
				}
				break;
			default:
		}
	}
}

?>