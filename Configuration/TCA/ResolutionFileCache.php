<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_yag_domain_model_resolutionfilecache'] = array(
	'ctrl' => $TCA['tx_yag_domain_model_resolutionfilecache']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'item,width,height,quality,path'
	),
	'types' => array(
		'1' => array('showitem' => 'item,width,height,quality,path')
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
				'foreign_table' => 'tx_yag_domain_model_resolutionfilecache',
				'foreign_table_where' => 'AND tx_yag_domain_model_resolutionfilecache.uid=###REC_FIELD_l18n_parent### AND tx_yag_domain_model_resolutionfilecache.sys_language_uid IN (-1,0)',
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
		'item' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolutionfilecache.item',
			'config'  => array(
				'type' => 'passthrough',
				'foreign_table' => 'tx_yag_domain_model_item',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
				),
			)
		),
		'width' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.width',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim'
			)
		),
		'height' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.height',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim'
			)
		),
		'quality' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.quality',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim'
			)
		),
		'path' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.path',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
	),
);
?>