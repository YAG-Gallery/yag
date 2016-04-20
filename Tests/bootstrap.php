<?php
// Register composer autoloader
use DL\Yag\Tests\Unit\UnitTestsBootstrap;

if (!file_exists( __DIR__ . '/../vendor/autoload.php')) {
	throw new \RuntimeException(
		'Could not find vendor/autoload.php, make sure you ran composer.'
	);
}
/** @var Composer\Autoload\ClassLoader $autoloader */
$autoloader = require __DIR__ . '/../vendor/autoload.php';
//$autoloader->addPsr4('DL\\Yag\\Flux\\Tests\\Fixtures\\', __DIR__ . '/Fixtures/');
$autoloader->addPsr4('DL\\Yag\\Tests\\Unit\\', __DIR__ . '/Unit/');
$autoloader->addPsr4('TYPO3\\CMS\\Core\\', __DIR__ . '/../vendor/typo3/cms/typo3/sysext/core/Classes/');
$autoloader->addPsr4('TYPO3\\CMS\\Core\\Tests\\', __DIR__ . '/../vendor/typo3/cms/typo3/sysext/core/Tests/');
$autoloader->addPsr4('TYPO3\\CMS\\Extbase\\', __DIR__ . '/../vendor/typo3/cms/typo3/sysext/extbase/Classes/');
$autoloader->addPsr4('TYPO3\\CMS\\Fluid\\', __DIR__ . '/../vendor/typo3/cms/typo3/sysext/fluid/Classes/');
$autoloader->addPsr4('TYPO3\\CMS\\Backend\\', __DIR__ . '/../vendor/typo3/cms/typo3/sysext/backend/Classes/');
$autoloader->addPsr4('TYPO3\\CMS\\Recordlist\\', __DIR__ . '/../vendor/typo3/cms/typo3/sysext/recordlist/Classes/');
$autoloader->addPsr4('TYPO3\\CMS\\Frontend\\', __DIR__ . '/../vendor/typo3/cms/typo3/sysext/frontend/Classes/');
$autoloader->addPsr4('TYPO3\\CMS\\Lang\\', __DIR__ . '/../vendor/typo3/cms/typo3/sysext/lang/Classes/');

$bootstrap = new UnitTestsBootstrap();
$bootstrap->bootstrapSystem();
unset($bootstrap);
