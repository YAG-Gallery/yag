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
 * Base class for all YAG importers
 *
 * @package Domain
 * @subpackage Import
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
abstract class Tx_Yag_Domain_Import_AbstractImporter implements Tx_Yag_Domain_Import_ImporterInterface {
    
    /**
     * Holds an instance of album content manager
     *
     * @var Tx_Yag_Domain_AlbumContentManager
     */
    protected $albumContentManager;
    
    
    
    /**
     * Holds an instance of configuration builder
     *
     * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
     */
    protected $configurationBuilder;
    
    
    
    /**
     * Injector for album content manager
     *
     * @param Tx_Yag_Domain_AlbumContentManager $albumContentManager
     */
    public function injectAlbumManager(Tx_Yag_Domain_AlbumContentManager $albumContentManager) {
        $this->albumContentManager = $albumContentManager;
    }
    
    
    
    /**
     * Injector for configuration builder
     *
     * @param Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder
     */
    public function injectConfigurationBuilder(Tx_Yag_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
        $this->configurationBuilder = $configurationBuilder;
    }
	
}
 
?>