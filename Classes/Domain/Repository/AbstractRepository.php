<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
 *           Daniel Lienert <typo3@lienert.cc>
 *  All rights reserved
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

namespace DL\Yag\Domain\Repository;

use DL\Yag\Utility\PidDetector;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Abstract repository, updates pageCacheManager for automatic cache clearing
 *
 * @package    Domain
 * @subpackage Repository
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
class AbstractRepository extends Repository {
    /**
     * If set to true, pid detected by pid detector is used for storage
     *
     * Set this to FALSE in your repository to disable pid detector!
     *
     * @var bool
     */
    protected $respectPidDetector = true;


    /**
     * Holds instance of pid detector
     *
     * @var PidDetector
     */
    protected $pidDetector;


    /**
     * Injects pid detector
     *
     * @param PidDetector $pidDetector
     */
    public function injectPidDetector( PidDetector $pidDetector ) {
        $this->pidDetector = $pidDetector;
    }


    /**
     * Initialize repository
     *
     * (automatically called when using objectManager!)
     */
    public function initializeObject() {
        $this->initPidDetector();
    }


    /**
     * Initializes PID detector
     */
    protected function initPidDetector() {
        if ( $this->respectPidDetector ) {
            $PIDs = $this->pidDetector->getPids();

            if ( ! $PIDs ) {
                // throw new Exception('It was not possible to determine any page IDs to get records from. Please configure your plugin correctly.', 1331382978);
            }

            if ( $this->defaultQuerySettings === null ) {
                $this->defaultQuerySettings = $this->objectManager->get( 'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings' );
            }

            $this->defaultQuerySettings->setRespectStoragePage( true );
            $this->defaultQuerySettings->setStoragePageIds( $PIDs );
        }
    }


    /**
     * (non-PHPdoc)
     *
     * @see \TYPO3\CMS\Extbase\Persistence\Repository::add()
     *
     * @param object $object
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function add( $object ) {
        parent::add( $object );
        $this->objectManager->get( 'DL\\Yag\\PageCache\\PageCacheManager' )->markObjectUpdated( $object );
    }


    /**
     * (non-PHPdoc)
     * @see \TYPO3\CMS\Extbase\Persistence\Repository::remove()
     *
     * @param object $object
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function remove( $object ) {
        parent::remove( $object );
        $this->objectManager->get( 'DL\\Yag\\PageCache\\PageCacheManager' )->markObjectUpdated( $object );
    }


    /**
     * (non-PHPdoc)
     * @see \TYPO3\CMS\Extbase\Persistence\Repository::update()
     *
     * @param object $modifiedObject
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function update( $modifiedObject ) {
        parent::update( $modifiedObject );
        $this->objectManager->get( 'DL\\Yag\\PageCache\\PageCacheManager' )->markObjectUpdated( $modifiedObject );
    }


    /**
     * Build and return whereclause part with TYPO3 enablefields criterias
     * for all tables which are defined in backendConfig.tables and in TCA
     *
     * @param array $typo3Tables
     *
     * @return string whereclause part with TYPO3 enablefields criterias
     */
    protected function getTypo3SpecialFieldsWhereClause( array $typo3Tables ) {
        $specialFieldsWhereClause = '';

        foreach ( $typo3Tables as $typo3Table ) {
            if ( is_array( $GLOBALS['TCA'][ $typo3Table ] ) ) {
                $specialFieldsWhereClause .= \Tx_PtExtbase_Div::getCobj()->enableFields( $typo3Table );
            }
        }

        return $specialFieldsWhereClause;
    }
}
