<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009-2013 Daniel Lienert <typo3@lienert.cc>,
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

namespace DL\Yag\Controller;

use DL\Yag\Domain\Configuration\ConfigurationBuilder;
use DL\Yag\Domain\Configuration\ConfigurationBuilderFactory;
use DL\Yag\Domain\Context\YagContext;
use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Domain\Repository\AlbumRepository;
use DL\Yag\Domain\Repository\GalleryRepository;
use DL\Yag\Domain\Repository\ItemRepository;
use DL\Yag\Utility\PidDetector;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Mvc\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class implements an abstract controller for all yag controllers
 *
 * @package Controller
 * @author  Michael Knoll <mimi@kaktusteam.de>
 * @author  Daniel Lienert <typo3@lienert.cc>
 *
 * TODO: Move the generic stuff to pt_extbase ...
 *
 */
abstract class AbstractController extends \Tx_PtExtbase_Controller_AbstractActionController {
    /**
     * Holds an instance of fe_user object
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $feUser = null;


    /**
     * Holds extension manager settings of yag extension
     *
     * @var array
     */
    protected $emSettings = array();


    /**
     * Holds an instance of yag configuration builder
     *
     * @var ConfigurationBuilder
     */
    protected $configurationBuilder = null;


    /**
     * Holds an instance of gallery context
     *
     * @var YagContext
     */
    protected $yagContext;


    /**
     * Holds instance of extlist context
     *
     * @var \Tx_PtExtlist_ExtlistContext_ExtlistContext
     */
    protected $extListContext;


    /**
     * @var \Tx_PtExtbase_Lifecycle_Manager
     */
    protected $lifecycleManager;


    /**
     * Holds an instance of rbac access controll service
     *
     * @var \Tx_PtExtbase_Rbac_RbacServiceInterface
     */
    protected $rbacAccessControllService = null;


    /**
     * Holds instance of pid detector
     *
     * @var PidDetector
     */
    protected $pidDetector;


    /**
     * @var AlbumRepository
     */
    protected $albumRepository;


    /**
     * @var GalleryRepository
     */
    protected $galleryRepository;


    /**
     * Holds instane of extbase persistence manager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persistenceManager;


    /**
     * @var ItemRepository
     */
    protected $itemRepository;


    /**
     * @var \Tx_PtExtbase_State_Session_SessionPersistenceManagerBuilder
     */
    protected $sessionPersistenceManagerBuilder;


    /**
     * Constructor triggers creation of lifecycle manager
     *
     * @param \Tx_PtExtbase_Lifecycle_Manager                              $lifecycleManager
     * @param \Tx_PtExtbase_State_Session_SessionPersistenceManagerBuilder $sessionPersistenceManagerBuilder
     */
    public function __construct( \Tx_PtExtbase_Lifecycle_Manager $lifecycleManager, \Tx_PtExtbase_State_Session_SessionPersistenceManagerBuilder $sessionPersistenceManagerBuilder ) {
        if ( TYPO3_MODE === 'BE' ) {
            GeneralUtility::makeInstance( 'DL\\Yag\\Utility\\TCAUtility' )->deactivateHiddenFields();
        }

        $this->sessionPersistenceManagerBuilder = $sessionPersistenceManagerBuilder;
        parent::__construct( $lifecycleManager );
    }


    /**
     * Injects PID detector
     *
     * @param PidDetector $pidDetector
     */
    public function injectPidDetector( PidDetector $pidDetector ) {
        $this->pidDetector = $pidDetector;
    }


    /**
     * Injects rbac access control service
     *
     * @param \Tx_PtExtbase_Rbac_RbacServiceInterface $rbacService
     */
    public function injectRbacAccessControlService( \Tx_PtExtbase_Rbac_RbacServiceInterface $rbacService ) {
        $this->rbacAccessControllService = $rbacService;
    }


    /**
     * @param GalleryRepository $galleryRepository
     */
    public function injectGalleryRepository( GalleryRepository $galleryRepository ) {
        $this->galleryRepository = $galleryRepository;
    }


    /**
     * @param AlbumRepository $albumRepository
     */
    public function injectAlbumRepository( AlbumRepository $albumRepository ) {
        $this->albumRepository = $albumRepository;
    }


    /**
     * @param ItemRepository $itemRepository
     */
    public function injectItemRepository( ItemRepository $itemRepository ) {
        $this->itemRepository = $itemRepository;
    }


    /**
     * Injects persistence manager
     *
     * @param PersistenceManagerInterface $persistenceManager
     */
    public function injectPersistenceManager( PersistenceManagerInterface $persistenceManager ) {
        $this->persistenceManager = $persistenceManager;
    }


    /**
     * This action is final, as it should not be overwritten by any extended controllers
     */
    final protected function initializeAction() {
        if ( ! $this->configurationBuilder ) {
            if ( $this->request->getControllerActionName() == 'settingsNotAvailable' ) {
                return;
            }
            $this->redirect( 'settingsNotAvailable', 'Backend' );
        }

        if ( ! count( $this->configurationBuilder->getExtConfSettings() ) ) {
            if ( $this->request->getControllerActionName() == 'extConfSettingsNotAvailable' ) {
                return;
            }
            $this->redirect( 'extConfSettingsNotAvailable', 'Backend' );
        }

        if ( TYPO3_MODE === 'BE' ) {
            if ( intval( GeneralUtility::_GP( 'id' ) ) == 0 ) {
                if ( $this->request->getControllerActionName() == 'noGalleryIsPosibleOnPIDZero' ) {
                    return;
                }
                $this->redirect( 'noGalleryIsPosibleOnPIDZero', 'Backend' );
            }
        }

        $this->lifecycleManager->registerAndUpdateStateOnRegisteredObject( $this->objectManager->get( 'DL\\YagPageCache\\PageCacheManager' ) );

        $this->preInitializeAction();
        $this->initializeFeUser();
        $this->doRbacCheck();
        $this->postInitializeAction();
    }


    /**
     * We overwrite this method to allow some extra-functionality in BE mode
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     */
    public function processRequest( RequestInterface $request, ResponseInterface $response ) {
        parent::processRequest( $request, $response );

        if ( TYPO3_MODE === 'BE' ) {
            // if we are in BE mode, this ist the last line called
            $this->lifecycleManager->updateState( \Tx_PtExtbase_Lifecycle_Manager::END );
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
        $accessGranted = false;

        if ( TYPO3_MODE === 'BE' ) {
            // We are in backend mode --> no access restriction
            $accessGranted = true;
        } else {
            // We are in frontend --> use RBAC access control
            $controllerName = $this->request->getControllerObjectName();

            $actionName = $this->actionMethodName;
            $methodTags = $this->reflectionService->getMethodTagsValues( $controllerName, $actionName );

            if ( array_key_exists( 'rbacNeedsAccess', $methodTags ) ) {
                // Access control annotation --> we check for access
                $rbacObject    = $methodTags['rbacObject'][0];
                $rbacAction    = $methodTags['rbacAction'][0];
                $accessGranted = $this->rbacAccessControllService->loggedInUserHasAccess( $this->extensionName, $rbacObject, $rbacAction );
            } else {
                // No access control annotation --> we have access
                $accessGranted = true;
            }
        }

        if ( ! $accessGranted ) {
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
        $this->addFlashMessage( LocalizationUtility::translate( 'tx_yag_general.accessDenied', $this->extensionName, array( $action ) ), '', FlashMessage::ERROR );
        $this->forward( 'index', 'Error' );
    }


    /**
     * Template methods to be implemented in extending controllers
     * (this is required since initializeAction() is final due to
     * access controll checks.
     */
    protected function postInitializeAction() {
    }


    protected function preInitializeAction() {
    }


    /**
     * Hook in Configuration set Process
     *
     * @param ConfigurationManagerInterface $configurationManager
     */
    public function injectConfigurationManager( ConfigurationManagerInterface $configurationManager ) {
        parent::injectConfigurationManager( $configurationManager );

        $this->overwriteFlexFormWithTyposcriptSettings();

        $contextIdentifier = $this->getContextIdentifier();

        if ( $this->settings != null ) {
            $this->emSettings = unserialize( $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag'] );

            $resetContext = isset( $this->settings['contextReset'] ) && (int) $this->settings['contextReset'] == 1 ? true : false;

            ConfigurationBuilderFactory::injectSettings( $this->settings );
            $this->configurationBuilder = ConfigurationBuilderFactory::getInstance( $contextIdentifier, $this->settings['theme'], $resetContext );

            if ( TYPO3_MODE === 'FE' ) {
                GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' )->get( '\Tx_PtExtlist_Extbase_ExtbaseContext' )->setInCachedMode( true );

                $storageAdapter = \Tx_PtExtbase_State_Session_Storage_NullStorageAdapter::getInstance();

                $this->lifecycleManager->registerAndUpdateStateOnRegisteredObject( $this->sessionPersistenceManagerBuilder->getInstance( $storageAdapter ) );
            } else {
                $this->lifecycleManager->registerAndUpdateStateOnRegisteredObject( $this->sessionPersistenceManagerBuilder->getInstance() );
            }

            $this->yagContext = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' )
                                              ->get( 'DL\\Yag\\Domain\\Context\\YagContextFactory' )->createInstance( $contextIdentifier, $resetContext );
        }
    }


    /**
     * Overwrite the settings with the overwriteSettings array
     */
    protected function overwriteFlexFormWithTyposcriptSettings() {
        if ( is_array( $this->settings ) && array_key_exists( 'overwriteFlexForm', $this->settings ) ) {
            $overwriteSettings = $this->settings['overwriteFlexForm'];
            unset( $this->settings['overwriteFlexForm'] );

            ArrayUtility::mergeRecursiveWithOverrule( $this->settings, $overwriteSettings, false, false );
        }
    }


    /**
     * Get the context identifier
     *
     * @return string $contextIdentifier
     */
    protected function getContextIdentifier() {

        // Stage 1: get the identifier from GET / POST
        $identifier = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' )
                                    ->get( 'Tx_PtExtlist_Domain_StateAdapter_GetPostVarAdapterFactory' )->getInstance()->extractGpVarsByNamespace( 'contextIdentifier' );

        // Stage 2: get a defined identifier
        if ( ! $identifier ) {
            $identifier = trim( $this->settings['contextIdentifier'] );
        }

        // Stage 3: get identifier from content element uid (Frontend only)
        if ( ! $identifier ) {
            $identifier = $this->configurationManager->getContentObject()->data['uid'];
        }

        // Stage 4: we generate ourselves a configurationBuilder and look for contextIdentifier there
        if ( ! $identifier ) {
            try {
                $configurationBuilder = ConfigurationBuilderFactory::getInstance( null, 'default' );
                $identifier           = $configurationBuilder->getContextIdentifier();
            } catch ( Exception $e ) { /* seems like we do not have a configuration builder yet :-) */
            }
        }

        // Stage 5: (in backend) generate a default identifier, with this identifier, it is not possible to display two elements on one page (which is not possible in backend)
        if ( ! $identifier ) {
            $identifier = 'backend';
        }

        if ( is_numeric( $identifier ) ) {
            $identifier = 'c' . $identifier;
        }

        return $identifier;
    }


    /**
     * Initializes fe user for current session
     */
    protected function initializeFeUser() {
        $feUserUid = (int) $GLOBALS['TSFE']->fe_user->user['uid'];

        if ( $feUserUid > 0 ) {
            $feUserRepository = $this->objectManager->get( 'TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository' );
            /* @var $feUserRepository \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository */
            $this->feUser = $feUserRepository->findByUid( $feUserUid );
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
        if ( $viewClassName ) {
            return $viewClassName;
        }

        // we get view from controller and action
        $viewClassName = parent::resolveViewObjectName();
        if ( $viewClassName ) {
            return $viewClassName;
        } // we take default view
        else {
            return '\Tx_PtExtlist_View_BaseView';
        }
    }


    /**
     * Resolve the viewClassname defined via typoscript
     *
     * @return string
     * @throws Exception
     */
    protected function resolveTsDefinedViewClassName() {
        $viewClassName = $this->settings['controller'][ $this->request->getControllerName() ][ $this->request->getControllerActionName() ]['view'];

        if ( $viewClassName != '' ) {
            if ( ! class_exists( $viewClassName ) ) {

                // Use the viewClassName as redirect path to a typoscript value holding the viewClassName
                $viewClassName .= '.viewClassName';
                $tsRedirectPath = explode( '.', $viewClassName );
                $viewClassName  = \TYPO3\CMS\Extbase\Utility\ArrayUtility::getValueByPath( $this->settings, $tsRedirectPath );
            }
        }

        if ( $viewClassName && ! class_exists( $viewClassName ) ) {
            throw new Exception( 'View class does not exist! ' . $viewClassName, 1281369758 );
        }

        return $viewClassName;
    }


    /**
     * Initializes the view before invoking an action method.
     *
     * Override this method to solve assign variables common for all actions
     * or prepare the view in another way before the action is called.
     *
     * @param ViewInterface $view The view to be initialized
     *
     * @return void
     * @api
     */
    protected function initializeView( ViewInterface $view ) {
        if ( method_exists( $view, 'injectConfigurationBuilder' ) ) {
            $view->setConfigurationBuilder( $this->configurationBuilder );
        }

        $this->setCustomPathsInView( $view );

        if ( $this->yagContext !== null ) {
            $this->yagContext->injectControllerContext( $this->controllerContext );
        }

        $this->view->assign( 'config', $this->configurationBuilder );
        $this->view->assign( 'yagContext', $this->yagContext );
        $this->view->assign( 'currentPid', current( $this->pidDetector->getPids() ) );
    }


    /**
     * Set the TS defined custom paths in view
     *
     * @param ViewInterface $view
     *
     * @throws Exception
     */
    protected function setCustomPathsInView( ViewInterface $view ) {
        $templatePathAndFilename = null;

        // We can overwrite a template via TS using plugin.yag.settings.controller.<ControllerName>.<actionName>.template
        if ( $this->configurationBuilder ) {
            $templatePathAndFilename = $this->configurationBuilder->buildThemeConfiguration()->getTemplate( $this->request->getControllerName(), $this->request->getControllerActionName() );
            $this->objectManager->get( 'DL\\Yag\\Utility\\HeaderInclusion' )->includeThemeDefinedHeader( $this->configurationBuilder->buildThemeConfiguration() );
        }

        if ( ! $templatePathAndFilename ) {
            $templatePathAndFilename = $this->settings['controller'][ $this->request->getControllerName() ][ $this->request->getControllerActionName() ]['template'];
        }

        if ( isset( $templatePathAndFilename ) && strlen( $templatePathAndFilename ) > 0 ) {

            /**
             * Format Overlay
             */
            if ( $this->request->getFormat() && strtolower( $this->request->getFormat() ) !== 'html' ) {
                $templatePathAndFilename = Div::concatenatePaths( array(
                    dirname( $templatePathAndFilename ),
                    basename( $templatePathAndFilename, '.html' ) . '.' . $this->request->getFormat()
                ) );
            }

            if ( file_exists( GeneralUtility::getFileAbsFileName( $templatePathAndFilename ) ) ) {
                $view->setTemplatePathAndFilename( GeneralUtility::getFileAbsFileName( $templatePathAndFilename ) );
            } else {
                throw new Exception( 'Given template path and filename could not be found or resolved: ' . $templatePathAndFilename . ' 1284655109' );
            }
        }
    }


    /**
     * Forwards the request to another action and / or controller.
     *
     * NOTE: This method only supports web requests and will thrown an exception
     * if used with other request types.
     *
     * @param string                                     $actionName     Name of the action to forward to
     * @param string                                     $controllerName Unqualified object name of the controller to
     *                                                                   forward to. If not specified, the current
     *                                                                   controller is used.
     * @param string                                     $extensionName  Name of the extension containing the
     *                                                                   controller to forward to. If not specified,
     *                                                                   the current extension is assumed.
     * @param array|\Tx_Extbase_MVC_Controller_Arguments $arguments      Arguments to pass to the target action
     * @param integer                                    $pageUid        Target page uid. If NULL, the current page uid
     *                                                                   is used
     * @param integer                                    $delay          (optional) The delay in seconds. Default is no
     *                                                                   delay.
     * @param integer                                    $statusCode     (optional) The HTTP status code for the
     *                                                                   redirect. Default is "303 See Other"
     *
     * @return void
     * @api
     */
    protected function redirect( $actionName, $controllerName = null, $extensionName = null, array $arguments = null, $pageUid = null, $delay = 0, $statusCode = 303 ) {
        $this->lifecycleManager->updateState( \Tx_PtExtbase_Lifecycle_Manager::END );
        parent::redirect( $actionName, $controllerName, $extensionName, $arguments, $pageUid, $delay, $statusCode );
    }
}
