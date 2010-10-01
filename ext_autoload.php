<?php
// This class contains information about classes to be registered in autoload for testing

$extensionTestsPath = t3lib_extMgm::extPath('yag') . 'Tests/';
$extbasePath = t3lib_extMgm::extPath('extbase');
return array(
    'Tx_extbase_basetestcase' => $extbasePath . 'Tests/BaseTestCase.php', 
    'tx_yag_tests_basetestcase' => $extensionTestsPath . 'BaseTestCase.php'
);
?>