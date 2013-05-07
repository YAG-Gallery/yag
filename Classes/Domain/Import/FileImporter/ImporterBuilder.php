<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Importer Builder for File Importer
 *
 * @package Domain
 * @subpackage Import\FileImporter
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Import_FileImporter_ImporterBuilder extends Tx_Yag_Domain_Import_ImporterBuilder {
	
	/**
     * Holds a singleton instance of this class
     *
     * @var Tx_Yag_Domain_Import_FileImporter_ImporterBuilder
     */
    protected static $instance = NULL;
    
    
    
    /**
     * Factory method for getting an instance of this class as a singleton
     *
     * @return Tx_Yag_Domain_Import_FileImporter_ImporterBuilder Singleton instance of file importer builder
     */
    public static function getInstance() {
        if (self::$instance === NULL) {
            self::$instance = new self(Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance());
        }
        return self::$instance;
    }
    
    
    
    /**
     * Returns an instance of file importer
     *
     * @param Tx_Yag_Domain_Model_Album $album Album to add imported images to
     * @return Tx_Yag_Domain_Import_FileImporter_Importer
     */
    public function getImporterInstanceByAlbum(Tx_Yag_Domain_Model_Album $album) {
        $importer = parent::createImporterForAlbum('Tx_Yag_Domain_Import_FileImporter_Importer', $album); /* @var $importer Tx_Yag_Domain_Import_FileImporter_Importer */
        // As we get the uploaded file in temp dir, we have to move it to origs
        $importer->setMoveFilesToOrigsDirectoryToTrue();
        return $importer;
    }
	
}

?>