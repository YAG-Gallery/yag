<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_resolutionfilecache',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => 0,
        'delete' => 'deleted',
        'enablecolumns' => array(),
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('yag') . 'Resources/Public/Icons/tx_yag_domain_model_resolutionfilecache.png'
    ),
    'hideTable' => 1,
    'interface' => array(
        'showRecordFieldList' => 'width,height,quality,path,item,paramhash',
    ),
    'types' => array(
        '1' => array('showitem' => 'width,height,quality,path,item,paramhash'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'paramhash' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_resolutionfilecache.paramhash',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'width' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_resolutionfilecache.width',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'height' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_resolutionfilecache.height',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ),
        ),
        'path' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_resolutionfilecache.path',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'item' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xlf:tx_yag_domain_model_resolutionfilecache.item',
            'config' => array(
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
                        'module' => array(
                        	'name' => 'wizard_edit'
                        )
                    ),
                    'add' => array(
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'add.gif',
                        'params' => array(
                            'table' => 'tx_yag_domain_model_item',
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
    ),
);

$TCA['tx_yag_domain_model_resolutionfilecache']['ctrl']['hideTable'] = 1;
