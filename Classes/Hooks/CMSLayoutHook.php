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
	 * @var Tx_Yag_Domain_Model_Gallery
	 */
	protected $selectedGallery;


	/**
	 * @var Tx_Yag_Domain_Model_Album
	 */
	protected $selectedAlbum;


	/**
	 * @var Tx_Yag_Domain_Model_Item
	 */
	protected $selectedItem;


	
	/**
	 * Render the Plugin Info
	 * 
	 * @param unknown_type $params
	 * @param unknown_type $pObj
	 */
	public function getExtensionSummary($params, &$pObj) {
		
		$data = t3lib_div::xml2array($params['row']['pi_flexform']);
		$this->init($data);
		$this->getSelectedObjects($data);

		$this->fluidRenderer->assign($this->pluginMode, TRUE);
		$this->fluidRenderer->assign('storageFolder', $this->getStorageFolder($data));
		$this->fluidRenderer->assign('gallery', $this->selectedGallery);
		$this->fluidRenderer->assign('album', $this->selectedAlbum);
		$this->fluidRenderer->assign('item', $this->selectedItem);
		$this->fluidRenderer->assign('caLabel', 'LLL:EXT:yag/Resources/Private/Language/locallang.xml:tx_yag_flexform_controllerAction.' . $this->pluginMode);
		$this->fluidRenderer->assign('theme', $this->theme);
		$this->fluidRenderer->assign('context', $this->getDataValue($data, 'settings.contextIdentifier'));

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
			$firstControllerAction = array_shift(explode(';', $this->getDataValue($data, 'switchableControllerActions', 'sDefault')));
			$this->pluginMode = str_replace('->', '_', $firstControllerAction);	

			// Theme
			$this->theme = $this->getDataValue($data, 'settings.theme', 'sDefault');
		}
	}


	/**
	 * @param array $data
	 * @return int
	 */
	protected function getStorageFolder($data) {
		$storageUid = (int) $this->getDataValue($data, 'settings.context.selectedPid');

		$rootLineArray = t3lib_BEfunc::BEgetRootLine($storageUid);
		$rootLine = '';

		foreach($rootLineArray as $rootLineElement) {
			$rootLine = $rootLineElement['title'] . '/' . $rootLine;
		}

		$folderName = sprintf('%s [%s]', substr($rootLine,1,-1), $storageUid);

		return $folderName;
	}


	
	/**
	 * Get the selected Objects
	 */
	protected function getSelectedObjects($data) {
		switch($this->pluginMode) {
			case 'ItemList_list':
			case 'ItemList_unCachedList':
			case 'Item_showSingle':
				$itemUid = (int) $this->getDataValue($data, 'settings.context.selectedItemUid');
				if($itemUid) {
					$itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
					$this->selectedItem = $itemRepository->findByUid($itemUid);
				}
			case 'Album_showSingle':
				$albumUid = (int) $this->getDataValue($data, 'settings.context.selectedAlbumUid');
				if($albumUid) {
					$albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
					$this->selectedAlbum = $albumRepository->findByUid($albumUid);
				}
			case 'Gallery_showSingle':
				$galleryUid = (int) $this->getDataValue($data, 'settings.context.selectedGalleryUid');
				if($galleryUid) {
					$galleryRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_GalleryRepository');
					$this->selectedGallery =  $galleryRepository->findByUid($galleryUid);
				}
				break;
			default:
		}
	}


	/**
	 * @param $data
	 * @param $key
	 * @return null
	 */
	protected function getDataValue($data, $key, $section = 'source') {
		if(is_array($data)
			&& array_key_exists('data', $data)
			&& array_key_exists($section, $data['data'])
			&& array_key_exists('lDEF', $data['data'][$section])
			&& array_key_exists($key, $data['data'][$section]['lDEF'])
			&& array_key_exists('vDEF', $data['data'][$section]['lDEF'][$key])) {
				return $data['data'][$section]['lDEF'][$key]['vDEF'];
			}

		return NULL;
	}
}

?>