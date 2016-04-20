<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>, Daniel Lienert <typo3@lienert.cc>
*            
*           
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Configuration file for YAG gallery
 *
 * @author Daniel Lienert <typo3@lienert.cc>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

/*
 * Main plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    $_EXTKEY,
    'Pi1',
    array(
          'Album' => 'show,showSingle,list,                      			new,delete,edit,addItems,create,update',
          'Gallery' => 'list, showSingle, index,                 			new,create,edit,update,delete',
          'Item' => 'index, show, showSingle, showRandomSingle, download,  	delete',
          'ItemList' => 'list,show,submitFilter,resetFilter,uncachedList,downloadAsZip',
          'FileUpload' => 'upload',
          'Error' => 'index',
    ),
    array(
        'Gallery' => 'new,create,edit,update,delete',
        'Album' => 'new,delete,edit,addItems,create,update',
        'Item' => 'delete, download',
        'ItemList' => 'unCachedList,downloadAsZip',
        'FileUpload' => 'upload',
    )
);



if (TYPO3_MODE == 'BE') {
    $yagExtConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag']);

    // Hooks
    $TYPO3_CONF_VARS['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['yag_pi1']['yag'] = 'EXT:yag/Classes/Hooks/CMSLayoutHook.php:DL\\Yag\\Hooks\\CMSLayoutHook->getExtensionSummary';

    // Clear resFileCache with clearCacheCommand
    if ((int) $yagExtConfig['clearResFileCacheWithCacheClearCommand'] === 1) {
        $TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearAllCache_additionalTables']['tx_yag_domain_model_resolutionfilecache'] = 'tx_yag_domain_model_resolutionfilecache';
    }

    $yagGalleryRecordSelectorClass = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('yag') . 'Classes/Utility/Flexform/RecordSelector.php:DL\\Yag\\Utility\\Flexform\\RecordSelector';


    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
        'txyagM1::getGalleryList', $yagGalleryRecordSelectorClass . '->getGallerySelectList', false
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
        'txyagM1::getAlbumList', $yagGalleryRecordSelectorClass . '->getAlbumSelectList', false
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
        'txyagM1::getImageList', $yagGalleryRecordSelectorClass . '->getImageSelectList', false
    );


    /*
     * Scheduler Tasks
     */

    // Importer
/*	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['DL\\Yag\\Scheduler\\Importer\\DirectoryImporterTask'] = array(
        'extension' => $_EXTKEY,
        'title' => 'YAG Importer',
        'description' => 'Imports images from a directory structure',
        'additionalFields' => 'DL\\Yag\\Scheduler\\Importer\\DirectoryImporterTaskAdditionalFields'
    );
*/
    // Cache Warming
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['YAG\\Yag\\Scheduler\\Cache\\CacheWarmingTask'] = array(
        'extension' => $_EXTKEY,
        'title' => 'YAG Cache Warming',
        'description' => 'Warm up the YAG Image Cache',
        'additionalFields' => 'YAG\\Yag\\Scheduler\\Cache\\CacheWarmingTaskAdditionalFieldProvider'
    );
}


/*
$TYPO3_CONF_VARS['SYS']['fal']['registeredDrivers']['Yag'] = array(
        'class' => 'TYPO3\\CMS\\Yag\\Fal\\Driver\\YagDriver',
        'label' => 'Galerie',
        'flexFormDS' => 'EXT:yag/Configuration/FlexForms/YagDriverFlexForm.xml'
);
*/
