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
	 * Holds an instance of rbac user object
	 *
	 * @var Tx_Rbac_Domain_Model_User
	 */
	protected $rbacUser;
	
	
	
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
	protected $configurationBuilder;
	
	
	
	/**
	 * Holds an instance of gallery context
	 *
	 * @var Tx_Yag_Domain_YagContext
	 */
	protected $yagContext;
	
	
	
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
     * Constructor for all plugin controllers
     */
    public function __construct() {
        parent::__construct();
        $this->initAccessControllService();     
    }
    
    
    
    /**
     * Initializes Access Controll Service 
     *
     */
    protected function initAccessControllService() {
    	$this->rbacAccessControllService = Tx_Rbac_Domain_AccessControllServiceFactory::getInstance();
    }
	 
    
    
    /**
     * This action is final, as it should not be overwritten by any extended controllers
     */
    final protected function initializeAction() {
    	$this->preInitializeAction();
    	$this->initializeFeUser();
    	$this->doRbacCheck();
    	$this->yagContext->injectRequest($this->request);
    	$this->postInitializeAction();
    }
    
    
    
    /**
     * Runs rbac check
     * 
     * Access restrictions to controller actions can be created by
     * using @rbacNeedsAccess, @rbacObject <rbacObjectName> and @rbacAction <rbacActionName> annotations in your
     * action comments.
     */
    protected function doRbacCheck() {
    	$this->initializeRbacUser();
        $controller = $this->request->getControllerObjectName();
        $action = $this->actionMethodName;
        $methodTags = $this->reflectionService->getMethodTagsValues($controller, $action);
        
        if (array_key_exists('rbacNeedsAccess', $methodTags)) {
            if ($this->rbacUser) {
                $rbacObject = $methodTags['rbacObject'][0];
                $rbacAction = $methodTags['rbacAction'][0];
                #print_r("<br>RBAC response for user: {$rbacUser[0]->getUid()} object: $rbacObject action: $rbacAction" );
                #var_dump($this->rbacAccessControllService->hasAccess($rbacUser[0]->getUid(), $rbacObject, $rbacAction));
                if (!($this->rbacAccessControllService->hasAccess($this->rbacUser->getUid(), $rbacObject, $rbacAction))) {
                    $this->flashMessages->add('Access denied! You do not have the privileges for this function.');
                    $this->accessDeniedAction();
                }
            } else {
            	if ($this->feUser) {
            		$this->flashMessages->add('Access denied - No RBAC user has been set up for your fe_user!');
            	} else {
                    $this->flashMessages->add('Access denied - You are not logged in!');
            	}
                $this->accessDeniedAction();
            }
        }
    }
    
    
    
    /**
     * Initializes rbac user object
     */
    protected function initializeRbacUser() {
    	if ($this->feUser) {
            $query = t3lib_div::makeInstance(Tx_Rbac_Domain_Repository_UserRepository)->createQuery();
            $query->getQuerySettings()->setRespectStoragePage(FALSE);
            $query->matching($query->equals('feUser', $this->feUser->getUid()));
            $rbacUserArray = $query->execute();
            if (count($rbacUserArray) > 0) {
            	// TODO refactor me!
                $this->rbacUser = $rbacUserArray[0];
                $this->yagContext->setRbacUser($this->rbacUser);
            }
            else $this->rbacUser = null;  // no rbac user found
    	} else {
    		$this->rbacUser = null; // no fe user is logged in
    	}
    }
    
    
    
    /**
     * Template methods to be implemented in extending controllers
     * (this is required since initializeAction() is final due to
     * access controll checks.
     */
    protected function postInitializeAction() {}
    protected function preInitializeAction() {}
    
    
    
    /**
     * Redirects to gallery start page after access for another action has been denied
     *
     * Feel free to override this method in your respective controller
     * 
     * @param Tx_Yag_Domain_Model_Album $album      
     * @param Tx_Yag_Domain_Model_Gallery $gallery
     */
    protected function accessDeniedAction() {
        $this->redirect('list', 'Gallery');
    }
    
    
    
    /**
     * Check for correct configuration
     *
     */
    protected function checkConfiguration() {
    	if (!$this->settings['storagePid'] >= 0) {
    		throw new Exception('No storage PID has been set!');
    	}
    }
    
    
    
	/**
	 * Hook in Configuration set Process 
	 *
	 * @param Tx_Extbase_Configuration_ConfigurationManager $configurationManager
	 */
    public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManager $configurationManager) {
        parent::injectConfigurationManager($configurationManager);

        $this->emSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag']);
        $this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance($this->settings);
        // TODO we would rather have a factory here!
        $this->yagContext = Tx_Yag_Domain_YagContext::getInstance($this->configurationBuilder);
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
     * Initializes fe user for current session
     * 
     */
    protected function initializeFeUser() {
        $feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
        if ($feUserUid > 0) {
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
   	
    	$viewClassName = $this->resolveTsDefinedViewClassName();
    	if($viewClassName) {
			return $viewClassName;
		} 
		
		$viewClassName = parent::resolveViewObjectName();
  		if($viewClassName) {
			return $viewClassName;
		}
		
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
        
		// Setting the controllerContext for the FLUID template renderer         
        Tx_PtExtlist_Utility_RenderValue::setControllerContext($this->controllerContext);
		
	    
        if (method_exists($view, 'injectConfigurationBuilder')) {
            $view->setConfigurationBuilder($this->configurationBuilder);
        }
  		
        $this->setCustomPathsInView($view);  
        
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
