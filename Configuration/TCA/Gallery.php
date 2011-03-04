<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

$TCA['tx_yag_domain_model_gallery'] = array(
    'ctrl' => $TCA['tx_yag_domain_model_gallery']['ctrl'],
    'interface' => array(
        'showRecordFieldList'   => 'name,description,date,fe_user_uid,fe_group_uid,albums,thumb_album,sorting',
    ),
    'types' => array(
        '1' => array('showitem' => 'name,description,date,fe_user_uid,fe_group_uid,albums,thumb_album,sorting'),
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
        'l18n_parent' => array(
            'displayCond'   => 'FIELD:sys_language_uid:>:0',
            'exclude'       => 1,
            'label'         => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
            'config'        => array(
                'type'          => 'select',
                'items'         => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_yag_domain_model_gallery',
                'foreign_table_where' => 'AND tx_yag_domain_model_gallery.uid=###REC_FIELD_l18n_parent### AND tx_yag_domain_model_gallery.sys_language_uid IN (-1,0)',
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
        'name' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.name',
            'config'    => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'description' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.description',
            'config'    => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ),
        ),
        'date' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.date',
            'config'    => array(
                'type' => 'input',
                'size' => 12,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'fe_user_uid' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.fe_user_uid',
            'config'    => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'sorting' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.sorting',
            'config'    => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'fe_group_uid' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.fe_group_uid',
            'config'    => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'albums' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.albums',
            'config'    => array(
                'type' => 'select',
                'foreign_table' => 'tx_yag_domain_model_album',
                'foreign_sortby' => 'sorting',
                'MM' => 'tx_yag_gallery_album_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'wizards' => array(
                    '_PADDING' => 1,
                    '_VERTICAL' => 1,
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
        'thumb_album' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_item.thumb_album',
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
    ),
);
?>