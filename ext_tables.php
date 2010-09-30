<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Yet Another Gallery'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Yet Another Gallery');

//$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';
//t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi1', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');


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

t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_itemtype', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_itemtype.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_itemtype');
$TCA['tx_yag_domain_model_itemtype'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemtype',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/ItemType.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_itemtype.gif'
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

t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_resolutionpreset', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_resolutionpreset.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_resolutionpreset');
$TCA['tx_yag_domain_model_resolutionpreset'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolutionpreset',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/ResolutionPreset.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_resolutionpreset.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_resolution', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_resolution.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_resolution');
$TCA['tx_yag_domain_model_resolution'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolution',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Resolution.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_resolution.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_itemfile', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_itemfile.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_itemfile');
$TCA['tx_yag_domain_model_itemfile'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemfile',
		'label' 			=> 'path',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/ItemFile.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_itemfile.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_itemsourcetype', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_itemsourcetype.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_itemsourcetype');
$TCA['tx_yag_domain_model_itemsourcetype'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemsourcetype',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/ItemSourceType.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_itemsourcetype.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_itemsource', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_itemsource.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_itemsource');
$TCA['tx_yag_domain_model_itemsource'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemsource',
		'label' 			=> 'uri',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/ItemSource.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_itemsource.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_yag_domain_model_resolutionitemfilerelation', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_resolutionitemfilerelation.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_yag_domain_model_resolutionitemfilerelation');
$TCA['tx_yag_domain_model_resolutionitemfilerelation'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolutionitemfilerelation',
		'label' 			=> 'item',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/ResolutionItemFileRelation.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_yag_domain_model_resolutionitemfilerelation.gif'
	)
);

?>