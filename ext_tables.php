<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');



/**
<<<<<<< HEAD
 * Register Plugin
=======
 * Register Frontend Plugin
>>>>>>> 763010c0c4545c3bda2dd9b68f3df4aa15a801c0
 */
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'YAG - Yet Another Gallery'
);



/**
<<<<<<< HEAD
=======
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
			'Album' => 'show, new, create, edit, update, delete, addItems',
			'Item' => 'index, show, new, create, edit, update, delete',
			'ItemList' => 'list',
		    'ItemAdminList' => 'list',
			'ItemFile' => 'index, show, new, create, edit, update, delete',
			'DirectoryImport' => 'showImportForm, importFromDirectory',
		    'ZipImport' => 'showImportForm, importFromZip, createNewAlbumAndImportFromZip',
			'Development' => 'createSampleData, deleteAll,testExif',
		    'Remote' => 'addItemToAlbum, albumList, galleryList',
		    'Ajax' => 'directoryAutoComplete,deleteItem,updateItemName,setItemAsAlbumThumb,updateItemDescription,updateAlbumSorting,updateAlbumTitle,updateAlbumDescription,updateGenericProperty',
		    'Navigation' => 'show',
		    'AjaxEditing' => 'index',
		    'Setup' => 'index, setupRbac,truncateTables',
			'Backend' => 'settingsNotAvailable',
			),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:yag/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml',
		)
	);
}


/**
>>>>>>> 763010c0c4545c3bda2dd9b68f3df4aa15a801c0
 * Register Plugin as Page Content
 */
$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature]='layout,select_key,pages';



/**
 * Register static Typoscript Template
 */
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', '[yag] Yet Another Gallery');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Feeds/', '[yag] Feeds');
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
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Album.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_album.gif'
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
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Gallery.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_gallery.gif'
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
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Item.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_item.gif'
	)
);


t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_resolutionfilecache', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_resolutionfilecache.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_resolutionfilecache');
$TCA['tx_yag_domain_model_resolutionfilecache'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolutionfilecache',
		'label' 			=> 'width',
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
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_resolutionfilecache.gif'
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
        'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_itemmeta.gif'
    )
);

?>