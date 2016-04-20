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

namespace DL\Yag\Utility;

use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package Utility
 * @author  Daniel Lienert
 */
class DBUpgrade implements SingletonInterface {
    /**
     * @var integer
     */
    protected $currentAppVersion = 0;

    /**
     * @var integer
     */
    protected $currentDatabaseVersion = 0;


    /**
     * @throws Exception
     */
    public function initializeObject() {
        $this->currentAppVersion = ExtensionManagementUtility::getExtensionVersion( 'yag' );
        $this->determineDatabaseVersion();
    }


    /**
     * @return string
     */
    public function getAvailableUpdateMethod() {
        $majorAppVersion = substr( $this->currentAppVersion, 0, 1 );
        $majorDbVersion  = substr( $this->currentDatabaseVersion, 0, 1 );

        $updateMethodName = sprintf( 'update%sTo%s', $majorDbVersion, $majorAppVersion );

        if ( method_exists( $this, $updateMethodName ) === true ) {
            return $updateMethodName;
        } else {
            return '';
        }
    }


    /**
     * @param $arguments
     *
     * @return array
     */
    public function doUpdate( $arguments ) {
        $updateMethodName = $this->getAvailableUpdateMethod();
        if ( $updateMethodName != '' ) {
            $result = $this->$updateMethodName( $arguments );
        } else {
            $result = array( 'Update method ' . $updateMethodName . ' no found!' );
        }

        $this->determineDatabaseVersion();

        return $result;
    }


    /**
     * Update v1 -> v2
     * - Set pid of all records to target pid
     *
     * @param $arguments
     *
     * @return array|bool
     */
    public function update1To2( $arguments ) {
        $targetPid = (int) $arguments['targetPid'];
        if ( $targetPid == 0 ) {
            return array( 'targetPid has to be a positive value.' );
        }

        $tablesToModify = array(
            'tx_yag_domain_model_album',
            'tx_yag_domain_model_gallery',
            'tx_yag_domain_model_item',
            'tx_yag_domain_model_itemmeta',
            'tx_yag_domain_model_resolutionfilecache',
            'tx_yag_domain_model_tag',
        );

        foreach ( $tablesToModify as $tableName ) {
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $tableName, 'pid = 0', array( 'pid' => $targetPid ) );
        }

        GeneralUtility::makeInstance( 'TYPO3\\CMS\\Core\\Registry' )->set( 'tx_yag', 'dbVersion', '2.0' );

        return true;
    }


    /**
     * Update v1 -> v3
     * - Set pid of all records to target pid
     *
     * @param $arguments
     *
     * @return array|bool
     */
    public function update1To3( $arguments ) {
        $this->update1To2( $arguments );

        GeneralUtility::makeInstance( 'TYPO3\\CMS\\Core\\Registry' )->set( 'tx_yag', 'dbVersion', '3.0' );

        return true;
    }


    /**
     * Determine current database version
     */
    protected function determineDatabaseVersion() {
        $dbVersionFromRegistry = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Core\\Registry' )->get( 'tx_yag', 'dbVersion', '0' );

        if ( $dbVersionFromRegistry !== '0' ) {
            $this->currentDatabaseVersion = $dbVersionFromRegistry;
        } elseif ( $this->checkIfDatabaseIsEmpty() === true ) {
            $this->currentDatabaseVersion = $this->currentAppVersion;
        } elseif ( $this->countPidZeroRecords() > 0 ) {
            $this->currentDatabaseVersion = '1.5.0';
        } else {
            $this->currentDatabaseVersion = $this->currentAppVersion;
        }
    }


    /**
     * @return mixed
     */
    public function countPidZeroRecords() {
        $pidZeroRowCount = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows( '*', 'tx_yag_domain_model_gallery', 'pid = 0' );

        return $pidZeroRowCount;
    }


    /**
     * @return bool
     */
    protected function checkIfDatabaseIsEmpty() {
        $rowCount = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows( '*', 'tx_yag_domain_model_gallery' );

        return $rowCount > 0 ? false : true;
    }

    /**
     * @return string
     */
    public function getCurrentAppVersion() {
        return $this->currentAppVersion;
    }

    /**
     * @return string
     */
    public function getCurrentDatabaseVersion() {
        return $this->currentDatabaseVersion;
    }
}
