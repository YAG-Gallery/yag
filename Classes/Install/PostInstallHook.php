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

// We need those lines, if extension is first installed (no autoload is running here!)
if (t3lib_extMgm::isLoaded('rbac')) {
    require_once t3lib_extMgm::extPath('rbac') . 'Classes/Install/Utility.php';
}
require_once t3lib_extMgm::extPath('pt_extlist') . 'Classes/Utility/NameSpace.php';

/**
 * Post-install hook for yag extension. This hook is executed after extension is installed.
 * 
 * Hook is defined in ext_conf_template.txt file.
 * 
 * @see Tx_Rbac_Install_Utility and Tx_Rbac_Install_PostInstallHook
 *
 * @package Install
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Install_PostInstallHook {

	/**
	 * Imports RBAC settings of yag extension into database
	 *
	 * @return string Success message or Error message
	 */
	public static function setupRbac() {
		if (t3lib_extMgm::isLoaded('rbac')) {
			// We get TS array of rbac settings
	        $tsSetupFile = t3lib_extMgm::extPath('yag') . '/Configuration/TypoScript/Rbac/setup.ts';
	        return Tx_Rbac_Install_Utility::doImportByExtensionNameTsFilePathAndTsKey('tx_yag', $tsSetupFile, 'plugin.tx_yag.settings.rbacSettings');
		}
		return 'No RBAC is loaded, so no RBAC settings have been imported!';
	}
	
}

?>