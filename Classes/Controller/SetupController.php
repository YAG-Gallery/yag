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
 * Class implements a controller running all setup stuff for yag gallery extension
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_SetupController extends Tx_Yag_Controller_AbstractController {
    
	/**
	 * Holds an instance of rbac extension repository
	 *
	 * @var Tx_Rbac_Domain_Repository_ExtensionRepository
	 */
	protected $extensionRepository;
	
	
	
	/**
	 * Initializes controller before actions are executed
	 */
	protected function postInitializeAction() {
		$this->extensionRepository = t3lib_div::makeInstance('Tx_Rbac_Domain_Repository_ExtensionRepository');
	}
	
	
	
	/**
	 * Index action
	 *
	 * @return string Rendered index action
	 */
	public function indexAction() {
		
	}
	
	
	
	/**
	 * Truncates all tables for rbac
	 * 
	 * @return string Rendered truncateTables action
	 */
	public function truncateTablesAction() {
        $query = $this->extensionRepository->createQuery();
        $query->statement('TRUNCATE TABLE tx_rbac_domain_extension_mm')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_domain_model_action')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_domain_model_domain')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_domain_model_extension')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_domain_model_object')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_domain_model_privilege')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_domain_model_privilegeondomain')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_domain_model_role')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_domain_model_user')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_domain_object_mm')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_object_domain_mm')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_privilege_action_mm')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_role_user_mm')->execute();
        $query->statement('TRUNCATE TABLE tx_rbac_user_role_mm')->execute();
        		 
	}
	
	
	
	/**
	 * Setup action for RBAC settings
	 * 
	 * @return string Rendered setupRbac action
	 */
	public function setupRbacAction() {
		$extension = $this->extensionRepository->findOrCreateExtension('tx_yag');
		$rbacTsImporter = Tx_Rbac_Domain_TsImporterFactory::getInstanceByExtension($extension);
		$tsArray = $this->settings['rbacSettings'];
		$rbacTsImporter->importTsArray($tsArray);
	}
	
}
 
?>