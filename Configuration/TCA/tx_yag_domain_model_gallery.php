<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_gallery',
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
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('yag') . 'Resources/Public/Icons/tx_yag_domain_model_gallery.png'
    ),
    'interface' => array(
        'showRecordFieldList' => 'name,description,date,fe_user_uid,fe_group_uid,albums,thumb_album,sorting,hidden,fe_group',
    ),
    'types' => array(
        '1' => array('showitem' =>
            '--div--;Metadata,
			name,description,date,thumb_album,
			--div--;Albums,
			albums,
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
                'foreign_table' => 'tx_yag_domain_model_gallery',
                'foreign_table_where' => 'AND tx_yag_domain_model_gallery.uid=###REC_FIELD_l18n_parent### AND tx_yag_domain_model_gallery.sys_language_uid IN (-1,0)',
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
        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_gallery.name',
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
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_gallery.date',
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
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_gallery.fe_user_uid',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'sorting' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_gallery.sorting',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'fe_group_uid' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_gallery.fe_group_uid',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'albums' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_gallery.albums',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_yag_domain_model_album',
                'foreign_field' => 'gallery',
                'foreign_sortby' => 'sorting',
                'minitems' => 0,
                'maxitems' => 9999,
                'appearance' => array(
                    'collapse' => 0,
                    'levelLinksPosition' => 'bottom',
                    'showSynchronizationLink' => 0,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'showPossibleRecordsSelector' => 1,
                    'enabledControls' => array('new' => false, 'delete' => false, 'hide' => false)
                ),
            )
        ),
        'thumb_album' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_item.thumb_album',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_yag_domain_model_album',
                'foreign_field' => 'uid',
                'minitems' => 1,
                'maxitems' => 1,
                'appearance' => array(
                    'collapse' => 0,
                    'levelLinksPosition' => 'bottom',
                    'showSynchronizationLink' => 0,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'showPossibleRecordsSelector' => 1,
                    'enabledControls' => array('new' => false, 'delete' => false, 'hide' => false)
                ),
                'behaviour' => array(
                    'localizationMode' => 'select',
                    'localizeChildrenAtParentLocalization' => true
                )
            ),
        ),
        'rating' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_gallery.rating',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'float'
            ),
        ),
    ),
);
