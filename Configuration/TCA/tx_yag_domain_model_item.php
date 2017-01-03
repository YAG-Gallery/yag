<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => 2,
        'versioning_followPages' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l18n_parent',
        'transOrigDiffSourceField' => 'l18n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'fe_group' => 'fe_group'
        ),
        'dividers2tabs' => true,
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('yag') . 'Resources/Public/Icons/tx_yag_domain_model_item.png'
    ),
    'interface' => array(
        'showRecordFieldList' => 'title,filename,description,href,hrefTarget,date,sourceuri,filehash,item_type,width,height,filesize,fe_user_uid,fe_group_uid,sorting,album,item_meta,fe_group',
    ),
    'types' => array(
        '1' => array('showitem' =>
            '--div--;Metadata,
			title,description,link,date,
			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
			hidden,fe_group'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
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
                    array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0)
                ),
            )
        ),
        'fe_group' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.php:LGL.fe_group',
            'config' => array(
                'type' => 'select',
                'size' => 5,
                'maxitems' => 20,
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.php:LGL.hide_at_login', -1),
                    array('LLL:EXT:lang/locallang_general.php:LGL.any_login', -2),
                    array('LLL:EXT:lang/locallang_general.php:LGL.usergroups', '--div--')
                ),
                'exclusiveKeys' => '-1,-2',
                'foreign_table' => 'fe_groups'
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
                'foreign_table' => 'tx_yag_domain_model_item',
                'foreign_table_where' => 'AND tx_yag_domain_model_item.uid=###REC_FIELD_l18n_parent### AND tx_yag_domain_model_item.sys_language_uid IN (-1,0)',
            )
        ),
        'l18n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            )
        ),
        't3ver_label' => array(
            'displayCond' => 'FIELD:t3ver_label:REQ:true',
            'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
            'config' => array(
                'type' => 'none',
                'cols' => 27,
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
            )
        ),
        'title' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),

        'href' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.href',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),

        'href_target' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.href_target',
            'config' => array(
                'type' => 'select',
                'minitems' => 0,
                'maxitems' => 1,
            ),
        ),

        'filename' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.filename',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'original_filename' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.original_filename',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'description' => array(
            'exclude' => 0,
            'l10n_mode' => 'noCopy',
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album.description',
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
                        'module' => array(
                        	'name' => 'wizard_rte'
                        )
                    ),
                ),
            )
        ),
        'date' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.date',
            'config' => array(
                'type' => 'input',
                'size' => 12,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'sourceuri' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.sourceuri',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'filehash' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.filehash',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'item_type' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.item_type',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'width' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.width',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'height' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.height',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'link' => array(
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.link',
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
                        'module' => array(
                        	'name' => 'wizard_link'
                        )
                    ),
                ),
                'softref' => 'typolink',
            ),
        ),
        'filesize' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.filesize',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'fe_user_uid' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.fe_user_uid',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'fe_group_uid' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.fe_group_uid',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'sorting' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.sorting',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim'
            )
        ),
        'album' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.album',
            'config' => array(
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
                        'module' => array(
                        	'name' => 'wizard_edit'
                        )
                    ),
                    'add' => array(
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'add.gif',
                        'params' => array(
                            'table' => 'tx_yag_domain_model_album',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ),
                        'script' => 'wizard_add.php',
                        'module' => array(
                        	'name' => 'wizard_add'
                        )
                    ),
                ),
            ),
        ),
        'item_meta' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.item_meta',
            'config' => array(
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
                        'module' => array(
                        	'name' => 'wizard_edit'
                        )
                    ),
                    'add' => array(
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'add.gif',
                        'params' => array(
                            'table' => 'tx_yag_domain_model_itemmeta',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ),
                        'script' => 'wizard_add.php',
                        'module' => array(
                        	'name' => 'wizard_add'
                        )
                    ),
                ),
            ),
        ),

        'tags' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.tags',
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

        'crdate' => array(
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'crdate',
            'config' => array(
                'type' => 'input',
                'size' => 8,
                'max' => 20,
                'eval' => 'date',
                'default' => 0,
            )
        ),

        'tstamp' => array(
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'crdate',
            'config' => array(
                'type' => 'input',
                'size' => 8,
                'max' => 20,
                'eval' => 'date',
                'default' => 0,
            )
        ),


        'rating' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.rating',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'float'
            ),
        ),
    ),
);
