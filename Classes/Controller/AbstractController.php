<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Daniel Lienert <daniel@lienert.cc>,
*           Michael Knoll <mimi@kaktusteam.de>
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
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 * 
 * TODO: Move the general stuff to pt_extbase ...
 * 
 */
abstract class Tx_Yag_Controller_AbstractController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * Holds an instance of fe_user object
	 *
	 * @var Tx_Extbase_Domain_Model_FrontendUser
	 */
	protected $feUser;
	
	
	
	/**
	 * Holds extension manager settings of yag extension
	 *
	 * @var array
	 */
	protected $emSettings = array();
	
	
	
	/**
	 * Holds an instance of yag configuration builder
	 *
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder = NULL;
	
	
	
	/**
	 * Holds an instance of gallery context
	 *
	 * @var Tx_Yag_Domain_YagContext
	 */
	protected $yagContext;
	
	
		
	/**
	 * Holds instance of extlist context
	 * 
	 * @var Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	protected $extListContext;
	
	
	
	/**
     * @var Tx_PtExtlist_Domain_Lifecycle_LifecycleManager
     */
    protected $lifecycleManager;

    
    
    /**
     * Holds an instance of rbac access controll service
     *
     * @var Tx_Rbac_Domain_AccessControllService
     */
    protected $rbacAccessControllService;
	 
    
    
    /**
     * This action is final, as it should not be overwritten by any extended controllers
     */
    final protected function initializeAction() {   
    	
    	if(!$this->configurationBuilder) {
    		if($this->request->getControllerActionName() == 'settingsNotAvailable') return;
    		
    		$this->flashMessageContainer->add(
    		Tx_Extbase_Utility_Localization::translate('tx_yag_controller_backend_settingsNotAvailable.infoText', $this->extensionName),
    		Tx_Extbase_Utility_Localization::translate('tx_yag_controller_backend_settingsNotAvailable.headline', $this->extensionName), 
    		t3lib_FlashMessage::INFO);
    		$this->redirect('settingsNotAvailable', 'Backend');	
    	}
    	
    	$this->preInitializeAction();
    	$this->initializeFeUser();
        $this->initAccessControllService();     
    	$this->doRbacCheck();
    	$this->postInitializeAction();
    }
    
    
    
	public function processRequest(Tx_Extbase_MVC_RequestInterface $request, Tx_Extbase_MVC_ResponseInterface $response) {
		parent::processRequest($request, $response);
		
		if(TYPO3_MODE === 'BE') {
			// if we are in BE mode, this ist the last line called
			Tx_PtExtlist_Domain_Lifecycle_LifecycleManagerFactory::getInstance()->updateState(Tx_PtExtlist_Domain_Lifecycle_LifecycleManager::END);
		}
	}
    
	
    
    /**
     * Initializes Access Controll Service 
     *
     */
    protected function initAccessControllService() {
    	// TODO change this, so that acs is only instantiated, if we need it for access controll
    	$this->rbacAccessControllService = Tx_Rbac_Domain_AccessControllServiceFactory::getInstance($this->feUser);
    	$this->rbacAccessControllService->injectReflectionService($this->reflectionService);
    }
    
    
    
    /**
     * Runs rbac check
     * 
     * Access restrictions to controller actions can be created by
     * using @rbacNeedsAccess, @rbacObject <rbacObjectName> and @rbacAction <rbacActionName> annotations in your
     * action comments.
     */
    protected function doRbacCheck() {
    	// TODO change this, so that acs is only instantiated, if we need it for access controll
        $controllerName = $this->request->getControllerObjectName();
        $actionName = $this->actionMethodName;
    	if (!$this->rbacAccessControllService->loggedInUserHasAccessToControllerAndAction($controllerName, $actionName)) {
    		$this->flashMessageContainer->add('You arenot allowed to access this functionality', 'Access denied', t3lib_FlashMessage::ERROR);
    		$this->accessDeniedAction();
    	}
    	
    }
    
    
    
    /**
     * Redirects to gallery start page after access for another action has been denied
     *
     * Feel free to override this method in your respective controller
     * 
     * @param Tx_Yag_Domain_Model_Album $album      
     * @param Tx_Yag_Domain_Model_Gallery $gallery
     */
    protected function accessDeniedAction() {
    	// TODO set defaults in TS prototype not here!
    	$accessDeniedController = $this->settings['accessDenied']['controller'] != '' ? $this->settings['accessDenied']['controller'] : 'Gallery';
    	$accessDeniedAction = $this->settings['accessDenied']['action'] != '' ? $this->settings['accessDenied']['action'] : 'list';
        $this->redirect($accessDeniedAction, $accessDeniedController);
    }
    
    
    
    /**
     * Template methods to be implemented in extending controllers
     * (this is required since initializeAction() is final due to
     * access controll checks.
     */
    protected function postInitializeAction() {}
    protected function preInitializeAction() {}
    
    
    
	/**
	 * Hook in Configuration set Process 
	 *
	 * @param Tx_Extbase_Configuration_ConfigurationManager $configurationManager
	 */
    public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManager $configurationManager) {
        parent::injectConfigurationManager($configurationManager);
		
        if($this->settings != NULL) {
	        $this->emSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag']);
	        
	        Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::injectSettings($this->settings);
	        $this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance($this->settings['theme']);

                $selectedAlbumUid = null;

          /**
           * As we have configuration builder as a singleton, we cannot determine flexform settings
           * if there are multiple instances of a plugin on the same page.
           * 
           * So we have to pass plugin-instance specific settings via direct access to settings
           * here
           * 
           * YOU SHOULD TAKE THIS SERIOUSLY!
           */
          	if (array_key_exists('album', $this->settings) && array_key_exists('selectedAlbumUid', $this->settings['album'])) {
	              $selectedAlbumUid = $this->settings['album']['selectedAlbumUid']; 
	         }

 	  	     $selectedGalleryUid = null;

	         if (array_key_exists('gallery', $this->settings) && array_key_exists('selectedGalleryUid', $this->settings['gallery'])) {
	            $selectedGalleryUid = $this->settings['gallery']['selectedGalleryUid'];
	         }    
	         
	        // TODO we would rather have a factory here!
	        $this->yagContext = Tx_Yag_Domain_YagContext::getInstance($this->configurationBuilder, $selectedAlbumUid, $selectedGalleryUid);
        }
    }
    
    
    
    /**
     * Initializes fe user for current session
     * 
     */
    protected function initializeFeUser() {
        $feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
        if ($feUserUid > 0) {
        	// TODO put this into pt_extbase
            $feUserRepository = t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository'); /* @var $feUserRepository Tx_Extbase_Domain_Repository_FrontendUserRepository */
            $query = $feUserRepository->createQuery();
            $query->getQuerySettings()->setRespectStoragePage(FALSE);
            $queryResult = $query->matching($query->equals('uid', $feUserUid))->execute();
            if (count($queryResult) > 0) {
                $this->feUser = $queryResult[0];
            }
        } else {
            $this->feUser = null;
        }
    }
    
    
    
    /**
     * Resolve the viewObjectname in the following order
     * 
     * 1. TS-defined
     * 2. Determined by Controller/Action/Format
     * 3. Extlist BaseView 
     * 
     * @throws Exception
     * @return string
     */
    protected function resolveViewObjectName() {

    	// we get view from TS settings?
    	$viewClassName = $this->resolveTsDefinedViewClassName();
    	if($viewClassName) {
			return $viewClassName;
		} 
		
		// we get view from controller and action
		$viewClassName = parent::resolveViewObjectName();
  		if($viewClassName) {
			return $viewClassName;
		}
		
		// we take default view
		else {
			return 'Tx_PtExtlist_View_BaseView';
		}
    }
    
    
    
    /**
     * Resolve the viewClassname defined via typoscript
     * 
     * @return string
     */
    protected function resolveTsDefinedViewClassName() {
    	
    	$viewClassName = $this->settings['controller'][$this->request->getControllerName()][$this->request->getControllerActionName()]['view'];

    	if($viewClassName != '') {
    		if (!class_exists($viewClassName)) {
		    	
	    		// Use the viewClassName as redirect path to a typoscript value holding the viewClassName
		    	$viewClassName .= '.viewClassName';
		    	$tsRedirectPath = explode('.', $viewClassName);
		    	$viewClassName = Tx_Extbase_Utility_Arrays::getValueByPath($this->settings, $tsRedirectPath);
		    	
    		}	
    	}
    	
    	if($viewClassName && !class_exists($viewClassName)) {
    		throw new Exception('View class does not exist! ' . $viewClassName . ' 1281369758');
    	}
    	
		return $viewClassName;
    }
    
    
    
	/**
	 * Initializes the view before invoking an action method.
	 *
	 * Override this method to solve assign variables common for all actions
	 * or prepare the view in another way before the action is called.
	 *
	 * @param Tx_Extbase_View_ViewInterface $view The view to be initialized
	 * @return void
	 * @api
	 */
	protected function initializeView(Tx_Extbase_MVC_View_ViewInterface $view) {
        	    
        if (method_exists($view, 'injectConfigurationBuilder')) {
            $view->setConfigurationBuilder($this->configurationBuilder);
        }
  		
        $this->setCustomPathsInView($view);  
        
        if($this->yagContext != NULL) {
        	$this->yagContext->injectControllerContext($this->controllerContext);	
        }
        
        $this->view->assign('config', $this->configurationBuilder);
    	$this->view->assign('yagContext', $this->yagContext);
	}

	
	
	/**
	 * Set the TS defined custom paths in view
	 * 
	 * @param Tx_Extbase_MVC_View_ViewInterface $view
	 * @throws Exception
	 */
	protected function setCustomPathsInView(Tx_Extbase_MVC_View_ViewInterface $view) {
		
		// We can overwrite a template via TS using plugin.yag.settings.controller.<ControllerName>.<actionName>.template
		$templatePathAndFilename = $this->settings['controller'][$this->request->getControllerName()][$this->request->getControllerActionName()]['template'];
	
		if (isset($templatePathAndFilename) && strlen($templatePathAndFilename) > 0) {
			if (file_exists(t3lib_div::getFileAbsFileName($templatePathAndFilename))) {
                $view->setTemplatePathAndFilename(t3lib_div::getFileAbsFileName($templatePathAndFilename));
			} else {
				throw new Exception('Given template path and filename could not be found or resolved: ' . $templatePathAndFilename . ' 1284655109');
			}
        }		
	}	
}
?>
