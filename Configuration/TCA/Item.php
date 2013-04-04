<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

$TCA['tx_yag_domain_model_item'] = array(
    'ctrl' => $TCA['tx_yag_domain_model_item']['ctrl'],
    'interface' => array(
        'showRecordFieldList'   => 'title,filename,description,date,sourceuri,filehash,item_type,width,height,filesize,fe_user_uid,fe_group_uid,sorting,album,item_meta,fe_group',
    ),
    'types' => array(
        '1' => array('showitem' => 'title,description,link,date,fe_group'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'sys_language_uid' => array(
            'exclude'           => 1,
            'label'             => 'LLL:EXT:lang/locallang_general.php:LGL.language',
            'config'            => array(
                'type'                  => 'select',
                'foreign_table'         => 'sys_language',
                'foreign_table_where'   => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0)
                ),
            )
        ),
		'fe_group' => Array (
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.fe_group',
			'config' => Array (
				'type' => 'select',
				'size' => 5,
				'maxitems' => 20,
				'items' => Array (
					Array('LLL:EXT:lang/locallang_general.php:LGL.hide_at_login', -1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.any_login', -2),
					Array('LLL:EXT:lang/locallang_general.php:LGL.usergroups', '--div--')
				),
				'exclusiveKeys' => '-1,-2',
				'foreign_table' => 'fe_groups'
			)
		),
        'l18n_parent' => array(
            'displayCond'   => 'FIELD:sys_language_uid:>:0',
            'exclude'       => 1,
            'label'         => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
            'config'        => array(
                'type'          => 'select',
                'items'         => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_yag_domain_model_item',
                'foreign_table_where' => 'AND tx_yag_domain_model_item.uid=###REC_FIELD_l18n_parent### AND tx_yag_domain_model_item.sys_language_uid IN (-1,0)',
            )
        ),
        'l18n_diffsource' => array(
            'config'        =>array(
                'type'      =>'passthrough',
            )
        ),
        't3ver_label' => array(
            'displayCond'   => 'FIELD:t3ver_label:REQ:true',
            'label'         => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
            'config'        => array(
                'type'      =>'none',
                'cols'      => 27,
            )
        ),
        'hidden' => array(
            'exclude'   => 1,
            'label'     => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config'    => array(
                'type'  => 'check',
            )
        ),
        'title' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.title',
            'config'    => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'filename' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.filename',
            'config'    => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
		'original_filename' => array(
			'exclude'   => 0,
			'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.original_filename',
			'config'    => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
        'description' => array(
			'exclude' => 0,
			'l10n_mode' => 'noCopy',
			'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.description',
			'defaultExtras' => 'richtext[*]',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'Full screen Rich Text Editing',
						'icon' => 'wizard_rte2.gif',
						'script' => 'wizard_rte.php',
					),
				),
			)
        ),
        'date' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.date',
            'config'    => array(
                'type' => 'input',
                'size' => 12,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'sourceuri' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.sourceuri',
            'config'    => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'filehash' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.filehash',
            'config'    => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'item_type' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.item_type',
            'config'    => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'width' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.width',
            'config'    => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'height' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.height',
            'config'    => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
		'link' => array(
			'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.link',
			'exclude' => 1,
			'config' => array(
				'type' => 'input',
				'size' => '50',
				'max' => '256',
				'eval' => 'trim',
				'wizards' => array(
					'_PADDING' => 2,
					'link' => array(
						'type' => 'popup',
						'title' => 'LLL:EXT:cms/locallang_ttc.xml:header_link_formlabel',
						'icon' => 'link_popup.gif',
						'script' => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
					),
				),
				'softref' => 'typolink',
			),
		),
        'filesize' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.filesize',
            'config'    => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'fe_user_uid' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.fe_user_uid',
            'config'    => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'fe_group_uid' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.fe_group_uid',
            'config'    => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'sorting' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.sorting',
            'config'  => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim'
            )
        ),
        'album' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.album',
            'config'    => array(
                'type' => 'select',
                'foreign_table' => 'tx_yag_domain_model_album',
                'minitems' => 0,
                'maxitems' => 1,
                'wizards' => array(
                    '_PADDING' => 1,
                    '_VERTICAL' => 0,
                    'edit' => array(
                        'type' => 'popup',
                        'title' => 'Edit',
                        'script' => 'wizard_edit.php',
                        'icon' => 'edit2.gif',
                        'popup_onlyOpenIfSelected' => 1,
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                        ),
                    'add' => Array(
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'add.gif',
                        'params' => array(
                            'table'=>'tx_yag_domain_model_album',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                            ),
                        'script' => 'wizard_add.php',
                    ),
                ),
            ),
        ),
        'item_meta' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.item_meta',
            'config'    => array(
                'type' => 'select',
                'foreign_table' => 'tx_yag_domain_model_itemmeta',
                'minitems' => 0,
                'maxitems' => 1,
                'wizards' => array(
                    '_PADDING' => 1,
                    '_VERTICAL' => 0,
                    'edit' => array(
                        'type' => 'popup',
                        'title' => 'Edit',
                        'script' => 'wizard_edit.php',
                        'icon' => 'edit2.gif',
                        'popup_onlyOpenIfSelected' => 1,
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                        ),
                    'add' => Array(
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'add.gif',
                        'params' => array(
                            'table'=>'tx_yag_domain_model_itemmeta',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                            ),
                        'script' => 'wizard_add.php',
                    ),
                ),
            ),
        ),

		'album' => array(
            'config' => array(
                'type'  => 'passthrough',
            ),
        ),
        
        'tags' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.tags',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_yag_domain_model_tag',
				'MM' => 'tx_yag_item_tag_mm',
				'maxitems' => 99999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),

		'rating' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.rating',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'float'
			),
		),
    ),
);

//$TCA['tx_yag_domain_model_item']['ctrl']['hideTable'] = 1;
?>