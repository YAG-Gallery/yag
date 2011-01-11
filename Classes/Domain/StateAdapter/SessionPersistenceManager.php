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
 * Session persistence adapter for yag gallery
 *
 * @package Domain
 * @subpackage StateAdapter
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_StateAdapter_SessionPersistenceManager extends Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager {
	
	/**
	 * Holds an instance of an session adapter
	 *
	 * @var tx_pttools_sessionStorageAdapter
	 */
	protected $sessionAdapter = null;
    
	
	
	/**
	 * Injector for session adapbter
	 *
	 * @param tx_pttools_sessionStorageAdapter $sessionAdapter
	 */
	public function injectSessionAdapter(tx_pttools_sessionStorageAdapter $sessionAdapter) {
		$this->sessionAdapter = $sessionAdapter;
	}
	
	
	
    /**
     * Persist the cached session data.
     * 
     */
    public function persist() {
        $this->sessionAdapter->store('pt_yag.session', $this->sessionData);
    }
    
    
    
    /**
     * Read the session data into the cache.
     * 
     */
    public function read() {
        $this->sessionData = $this->sessionAdapter->read('pt_yag.session');
    }
	
}
 
?>