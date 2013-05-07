<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*            
*           
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

/**
 * Class implements some static methods for user management
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @package Domain
 * @subpackage UserManagement
 */
class Tx_Yag_Domain_UserManagement_Div {

    /**
     * Returns a fe user domain object for a currently logged in user 
     * or NULL if no user is logged in.
     *
     * @return Tx_Extbase_Domain_Model_FrontendUser  FE user object
     */
    public static function getLoggedInUserObject() {
        $feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
        if ($feUserUid > 0) {
            $feUserRepository = t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository'); /* @var $feUserRepository Tx_Extbase_Domain_Repository_FrontendUserRepository */
            return $feUserRepository->findByUid(intval($feUserUid));
        } else {
            return NULL;
        }
    }
    
    
    
    /**
     * Returns groups of currently logged in frontend user or null if no fe user is logged in.
     *
     * @return Tx_Extbase_Persistence_ObjectStorage     Object storage with fe user groups for currently logged in user
     */
    public static function getLoggedInUserGroups() {
        $feUserObject = self::getLoggedInUserObject(); /* @var $feUserObject Tx_Extbase_Domain_Model_FrontendUser */
        if (!is_null($feUserObject)) {
            return $feUserObject->getUsergroups();
        } else {
            return NULL;
        }
    }
    
    
    
    /**
     * Returns true, if currently logged in user is in given fe user group
     *
     * @param int   $groupId   The group UID for in which we want to know wheter the user belongs to
     * @return bool     True, if currently logged in fe user belongs to given group
     */
    public static function isLoggedInUserInGroup($groupId) {
         $loggedInFeUserGroups = self::getLoggedInUserGroups();
         if (!is_null($loggedInFeUserGroups)) {
            foreach($loggedInFeUserGroups as $feUserGroup) { /* @var $feUserGroup Tx_Extbase_Domain_Model_FrontendUserGroup */
                if ($feUserGroup->getUid() == $groupId) {
                    return TRUE;
                }
            }
         }
         return FALSE;
    }
    
    
    
    /**
     * Returns true, if the currently logged in user is in one of the 
     * given fe groups
     *
     * @param array $feUserGroupUids
     * @return unknown
     */
    public static function isLoggedInUserInGroups($feUserGroupUids) {
        foreach($feUserGroupUids as $feUserGroupUid) {
            if (self::isLoggedInUserInGroup($feUserGroupUid))
                return TRUE;
        }
        return FALSE;
    }
    
}
?>