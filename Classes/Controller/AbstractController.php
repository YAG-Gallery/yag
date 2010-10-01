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
 * Class implements an abstract controller for all yag controllers
 * 
 * @package Yag
 * @subpackage Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
abstract class Tx_Yag_Controller_AbstractController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * Holds extension manager settings of yag extension
	 *
	 * @var array
	 */
	protected $emSettings = array();
	
	
	
    /**
     * Redirects on a access denied page, if fe user has no admin rights
     *
     * @param Tx_Yag_Domain_Model_Album $album
     * @param Tx_Yag_Domain_Model_Gallery $gallery
     * @return bool     True, if user is in admin group or BE-Mode
     */
    protected function checkForAdminRights() {
        if (TYPO3_MODE === 'BE') {
            return TRUE;
        }
        if (!Tx_Yag_Div_YagDiv::isLoggedInUserInGroups(explode(',', $this->settings[adminGroups]))) {
            $this->accessDeniedAction();  
        } else {
            return true;
        }
    }
    
    
    
    /**
     * Injects the settings of the extension.
     *
     * @param array $settings Settings container of the current extension
     * @return void
     */
    public function injectSettings(array $settings) {
        parent::injectSettings($settings);

        $this->emSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag']);
    }
    
    
    
    /**
     * Redirects to gallery start page after access for another action has been denied
     *
     * @param Tx_Yag_Domain_Model_Album $album      
     * @param Tx_Yag_Domain_Model_Gallery $gallery
     */
    protected function accessDeniedAction(
        Tx_Yag_Domain_Model_Album $album = NULL,
        Tx_Yag_Domain_Model_Gallery $gallery = NULL
    ) {
        $this->flashMessages->add('Access denied!');
        $this->redirect('index', 'Gallery', NULL, array('album' => $album, 'gallery' => $gallery));
    }
    
    
    
    /**
     * Returns a request parameter, if it's available.
     * Returns NULL if it's not available
     *
     * @param string $parameterName
     * @return string
     */
    protected function getParameterSafely($parameterName) {
        if ($this->request->hasArgument($parameterName)) {
            return $this->request->getArgument($parameterName);
        }
        return NULL;
    }
    
    
    
    /**
     * Initializes the view before invoking an action method.
     *
     * Override this method to solve assign variables common for all actions
     * or prepare the view in another way before the action is called.
     *
     * @param Tx_Extbase_MVC_View_ViewInterface $view The view to be initialized
     * @return void
     * @api
     */
    protected function initializeView(Tx_Extbase_MVC_View_ViewInterface $view) {
    	#$view->assign('userIsAdmin', Tx_Yag_Div_YagDiv::isLoggedInUserInGroups(explode(',',$this->settings['adminGroups'])));
    }
    
    	
}

?>