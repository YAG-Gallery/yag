<?php
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

if (!defined('TYPO3_MODE')) die ('Access denied.');

/**
 * Register Frontend Plugin
 */
ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'YAG - Yet Another Gallery'
);

/**
 * Register Backend Module
 */
if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	ExtensionUtility::registerModule(
		$_EXTKEY,
		'web', // Make module a submodule of 'web'
		'tx_yag_m1', // Submodule key
		'', // Position
		array( // An array holding the controller-action-combinations that are accessible
			'Gallery' => 'list, index, show, new, create, edit, update, delete',
			'Album' => 'show, new, create, edit, update, delete, addItems, updateSorting, bulkUpdate',
			'FileUpload' => 'upload',
			'Item' => 'index, show, new, create, edit, update, delete, bulkUpdate',
			'ItemList' => 'list,submitFilter',
			'ItemFile' => 'index, show, new, create, edit, update, delete',
			'DirectoryImport' => 'showImportForm, importFromDirectory',
			'ZipImport' => 'showImportForm, importFromZip, createNewAlbumAndImportFromZip',
			'Remote' => 'addItemToAlbum, albumList, galleryList',
			'Ajax' => 'updateItemSorting,updateGallerySorting,directoryAutoComplete,deleteItem,deleteGallery,deleteAlbum,updateItemTitle,setItemAsAlbumThumb,
				updateItemDescription,updateAlbumSorting,updateAlbumTitle,updateAlbumDescription,updateGenericProperty,
				setAlbumAsGalleryThumb,hideAlbum,unhideAlbum,hideGallery,unhideGallery,getSubDirs',
			'AdminMenu' => 'index',

			// This is additional for backend! Keep in mind, when copy&pasting from ext_localconf
			'Backend' => 'settingsNotAvailable,extConfSettingsNotAvailable,noGalleryIsPosibleOnPIDZero,maintenanceOverview,clearAllPageCache,doDbUpdate,markPageAsYagSysFolder',
			'ResolutionFileCache' => 'clearResolutionFileCache,buildResolutionByConfiguration,buildAllItemResolutions',
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:yag/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
		)
	);

	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['Tx_Yag_Utility_WizzardIcon'] = ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Utility/WizzardIcon.php';

	// Register status report checks in backend
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['YAG'] = array(
		'Tx_Yag_Report_ExternalLibraries',
		'Tx_Yag_Report_Filesystem',
		'Tx_Yag_Report_EnvironmentVariables'
	);


	// Add Backend TypoScript
	ExtensionManagementUtility::addTypoScript($_EXTKEY, 'setup', '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Backend/Setup.txt">');
}


/**
 * Register Plugin as Page Content
 */
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key,pages';


/**
 * Register static Typoscript Template
 */
ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', '[yag] Yet Another Gallery');


/**
 * Register flexform
 */
ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Flexform.xml');
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';


/**
 * Make the YAG content tables categorizable using the TYPO3 category API
 */
ExtensionManagementUtility::makeCategorizable($_EXTKEY, 'tx_yag_domain_model_item', 'categories', array());
ExtensionManagementUtility::makeCategorizable($_EXTKEY, 'tx_yag_domain_model_album', 'categories', array());
ExtensionManagementUtility::makeCategorizable($_EXTKEY, 'tx_yag_domain_model_gallery', 'categories', array());

/**
 * TCA Configuration
 */
ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_album', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_album.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_album');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_gallery', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_gallery.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_gallery');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_item', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_item.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_item');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_resolutionfilecache', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_resolutionfilecache.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_resolutionfilecache');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_itemmeta', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_itemmeta.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_itemmeta');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_tag', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_tag.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_tag');

// Register yag for 'contains plugin' in sysfolders
$TCA['pages']['columns']['module']['config']['items'][] = array('LLL:EXT:yag/Resources/Private/Language/locallang.xlf:tx_yag_general.yag', 'yag', 'i/ext_icon.gif');
\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('pages', 'contains-yag', '../typo3conf/ext/yag/ext_icon.gif');