<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_yag_domain_model_itemmeta'] = array(
	'ctrl' => $TCA['tx_yag_domain_model_itemmeta']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'exif,iptc,xmp,artist,artist_mail,artist_website,copyright,camera_model,lens,iso,focal_length,shutter_speed,aperture,flash,gps_latitude,gps_longitude,keywords,description,item'
	),
	'types' => array(
		'1' => array('showitem' => 'exif,iptc,xmp,artist,artist_mail,artist_website,copyright,camera_model,lens,iso,focal_length,shutter_speed,aperture,flash,gps_latitude,gps_longitude,keywords,description,item')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_yag_domain_model_itemmeta',
				'foreign_table_where' => 'AND tx_yag_domain_model_itemmeta.uid=###REC_FIELD_l18n_parent### AND tx_yag_domain_model_itemmeta.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => array(
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array(
				'type'=>'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'exif' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.exif',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'iptc' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.iptc',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'xmp' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.xmp',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'artist' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.artist',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'artist_mail' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.artist_mail',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'artist_website' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.artist_website',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'copyright' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.copyright',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'camera_model' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.camera_model',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'lens' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.lens',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'iso' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.iso',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'focal_length' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.focal_length',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'shutter_speed' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.shutter_speed',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'aperture' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.aperture',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'flash' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.flash',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'gps_latitude' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.gps_latitude',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'gps_longitude' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.gps_longitude',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'keywords' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.keywords',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'description' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.description',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'item' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_itemmeta.item',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_yag_domain_model_item',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
				),
			)
		),
	),
);
?>