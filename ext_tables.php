<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

/**
 * Register Frontend Plugin
 */
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'YAG - Yet Another Gallery'
);



/**
 * Register Backend Module
 */
if (TYPO3_MODE === 'BE')	{

	/**
	* Registers a Backend Module
	*/
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',					// Make module a submodule of 'web'
		'tx_yag_m1',			// Submodule key
		'',						// Position
		array(																			// An array holding the controller-action-combinations that are accessible
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
			'Backend' => 'settingsNotAvailable,extConfSettingsNotAvailable,noGalleryIsPosibleOnPIDZero,maintenanceOverview,clearAllPageCache,doDbUpdate,markPageAsYagSysfolder',
			'ResolutionFileCache' => 'clearResolutionFileCache,buildResolutionByConfiguration,buildAllItemResolutions',
			),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:yag/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml',
		)
	);
	
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['Tx_Yag_Utility_WizzardIcon'] = t3lib_extMgm::extPath($_EXTKEY). 'Classes/Utility/WizzardIcon.php';

	// Register status report checks in backend
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['YAG'] = array(
		'Tx_Yag_Report_ExternalLibraries',
		'Tx_Yag_Report_Filesystem',
		'Tx_Yag_Report_EnvironmentVariables'
	);
}


/**
 * Register Plugin as Page Content
 */
$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature]='select_key,pages';



/**
 * Register static Typoscript Template
 */
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', '[yag] Yet Another Gallery');
//t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Feeds/', '[yag] Feeds');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Standalone/', '[yag] Standalone');



/**
 * Register flexform
 */
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Flexform.xml');
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';





/**
 * TCA Configuration
 */
t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_album', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_album.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_album');
$TCA['tx_yag_domain_model_album'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album',
		'label' 			=> 'name',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden',
			'fe_group' => 'fe_group'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Album.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_album.png'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_gallery', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_gallery.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_gallery');
$TCA['tx_yag_domain_model_gallery'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery',
		'label' 			=> 'name',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden',
			'fe_group' => 'fe_group'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Gallery.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_gallery.png'
	)
);


t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_item', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_item.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_item');
$TCA['tx_yag_domain_model_item'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item',
		'label' 			=> 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden',
			'fe_group' => 'fe_group'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Item.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_item.png'
	)
);


t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_resolutionfilecache', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_resolutionfilecache.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_resolutionfilecache');
$TCA['tx_yag_domain_model_resolutionfilecache'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolutionfilecache',
		'label' 			=> 'name',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/ResolutionFileCache.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_resolutionfilecache.png'
	)
);


t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_itemmeta', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_itemmeta.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_itemmeta');
$TCA['tx_yag_domain_model_itemmeta'] = array (
    'ctrl' => array (
        'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta',
        'label'             => 'uid',
        'tstamp'            => 'tstamp',
        'crdate'            => 'crdate',
        'versioningWS'      => 2,
        'versioning_followPages'    => TRUE,
        'origUid'           => 't3_origuid',
        'languageField'     => 'sys_language_uid',
        'transOrigPointerField'     => 'l18n_parent',
        'transOrigDiffSourceField'  => 'l18n_diffsource',
        'delete'            => 'deleted',
        'enablecolumns'     => array(
            'disabled' => 'hidden'
            ),
        'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/ItemMeta.php',
        'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_itemmeta.png'
    )
);

t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_tag', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_tag.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_tag');
$TCA['tx_yag_domain_model_tag'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_tag',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Tag.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_tag.png'
	),
);

// Register yag for 'contains plugin' in sysfolders
$TCA['pages']['columns']['module']['config']['items'][] = array('LLL:EXT:yag/Resources/Private/Language/locallang.xml:tx_yag_general.yag', 'yag', 'i/ext_icon.gif');
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-yag', '../typo3conf/ext/yag/ext_icon.gif');

?>