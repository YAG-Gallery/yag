<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album',
        'label' => 'name',
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
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('yag') . 'Resources/Public/Icons/tx_yag_domain_model_album.png'
    ),
    'interface' => array(
        'showRecordFieldList' => 'name,description,date,fe_user_uid,fe_group_uid,gallery,thumb,items,hidden,sorting,fe_group',
    ),
    'types' => array(
        '1' => array('showitem' =>
            '--div--;Metadata,
			name,description,date,thumb,
			--div--;Items,
			items,
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
                'foreign_table' => 'tx_yag_domain_model_album',
                'foreign_table_where' => 'AND tx_yag_domain_model_album.uid=###REC_FIELD_l18n_parent### AND tx_yag_domain_model_album.sys_language_uid IN (-1,0)',
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
        'sorting' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album.sorting',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album.name',
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
                        'module' => array(
                            'name' => 'wizard_rte'
                        ),
                        'script' => 'wizard_rte.php',
                    ),
                ),
            )
        ),
        'date' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album.date',
            'config' => array(
                'type' => 'input',
                'size' => 12,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'fe_user_uid' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album.fe_user_uid',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'fe_group_uid' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album.fe_group_uid',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'gallery' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album.gallery',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'tx_yag_domain_model_gallery',
                'minitems' => 0,
                'maxitems' => 1,
                'wizards' => array(
                    '_PADDING' => 1,
                    '_VERTICAL' => 0,
                    'edit' => array(
                        'type' => 'popup',
                        'title' => 'Edit',
                        'script' => 'wizard_edit.php',
                        'module' => array(
                            'name' => 'wizard_edit'
                        ),
                        'icon' => 'edit2.gif',
                        'popup_onlyOpenIfSelected' => 1,
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                    ),
                    'add' => array(
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'add.gif',
                        'params' => array(
                            'table' => 'tx_yag_domain_model_gallery',
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
        'thumb' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album.thumb',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_yag_domain_model_item',
                'foreign_selector' => 'album',
                'minitems' => 1,
                'maxitems' => 1,
                'appearance' => array(
                    'collapse' => 0,
                    'levelLinksPosition' => 'bottom',
                    'showSynchronizationLink' => 0,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'showPossibleRecordsSelector' => false,
                    'enabledControls' => array('new' => false, 'delete' => false, 'hide' => false)
                ),
                'behaviour' => array(
                    'localizationMode' => 'select',
                    'localizeChildrenAtParentLocalization' => true
                )
            ),
        ),
        'items' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album.items',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_yag_domain_model_item',
                'foreign_field' => 'album',
                'minitems' => 0,
                'maxitems' => 9999,
                'appearance' => array(
                    'collapse' => 0,
                    'levelLinksPosition' => 'bottom',
                    'showSynchronizationLink' => false,
                    'showPossibleLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showPossibleRecordsSelector' => false,
                    'enabledControls' => array('new' => false, 'delete' => false, 'hide' => false)
                ),
            )
        ),
        'rating' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_album.rating',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'float'
            ),
        ),
    ),
);
