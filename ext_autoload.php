<?php
// This class contains information about classes to be registered in autoload for testing

$extensionTestsPath = t3lib_extMgm::extPath('yag') . 'Tests/';
$extbasePath = t3lib_extMgm::extPath('extbase');
return array(
    'tx_extbase_basetestcase' => $extbasePath . 'Tests/BaseTestCase.php', 
    'tx_yag_tests_basetestcase' => $extensionTestsPath . 'BaseTestCase.php',
    'tx_yag_tests_defaulttsconfig' => $extensionTestsPath . 'DefaultTsConfig.php',
    
    'user_Tx_Yag_Utility_FlexformDataProvider' => t3lib_extMgm::extPath('yag').'Classes/Utility/FlexformDataProvider.php',
);
?>