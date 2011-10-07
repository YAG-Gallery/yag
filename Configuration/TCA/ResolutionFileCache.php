<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

$TCA['tx_yag_domain_model_resolutionfilecache'] = array(
    'ctrl' => $TCA['tx_yag_domain_model_resolutionfilecache']['ctrl'],
	'hideTable' => 1,
    'interface' => array(
        'showRecordFieldList'   => 'width,height,quality,path,item,paramhash',
    ),
    'types' => array(
        '1' => array('showitem' => 'width,height,quality,path,item,paramhash'),
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
                'foreign_table' => 'tx_yag_domain_model_resolutionfilecache',
                'foreign_table_where' => 'AND tx_yag_domain_model_resolutionfilecache.uid=###REC_FIELD_l18n_parent### AND tx_yag_domain_model_resolutionfilecache.sys_language_uid IN (-1,0)',
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
        'paramhash' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolutionfilecache.paramhash',
            'config'    => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'width' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolutionfilecache.width',
            'config'    => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'height' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolutionfilecache.height',
            'config'    => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'path' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolutionfilecache.path',
            'config'    => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'item' => array(
            'exclude'   => 0,
            'label'     => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_resolutionfilecache.item',
            'config'    => array(
                'type' => 'select',
                'foreign_table' => 'tx_yag_domain_model_item',
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
                            'table'=>'tx_yag_domain_model_item',
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

$TCA['tx_yag_domain_model_resolutionfilecache']['ctrl']['hideTable'] = 1;
?>