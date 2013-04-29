<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>, Daniel Lienert <daniel@lienert.cc>
*            
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
 * Configuration file for YAG gallery
 *
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */

if (!defined ('TYPO3_MODE')) 	die ('Access denied.');


/*
 * Main plugin
 */
Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		  'Album' => 'show,showSingle,list,                      			new,delete,edit,addItems,create,update',
		  'Gallery' => 'list, showSingle, index,                 			new,create,edit,update,delete',
		  'Item' => 'index, show, showSingle, showRandomSingle, download,  	delete',
		  'ItemList' => 'list,submitFilter,uncachedList,downloadAsZip',
		  // 'Remote' => 'addItemToAlbum, albumList, galleryList, testConnection',
		  'FileUpload' => 'upload',
		  'Error' => 'index',
	),
	array(
        'Gallery' => 'new,create,edit,update,delete',
		'Album' => 'new,delete,edit,addItems,create,update',
		'Item' => 'delete, download',
		'ItemList' => 'unCachedList,downloadAsZip',
		'FileUpload' => 'upload',
	)
);



if(TYPO3_MODE == 'BE') {
	$yagExtConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag']);

	// Hooks
	$TYPO3_CONF_VARS['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['yag_pi1']['yag'] = 'EXT:yag/Classes/Hooks/CMSLayoutHook.php:user_Tx_Yag_Hooks_CMSLayoutHook->getExtensionSummary';

	// Clear resFileCache with clearCacheCommand
	if((int) $yagExtConfig['clearResFileCacheWithCacheClearCommand'] === 1) {
		$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearAllCache_additionalTables']['tx_yag_domain_model_resolutionfilecache'] = 'tx_yag_domain_model_resolutionfilecache';
	}

	// Flexform general
	require_once t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/Div.php';


	// Flexform typoScript data provider
	require_once t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/TyposcriptDataProvider.php';


	// Flexform record selector
	require_once t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/RecordSelector.php';
	$TYPO3_CONF_VARS['BE']['AJAX']['txyagM1::getGalleryList'] = t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/RecordSelector.php:user_Tx_Yag_Utility_Flexform_RecordSelector->getGallerySelectList';
	$TYPO3_CONF_VARS['BE']['AJAX']['txyagM1::getAlbumList'] = t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/RecordSelector.php:user_Tx_Yag_Utility_Flexform_RecordSelector->getAlbumSelectList';
	$TYPO3_CONF_VARS['BE']['AJAX']['txyagM1::getImageList'] = t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/RecordSelector.php:user_Tx_Yag_Utility_Flexform_RecordSelector->getImageSelectList';
	$TYPO3_CONF_VARS['BE']['AJAX']['yagAjaxDispatcher'] = t3lib_extMgm::extPath('yag').'Classes/Utility/AjaxDispatcher.php:Tx_Yag_Utility_AjaxDispatcher->dispatch';


}

?>