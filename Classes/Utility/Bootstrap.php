<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Daniel Lienert <lienert@punkt.de>
 *  All rights reserved
 *
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

namespace DL\Yag\Utility;

use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\Context\YagContextFactory;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Bootstrap implements SingletonInterface {
    /**
     * @var string
     */
    protected $theme = 'default';


    /**
     * @var string
     */
    protected $contextIdentifier = 'extUsage';


    /**
     * @return void
     */
    public function boot() {
        $this->initConfigurationBuilder();
    }


    /**
     * @return void
     */
    protected function initConfigurationBuilder() {
        $yagSettings   = \Tx_PtExtbase_Div::typoscriptRegistry( 'plugin.tx_yag.settings.' );
        $yagEBSettings = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Service\\TypoScriptService' )->convertTypoScriptArrayToPlainArray( $yagSettings );

        ConfigurationBuilderFactory::injectSettings( $yagEBSettings );
        ConfigurationBuilderFactory::getInstance( $this->contextIdentifier, $this->theme );
        YagContextFactory::createInstance( $this->contextIdentifier );
    }


    /**
     * @param $theme
     *
     * @return Bootstrap
     */
    public function setTheme( $theme ) {
        $this->theme = $theme;

        return $this;
    }


    /**
     * @param $contextIdentifier
     *
     * @return Bootstrap
     */
    public function setContextIdentifier( $contextIdentifier ) {
        $this->contextIdentifier = $contextIdentifier;

        return $this;
    }
}
