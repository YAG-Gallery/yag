<?php
namespace DL\Yag\Tests\Unit;
/*
 * This file is part of the FluidTYPO3/Development project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */
use TYPO3\CMS\Core\Configuration\ConfigurationManager;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\Container\Container;
use Composer\Autoload\ClassLoader;
/**
 * Class UnitTestsBootstrap
 */
class UnitTestsBootstrap {
    /**
     * Bootstraps the system for unit tests.
     *
     * @return void
     */
    public function bootstrapSystem() {
        $this->enableDisplayErrors()
             ->checkForCliDispatch()
             ->defineSitePath()
             ->setTypo3Context()
             ->createNecessaryDirectoriesInDocumentRoot()
             ->includeAndStartCoreBootstrap()
             ->initializeConfiguration()
             ->finishCoreBootstrap();
    }
    /**
     * Makes sure error messages during the tests get displayed no matter what is set in php.ini.
     *
     * @return UnitTestsBootstrap fluent interface
     */
    protected function enableDisplayErrors() {
        @ini_set('display_errors', 1);
        return $this;
    }
    /**
     * Checks whether the tests are run using the CLI dispatcher. If so, echos a helpful message and exits with
     * an error code 1.
     *
     * @return UnitTestsBootstrap fluent interface
     */
    protected function checkForCliDispatch() {
        if (!defined('TYPO3_MODE')) {
            return $this;
        }
        array_shift($_SERVER['argv']);
        $flatArguments = implode(' ', $_SERVER['argv']);
        echo 'Please run the unit tests using the following command:' . chr(10) .
             sprintf('typo3conf/ext/phpunit/Composer/vendor/bin/phpunit %s', $flatArguments) . chr(10) .
             chr(10);
        exit(1);
    }
    /**
     * Defines the PATH_site and PATH_thisScript constant and sets $_SERVER['SCRIPT_NAME'].
     *
     * @return UnitTestsBootstrap fluent interface
     */
    protected function defineSitePath() {
        /** @var string */
        define('PATH_site', $this->getWebRoot() . '.Build/Web/' );
        /** @var string */
        define('PATH_thisScript', PATH_site . 'typo3/cli_dispatch.phpsh');
        $_SERVER['SCRIPT_NAME'] = PATH_thisScript;
        return $this;
    }
    /**
     * Returns the absolute path the TYPO3 document root.
     *
     * @return string the TYPO3 document root using Unix path separators
     */
    protected function getWebRoot() {
        if (getenv('TYPO3_PATH_WEB')) {
            $webRoot = getenv('TYPO3_PATH_WEB') . '/';
        } else {
            $webRoot = getcwd() . '/';
        }
        return strtr($webRoot, '\\', '/');
    }
    /**
     * Defines TYPO3_MODE, TYPO3_cliMode and sets the environment variable TYPO3_CONTEXT.
     *
     * @return UnitTestsBootstrap fluent interface
     */
    protected function setTypo3Context() {
        /** @var string */
        define('TYPO3_MODE', 'BE');
        /** @var string */
        define('TYPO3_cliMode', TRUE);
        putenv('TYPO3_CONTEXT=Testing');
        return $this;
    }
    /**
     * Creates the following directories in the TYPO3 document root:
     * - typo3conf
     * - typo3conf/ext
     * - typo3temp
     * - uploads
     *
     * @return UnitTestsBootstrap fluent interface
     */
    protected function createNecessaryDirectoriesInDocumentRoot() {
        $this->createDirectory(PATH_site . 'uploads');
        $this->createDirectory(PATH_site . 'typo3temp');
        $this->createDirectory(PATH_site . 'typo3conf/ext');
        return $this;
    }
    /**
     * Creates the directory $directory (recursively if required).
     *
     * If $directory already exists, this method is a no-op.
     *
     * @param  string $directory absolute path of the directory to be created
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    protected function createDirectory($directory) {
        if (is_dir($directory)) {
            return;
        }
        if (!mkdir($directory, 0777, TRUE)) {
            throw new \RuntimeException('Directory "' . $directory . '" could not be created', 1423043755);
        }
    }
    /**
     * Includes the Core Bootstrap class and calls its first few functions.
     *
     * @return UnitTestsBootstrap fluent interface
     */
    protected function includeAndStartCoreBootstrap() {
        $classLoaderFilepath = __DIR__ . '/../../vendor/autoload.php';
        if (!file_exists($classLoaderFilepath)) {
            die('ClassLoader can\'t be loaded. Please check your path or set an environment variable \'TYPO3_PATH_WEB\' to your root path.');
        }
        $classLoader = require $classLoaderFilepath;
        Bootstrap::getInstance()
                 ->initializeClassLoader($classLoader)
                 //->setRequestType(TYPO3_REQUESTTYPE_BE | TYPO3_REQUESTTYPE_CLI)
                 ->baseSetup();
        return $this;

    }
    /**
     * Provides the default configuration in $GLOBALS['TYPO3_CONF_VARS'].
     *
     * @return UnitTestsBootstrap fluent interface
     */
    protected function initializeConfiguration() {
        $configurationManager = new ConfigurationManager();
        $GLOBALS['TYPO3_CONF_VARS'] = $configurationManager->getDefaultConfiguration();
        // avoid failing tests that rely on HTTP_HOST retrieval
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern'] = '.*';
        return $this;
    }
    /**
     * Finishes the last steps of the Core Bootstrap.
     *
     * @return UnitTestsBootstrap fluent interface
     */
    protected function finishCoreBootstrap() {
        Bootstrap::getInstance()
                 ->disableCoreCache()
                 ->initializeCachingFramework()
                 ->initializePackageManagement(\TYPO3\CMS\Core\Package\UnitTestPackageManager::class)
                 ->ensureClassLoadingInformationExists();
        return $this;
    }
}
