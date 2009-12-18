<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin(
    $_EXTKEY,// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
    'Pi1',              // A unique name of the plugin in UpperCamelCase
    'Yet Another Gallery'    // A title shown in the backend dropdown field
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'YAG - Yet Another Gallery');

$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi1', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');


t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_gallery');
$TCA['tx_yag_domain_model_gallery'] = array (
	'ctrl' => array (
		'title'             => 'Gallery', //'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_blog', // TODO
		'label' 			=> 'name',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> true,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php', 
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_yag_domain_model_gallery.gif'
	)
);


t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_album');
$TCA['tx_yag_domain_model_album'] = array (
	'ctrl' => array (
		'title'             => 'Album', //'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_blog', // TODO
		'label' 			=> 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> true,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php', // TODO CREATE
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_yag_domain_model_album.gif' // TODO CREATE
	)
);


t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_image');
$TCA['tx_yag_domain_model_image'] = array (
	'ctrl' => array (
		'title'             => 'Image', //'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_blog', // TODO
		'label' 			=> 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> true,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php', // TODO CREATE
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_yag_domain_model_image.gif' // TODO CREATE
	)
);


t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_imagefile');
$TCA['tx_yag_domain_model_imagefile'] = array (
	'ctrl' => array (
		'title'             => 'ImageFile', //'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xml:tx_blogexample_domain_model_blog', // TODO
		'label' 			=> 'filePath',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> true,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php', // TODO CREATE
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_yag_domain_model_imagefile.gif' // TODO CREATE
	)
);



?>
