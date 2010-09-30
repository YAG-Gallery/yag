<?php
// This class contains information about classes to be registered in autoload for testing

$extensionTestsPath = t3lib_extMgm::extPath('yag') . 'Tests/';
$extbasePath = t3lib_extMgm::extPath('extbase');
return array(
    'tx_yag_tests_mocks_configurationmocks' => $extensionTestsPath . 'Mocks/ConfigurationMocks.php',
    'tx_yag_tests_mocks_gallerycontrollermock' => $extensionTestsPath . 'Mocks/GalleryControllerMock.php',
    'tx_yag_tests_mocks_galleryrepositorymock' => $extensionTestsPath . 'Mocks/GalleryRepositoryMock.php'
);
?>