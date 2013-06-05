<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009-2013 Daniel Lienert <daniel@lienert.cc>,
*                Michael Knoll <mimi@kaktusteam.de>
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
	protected $feUser = NULL;

	
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
	 * @var Tx_Yag_Domain_Context_YagContext
	 */
	protected $yagContext;
	
	
		
	/**
	 * Holds instance of extlist context
	 * 
	 * @var Tx_PtExtlist_ExtlistContext_ExtlistContext
	 */
	protected $extListContext;
	
	
	
	/**
     * @var Tx_PtExtbase_Lifecycle_Manager
     */
    protected $lifecycleManager;

    
    
    /**
     * Holds an instance of rbac access controll service
     *
     * @var Tx_PtExtbase_Rbac_RbacServiceInterface
     */
    protected $rbacAccessControllService = NULL;



    /**
     * Holds instance of pid detector
     *
     * @var Tx_Yag_Utility_PidDetector
     */
    protected $pidDetector;



	/**
	 * @var Tx_Yag_Domain_Repository_AlbumRepository
	 */
	protected $albumRepository;



    /**
	 * @var Tx_Yag_Domain_Repository_GalleryRepository
	 */
	protected $galleryRepository;



    /**
     * Holds instane of extbase persistence manager
     *
     * @var Tx_Extbase_Persistence_Manager
     */
    protected $persistenceManager;



	/**
	 * @var Tx_Yag_Domain_Repository_ItemRepository
	 */
	protected $itemRepository;



	/**
	 * Injects PID detector
	 *
	 * @param Tx_Yag_Utility_PidDetector $pidDetector
	 */
	public function injectPidDetector(Tx_Yag_Utility_PidDetector $pidDetector) {
		$this->pidDetector = $pidDetector;
	}


	/**
	 * Injects rbac access control service
	 *
	 * @param Tx_PtExtbase_Rbac_RbacServiceInterface $rbacService
	 */
	public function injectRbacAccessControlService(Tx_PtExtbase_Rbac_RbacServiceInterface $rbacService) {
		$this->rbacAccessControllService = $rbacService;
	}


	/**
	 * @param Tx_Yag_Domain_Repository_GalleryRepository $galleryRepository
	 */
	public function injectGalleryRepository(Tx_Yag_Domain_Repository_GalleryRepository $galleryRepository) {
		$this->galleryRepository = $galleryRepository;
	}


	/**
	 * @param Tx_Yag_Domain_Repository_AlbumRepository $albumRepository
	 */
	public function injectAlbumRepository(Tx_Yag_Domain_Repository_AlbumRepository $albumRepository) {
		$this->albumRepository = $albumRepository;
	}


	/**
	 * @param Tx_Yag_Domain_Repository_ItemRepository $itemRepository
	 */
	public function injectItemRepository(Tx_Yag_Domain_Repository_ItemRepository $itemRepository) {
		$this->itemRepository = $itemRepository;
	}


    /**
     * Constructor triggers creation of lifecycle manager
     */
	public function __construct() {
		$this->lifecycleManager = Tx_PtExtbase_Lifecycle_ManagerFactory::getInstance();
		// TODO inject me!
		parent::__construct();
	}



	/**
	 * Injects persistence manager
	 *
	 * @param Tx_Extbase_Persistence_Manager $persistenceManager
	 */
	public function injectPersistenceManager(Tx_Extbase_Persistence_Manager $persistenceManager) {
		$this->persistenceManager = $persistenceManager;
	}



    /**
     * This action is final, as it should not be overwritten by any extended controllers
     */
	final protected function initializeAction() {
		if (!$this->configurationBuilder) {
			if ($this->request->getControllerActionName() == 'settingsNotAvailable') return;
			$this->redirect('settingsNotAvailable', 'Backend');
		}

		if (!count($this->configurationBuilder->getExtConfSettings())) {
			if ($this->request->getControllerActionName() == 'extConfSettingsNotAvailable') return;
			$this->redirect('extConfSettingsNotAvailable', 'Backend');
		}

		if(TYPO3_MODE === 'BE' && intval(t3lib_div::_GP('id')) == 0) {
			if ($this->request->getControllerActionName() == 'noGalleryIsPosibleOnPIDZero') return;
			$this->redirect('noGalleryIsPosibleOnPIDZero', 'Backend');
		}

		$this->lifecycleManager->registerAndUpdateStateOnRegisteredObject($this->objectManager->get('Tx_Yag_PageCache_PageCacheManager'));

		$this->preInitializeAction();
		$this->initializeFeUser();
		$this->doRbacCheck();
		$this->postInitializeAction();
	}
    
    

	/**
	 * We overwrite this method to allow some extra-functionality in BE mode
	 *
	 * @param Tx_Extbase_MVC_RequestInterface $request
	 * @param Tx_Extbase_MVC_ResponseInterface $response
	 */
	public function processRequest(Tx_Extbase_MVC_RequestInterface $request, Tx_Extbase_MVC_ResponseInterface $response) {
		parent::processRequest($request, $response);
		
		if(TYPO3_MODE === 'BE') {
			// if we are in BE mode, this ist the last line called
			Tx_PtExtbase_Lifecycle_ManagerFactory::getInstance()->updateState(Tx_PtExtbase_Lifecycle_Manager::END);
		}
	}

    
    
    /**
     * Runs rbac check
     * 
     * Access restrictions to controller actions can be created by
     * using @rbacNeedsAccess, @rbacObject <rbacObjectName> and @rbacAction <rbacActionName> annotations in your
     * action comments.
     */
    protected function doRbacCheck() {
		$accessGranted = FALSE;

		if (TYPO3_MODE === 'BE') {
			// We are in backend mode --> no access restriction
			$accessGranted = TRUE;
		} else {
			// We are in frontend --> use rbac access control
			$controllerName = $this->request->getControllerObjectName();

			$actionName = $this->actionMethodName;
			$methodTags = $this->reflectionService->getMethodTagsValues($controllerName, $actionName);
			if (array_key_exists('rbacNeedsAccess', $methodTags)) {
				// Access control annotation --> we check for access
				$rbacObject = $methodTags['rbacObject'][0];
				$rbacAction = $methodTags['rbacAction'][0];
				$accessGranted = $this->rbacAccessControllService->loggedInUserHasAccess($this->extensionName, $rbacObject, $rbacAction);
			} else {
				// No access control annotation --> we have access
				$accessGranted = TRUE;
			}
		}

		if (!$accessGranted) {
			$this->accessDeniedAction();
		}
    }
    
    
    
    /**
     * Redirects to gallery start page after access for another action has been denied
     *
     * Feel free to override this method in your respective controller
     * 
     */
    protected function accessDeniedAction() {
    	$action = $this->request->getControllerObjectName() . '->' . $this->actionMethodName;
    	$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_yag_general.accessDenied', $this->extensionName, array($action)),'',t3lib_FlashMessage::ERROR);
		$this->forward('index', 'Error');
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

		$this->overwriteFlexFormWithTyposcriptSettings();

    	$contextIdentifier = $this->getContextIdentifier();

    	if($this->settings != NULL) {
    		$this->emSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag']);

			$resetContext = isset($this->settings['contextReset']) && (int) $this->settings['contextReset'] == 1 ? TRUE : FALSE;

    		Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::injectSettings($this->settings);
    		$this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance($contextIdentifier, $this->settings['theme'], $resetContext);

    		if(TYPO3_MODE === 'FE') {
    			t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')->get('Tx_PtExtlist_Extbase_ExtbaseContext')->setInCachedMode(TRUE);

    			$storageAdapter = Tx_PtExtbase_State_Session_Storage_NullStorageAdapter::getInstance();

    			$this->lifecycleManager->registerAndUpdateStateOnRegisteredObject(Tx_PtExtbase_State_Session_SessionPersistenceManagerFactory::getInstance($storageAdapter));
    		} else {
    			$this->lifecycleManager->registerAndUpdateStateOnRegisteredObject(Tx_PtExtbase_State_Session_SessionPersistenceManagerFactory::getInstance());
    		}

    		$this->yagContext = Tx_Yag_Domain_Context_YagContextFactory::createInstance($contextIdentifier, $resetContext);
    	}
    }


	/**
	 * Overwrite the settings with the overwriteSettings array
	 */
	protected function overwriteFlexFormWithTyposcriptSettings() {
		if(is_array($this->settings) && array_key_exists('overwriteFlexForm', $this->settings)) {
			$overwriteSettings = $this->settings['overwriteFlexForm'];
			unset($this->settings['overwriteFlexForm']);

			$this->settings = t3lib_div::array_merge_recursive_overrule($this->settings, $overwriteSettings	, FALSE, FALSE);
		}
	}
    
    
    /**
     * Get the context identifier
     * 
     * @return string $contextIdentifier
     */
    protected function getContextIdentifier() {

    	// Stage 1: get the identifier from GET / POST
    	$identifier  = Tx_PtExtlist_Domain_StateAdapter_GetPostVarAdapterFactory::getInstance()->extractGpVarsByNamespace('contextIdentifier');
    	
    	// Stage 2: get a defined identifier
    	if(!$identifier) {
    		$identifier = trim($this->settings['contextIdentifier']);
    	}    
    	
    	// Stage 3: get identifier from content element uid (Frontend only)
    	if(!$identifier) {
    		$identifier = $this->configurationManager->getContentObject()->data['uid'];
    	}
    	
    	// Stage 4: we generate ourselves a configurationBuilder and look for contextIdentifier there
    	if (!$identifier) {
	    	try {
	    		$configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance(NULL, 'default');
	    		$identifier = $configurationBuilder->getContextIdentifier();
	    	} catch(Exception $e) { /* seems like we do not have a configuration builder yet :-) */ }
    	}
    	
    	// Stage 5: (in backend) generate a default identifier, with this identifier, it is not possible to display two elements on one page (which is not possible in backend)
    	if(!$identifier) {
    		$identifier = 'backend';
    	}

		if(is_numeric($identifier)) $identifier = 'c' . $identifier;

    	return $identifier;
    }
    
    
    
    /**
     * Initializes fe user for current session
     */
    protected function initializeFeUser() {
        $feUserUid = (int) $GLOBALS['TSFE']->fe_user->user['uid'];
        if ($feUserUid > 0) {
            $feUserRepository = t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository'); /* @var $feUserRepository Tx_Extbase_Domain_Repository_FrontendUserRepository */
            $this->feUser = $feUserRepository->findByUid($feUserUid);
        } else {
            $this->feUser = NULL;
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
	 * @throws Exception
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
    		throw new Exception('View class does not exist! ' . $viewClassName, 1281369758);
    	}
    	
		return $viewClassName;
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
        	    
        if (method_exists($view, 'injectConfigurationBuilder')) {
            $view->setConfigurationBuilder($this->configurationBuilder);
        }
  		
        $this->setCustomPathsInView($view);  
        
        if($this->yagContext !== NULL) {
        	$this->yagContext->injectControllerContext($this->controllerContext);
        }
	
        $this->view->assign('config', $this->configurationBuilder);
    	$this->view->assign('yagContext', $this->yagContext);
		$this->view->assign('currentPid', current($this->pidDetector->getPids()));
	}

	
		
	/**
	 * Set the TS defined custom paths in view
	 * 
	 * @param Tx_Extbase_MVC_View_ViewInterface $view
	 * @throws Exception
	 */
	protected function setCustomPathsInView(Tx_Extbase_MVC_View_ViewInterface $view) {
		
		// We can overwrite a template via TS using plugin.yag.settings.controller.<ControllerName>.<actionName>.template
		if($this->configurationBuilder) {
			$templatePathAndFilename = $this->configurationBuilder->buildThemeConfiguration()->getTemplate($this->request->getControllerName(), $this->request->getControllerActionName());
			$this->objectManager->get('Tx_Yag_Utility_HeaderInclusion')->includeThemeDefinedHeader($this->configurationBuilder->buildThemeConfiguration());
		}

		if(!$templatePathAndFilename) $templatePathAndFilename = $this->settings['controller'][$this->request->getControllerName()][$this->request->getControllerActionName()]['template'];
	
		if (isset($templatePathAndFilename) && strlen($templatePathAndFilename) > 0) {
			if (file_exists(t3lib_div::getFileAbsFileName($templatePathAndFilename))) {
                $view->setTemplatePathAndFilename(t3lib_div::getFileAbsFileName($templatePathAndFilename));
			} else {
				throw new Exception('Given template path and filename could not be found or resolved: ' . $templatePathAndFilename . ' 1284655109');
			}
        }		
	}
	
	
	
	/**
     * Forwards the request to another action and / or controller.
     *
     * NOTE: This method only supports web requests and will thrown an exception
     * if used with other request types.
     *
     * @param string $actionName Name of the action to forward to
     * @param string $controllerName Unqualified object name of the controller to forward to. If not specified, the current controller is used.
     * @param string $extensionName Name of the extension containing the controller to forward to. If not specified, the current extension is assumed.
     * @param Tx_Extbase_MVC_Controller_Arguments $arguments Arguments to pass to the target action
     * @param integer $pageUid Target page uid. If NULL, the current page uid is used
     * @param integer $delay (optional) The delay in seconds. Default is no delay.
     * @param integer $statusCode (optional) The HTTP status code for the redirect. Default is "303 See Other"
     * @return void
     * @throws Tx_Extbase_MVC_Exception_UnsupportedRequestType If the request is not a web request
     * @throws Tx_Extbase_MVC_Exception_StopAction
     * @api
     */
    protected function redirect($actionName, $controllerName = NULL, $extensionName = NULL, array $arguments = NULL, $pageUid = NULL, $delay = 0, $statusCode = 303) {
    	$this->lifecycleManager->updateState(Tx_PtExtbase_Lifecycle_Manager::END);
        parent::redirect($actionName, $controllerName, $extensionName, $arguments, $pageUid, $delay, $statusCode);
    }
    
}

?>