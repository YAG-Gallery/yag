<?php
// This class contains information about classes to be registered in autoload for testing

$extensionTestsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('yag') . 'Tests/';
$extbasePath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('extbase');
return array(
    'tx_extbase_basetestcase' => $extbasePath . 'Tests/Unit/BaseTestCase.php',
    'tx_yag_tests_basetestcase' => $extensionTestsPath . 'BaseTestCase.php',
    'tx_yag_tests_defaulttsconfig' => $extensionTestsPath . 'DefaultTsConfig.php',
    
    'user_tx_yag_utility_flexformdataprovider' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('yag').'Classes/Utility/FlexformDataProvider.php',
	'user_tx_yag_utility_flexform_typoscriptdataprovider' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('yag').'Classes/Utility/TyposcriptDataProvider.php',
    'user_tx_yag_hooks_realurl' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('yag').'Classes/Hooks/RealUrlHook.php',
	
    'tx_yag_report_externallibraries' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('yag').'Classes/Report/ExternalLibraries.php',
    'tx_yag_report_environmentvariables' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('yag').'Classes/Report/EnvironmentVariables.php',
    'tx_yag_report_filesystem' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('yag').'Classes/Report/Filesystem.php',
);
?>