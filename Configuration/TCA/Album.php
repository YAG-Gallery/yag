<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_yag_domain_model_album'] = array(
	'ctrl' => $TCA['tx_yag_domain_model_album']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name,description,resolutions,resolution_presets,items,galleries,thumb'
	),
	'types' => array(
		'1' => array('showitem' => 'name,description,resolutions,resolution_presets,items,galleries,thumb')
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
				'foreign_table' => 'tx_yag_domain_model_album',
				'foreign_table_where' => 'AND tx_yag_domain_model_album.uid=###REC_FIELD_l18n_parent### AND tx_yag_domain_model_album.sys_language_uid IN (-1,0)',
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
		'name' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'description' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.description',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'items' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.items',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_yag_domain_model_item',
				'foreign_field' => 'album',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
				),
			)
		),
		'thumb' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.thumb',
            'config'  => array(
                'type' => 'passthrough',
                'foreign_table' => 'tx_yag_domain_model_item',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => array(
                    'collapse' => 0,
                    'newRecordLinkPosition' => 'bottom',
                )
            )
        ),
		'galleries' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.galleries',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_yag_domain_model_gallery',
				'MM' => 'tx_yag_album_gallery_mm',
				'maxitems' => 99999
			)
		),
	),
);
?>