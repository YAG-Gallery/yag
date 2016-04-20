<?php
/***************************************************************
 * Copyright notice
 *
 *   2010 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
 * All rights reserved
 *
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace DL\Yag\Utility\Flexform;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Provides some abstract methods
 *
 * @package Utility
 * @author  Daniel Lienert <typo3@lienert.cc>
 */
class AbstractFlexformUtility {
    const EXTENSION_NAME = 'Yag';
    const PLUGIN_NAME = 'web_YagTxYagM1';
    const CONTROLLER_NAME = 'Backend'; // Controller must be set to suppress warnings


    /**
     * Extbase Object Manager
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;


    /**
     * @var int current pid
     */
    protected $currentPid;


    public function __construct() {
        $this->checkBackendAccessRights();
    }


    /**
     * Check if the current backend user has access to this module
     */
    protected function checkBackendAccessRights() {
        $backendUser = $GLOBALS['BE_USER'];
        /** @var \TYPO3\CMS\Core\Authentication\BackendUserAuthentication $backendUser */
        $backendUser->modAccess( array( 'name' => 'web_YagTxYagM1', 'access' => 'user, group' ), true );
    }


    /**
     * set the current pid from config array
     *
     * @param null $pid
     *
     * @return int|null
     */
    protected function determineCurrentPID( $pid = null ) {
        $pid = (int) GeneralUtility::_GP( 'id' );

        if ( $pid <= 0 ) {
            $pid = (int) GeneralUtility::_GP( 'PID' );
        }

        if ( $pid <= 0 && (int) $pid > 0 ) {
            $pid = (int) $pid;
        }

        if ( $pid <= 0 ) {
            // UUUUhh, i hope we never come so far :)
            $returnUrlArray = explode( 'id=', GeneralUtility::_GP( 'returnUrl' ) );
            $pid            = (int) array_pop( $returnUrlArray );
        }

        if ( $pid <= 0 ) {
            $pid = 1;
        }

        $this->currentPid = $pid;

        return $pid;
    }


    /**
     * Build A Fluid Renderer
     * @return \TYPO3\CMS\Fluid\View\TemplateView
     */
    protected function getFluidRenderer() {

        /* @var $request \TYPO3\CMS\Extbase\Mvc\Request */
        $request = $this->objectManager->get( 'TYPO3\\CMS\\Extbase\\Mvc\\Request' );
        $request->setControllerExtensionName( self::EXTENSION_NAME );
        $request->setPluginName( self::PLUGIN_NAME );
        $request->setControllerName( self::CONTROLLER_NAME );

        $fluidRenderer     = $this->objectManager->get( 'TYPO3\\CMS\\Fluid\\View\\TemplateView' );
        $controllerContext = $this->objectManager->get( 'TYPO3\\CMS\\Extbase\\Mvc\\Controller\\ControllerContext' );
        $controllerContext->setRequest( $request );
        $fluidRenderer->setControllerContext( $controllerContext );

        $fluidRenderer->assign( 'pid', $this->currentPid );

        return $fluidRenderer;
    }
}
