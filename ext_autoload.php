<?php
// This class contains information about classes to be registered in autoload for testing

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$extensionTestsPath = ExtensionManagementUtility::extPath('yag') . 'Tests/';
$extbasePath = ExtensionManagementUtility::extPath('extbase');

return array(
    'tx_extbase_basetestcase' =>        $extbasePath . 'Tests/Unit/BaseTestCase.php',
    'tx_yag_tests_basetestcase' =>        $extensionTestsPath . 'Unit/BaseTestCase.php',
    'tx_yag_tests_defaulttsconfig' =>    $extensionTestsPath . 'Unit/DefaultTsConfig.php',

    'user_tx_yag_utility_flexformdataprovider' => ExtensionManagementUtility::extPath('yag') . 'Classes/Utility/FlexformDataProvider.php',
    'user_tx_yag_utility_flexform_typoscriptdataprovider' => ExtensionManagementUtility::extPath('yag') . 'Classes/Utility/TyposcriptDataProvider.php',
    'user_tx_yag_hooks_realurl' => ExtensionManagementUtility::extPath('yag') . 'Classes/Hooks/RealUrlHook.php',

    'tx_yag_report_externallibraries' => ExtensionManagementUtility::extPath('yag') . 'Classes/Report/ExternalLibraries.php',
    'tx_yag_report_environmentvariables' => ExtensionManagementUtility::extPath('yag') . 'Classes/Report/EnvironmentVariables.php',
    'tx_yag_report_filesystem' => ExtensionManagementUtility::extPath('yag') . 'Classes/Report/Filesystem.php',
);
