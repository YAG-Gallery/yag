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
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */

if (!defined ('TYPO3_MODE')) 	die ('Access denied.');


/*
 * Main plugin
 */
Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		  'Album' => 'show,showSingle,                          new,delete,edit,addItems,create,update',
		  'Gallery' => 'list, showSingle, index                 new,create,edit,update,delete',
		  'Item' => 'index, show, showSingle, showRandomSingle  delete',
		  'ItemList' => 'list,submitFilter,randomList',
		  // 'Remote' => 'addItemToAlbum, albumList, galleryList, testConnection',
		  'MultifileUpload' => 'upload',
		  'Error' => 'index',
	),
	array(
        'Gallery' => 'new,create,edit,update,delete',
		'Album' => 'new,delete,edit,addItems,create,update',
		'Item' => 'delete',
		'ItemList' => 'randomList',
		'MultifileUpload' => 'upload',
	)
);

/*
 * Special plugin mode for XML export of list data
 */
/*
Tx_PtExtbase_Compatibility_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'XMLList',
	array('ItemList' => 'xmlList'),
	array()
);
*/


if(TYPO3_MODE == 'BE') {
	// Hooks
	$TYPO3_CONF_VARS['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['yag_pi1']['yag'] = 'EXT:yag/Classes/Hooks/CMSLayoutHook.php:user_Tx_Yag_Hooks_CMSLayoutHook->getExtensionSummary';

	// Flexform general
	require_once t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/Div.php';

	// Flexform typoScript data provider
	require_once t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/TyposcriptDataProvider.php';
	
	// Flexform record selctor
	require_once t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/RecordSelector.php';
	$TYPO3_CONF_VARS['BE']['AJAX']['txyagM1::getGalleryList'] = t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/RecordSelector.php:user_Tx_Yag_Utility_Flexform_RecordSelector->getGallerySelectList';
	$TYPO3_CONF_VARS['BE']['AJAX']['txyagM1::getAlbumList'] = t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/RecordSelector.php:user_Tx_Yag_Utility_Flexform_RecordSelector->getAlbumSelectList';
	$TYPO3_CONF_VARS['BE']['AJAX']['txyagM1::getImageList'] = t3lib_extMgm::extPath('yag').'Classes/Utility/Flexform/RecordSelector.php:user_Tx_Yag_Utility_Flexform_RecordSelector->getImageSelectList';
	$TYPO3_CONF_VARS['BE']['AJAX']['yagAjaxDispatcher'] = t3lib_extMgm::extPath('yag').'Classes/Utility/AjaxDispatcher.php:Tx_Yag_Utility_AjaxDispatcher->dispatch';
}

?>