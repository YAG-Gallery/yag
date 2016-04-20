<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

/**
 * Register Frontend Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Pi1',
    'YAG - Yet Another Gallery'
);

/**
 * Register Backend Module
 */
if (TYPO3_MODE === 'BE') {

    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'DL.' . $_EXTKEY,
        'web', // Make module a submodule of 'web'
        'tx_yag_m1', // Submodule key
        '', // Position
        array( // An array holding the controller-action-combinations that are accessible
            'Gallery' => 'list, index, show, new, create, edit, update, delete',
            'Album' => 'show, new, create, edit, update, delete, addItems, updateSorting, bulkUpdate',
            'FileUpload' => 'upload',
            'Item' => 'index, show, new, create, edit, update, delete, bulkUpdate',
            'ItemList' => 'list,submitFilter',
            'ItemFile' => 'index, show, new, create, edit, update, delete',
            'DirectoryImport' => 'showImportForm, importFromDirectory',
            'ZipImport' => 'showImportForm, importFromZip, createNewAlbumAndImportFromZip',
            'Remote' => 'addItemToAlbum, albumList, galleryList',
            'Ajax' => 'updateItemSorting,updateGallerySorting,directoryAutoComplete,deleteItem,deleteGallery,deleteAlbum,updateItemTitle,setItemAsAlbumThumb,
				updateItemDescription,updateAlbumSorting,updateAlbumTitle,updateAlbumDescription,updateGenericProperty,
				setAlbumAsGalleryThumb,hideAlbum,unhideAlbum,hideGallery,unhideGallery,getSubDirs',
            'AdminMenu' => 'index',

            // This is additional for backend! Keep in mind, when copy&pasting from ext_localconf
            'Backend' => 'settingsNotAvailable,extConfSettingsNotAvailable,noGalleryIsPosibleOnPIDZero,maintenanceOverview,clearAllPageCache,doDbUpdate,markPageAsYagSysFolder',
            'ResolutionFileCache' => 'clearResolutionFileCache,buildResolutionByConfiguration,buildAllItemResolutions',
        ),
        array(
            'access' => 'user,group',
            'icon' => 'EXT:yag/ext_icon.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
        )
    );

    $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['DL\\Yag\\Utility\\WizzardIcon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Utility/WizzardIcon.php';

    // Register status report checks in backend
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['YAG'] = array(
        'DL\\Yag\\Report\\ExternalLibraries',
        'DL\\Yag\\Report\\Filesystem',
        'DL\\Yag\\Report\\EnvironmentVariables'
    );


    // Add Backend TypoScript
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'setup', '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Backend/setup.txt">');
}


/**
 * Register Plugin as Page Content
 */
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key,pages';


/**
 * Register static Typoscript Template
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', '[yag] Yet Another Gallery');


/**
 * Register flexform
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Flexform.xml');
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';


/**
 * TCA Configuration
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_album', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_album.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_album');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_gallery', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_gallery.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_gallery');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_item', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_item.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_item');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_resolutionfilecache', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_resolutionfilecache.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_resolutionfilecache');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_itemmeta', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_itemmeta.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_itemmeta');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yag_domain_model_tag', 'EXT:yag/Resources/Private/Language/locallang_csh_tx_yag_domain_model_tag.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yag_domain_model_tag');

// Register yag for 'contains plugin' in sysfolders
$TCA['pages']['columns']['module']['config']['items'][] = array('LLL:EXT:yag/Resources/Private/Language/locallang.xlf:tx_yag_general.yag', 'yag', 'i/ext_icon.png');
\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('pages', 'contains-yag', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('yag') . 'ext_icon.gif');
