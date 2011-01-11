<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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

/**
 * Class implements a factory for yag session persistence manager factory
 *
 * @package Domain
 * @subpackage StateAdapter
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_StateAdapter_SessionPersistenceManagerFactory {
    
    /**
     * Singleton instance of session persistence manager object
     *
     * @var Tx_Yag_Domain_StateAdapter_SessionPersistenceManager
     */
    private static $instance;
    
    
    
    /**
     * Factory method for session persistence manager 
     * 
     * @return Tx_Yag_Domain_StateAdapter_SessionPersistenceManager Singleton instance of session persistence manager 
     */
    public static function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new Tx_Yag_Domain_StateAdapter_SessionPersistenceManager();
            self::$instance->injectSessionAdapter(self::getStorageAdapter());
        }
        return self::$instance;
    }
    
    
    
    /**
     * Initialize the sessionAdapter
     *
     * @return tx_pttools_iStorageAdapter storageAdapter
     */
    private static function getStorageAdapter() {
        
       # if(Tx_PtExtlist_Utility_Extension::isInCachedMode()) {
       #     return Tx_PtExtlist_Domain_StateAdapter_Storage_DBStorageAdapterFactory::getInstance(); 
       # } else {
            $adapter = tx_pttools_sessionStorageAdapter::getInstance();
            return $adapter;
       # }
    }
}
 
?>