<?php

class Tx_Yag_Tests_Mocks_GalleryControllerMock extends Tx_Yag_Controller_GalleryController {

	
   /**
    * Set up required objects for tested controller
    *
    */
   public function __construct() {
   	    parent::__construct();
   	    $this->request = new Tx_Extbase_MVC_Web_Request();
        $this->flashMessages = new Tx_Extbase_MVC_Controller_FlashMessages();
        $uriBuilder = new Tx_Extbase_MVC_Web_Routing_UriBuilder();
        $uriBuilder->setRequest($this->request);
        $this->uriBuilder = $uriBuilder;
        $this->response = new Tx_Extbase_MVC_Web_Response();
    }
    
    
    
    /**
     * Sets request for current controller
     * @param object $request
     */
    public function setRequest($request) {
    	$this->request = $request;
    }
	
    
    
    /**
     * Inject an empty view 
     *
     * @param Tx_Extbase_MVC_View_ViewInterface $view
     */
	public function injectMockView(Tx_Extbase_MVC_View_ViewInterface $view) {
		$this->view = $view;
	}
	
	
	/**
	 * Inject a repository
	 *
	 * @param Tx_Extbase_Persistence_RepositoryInterface $mockRepository
	 */
	public function injectMockRepository(Tx_Extbase_Persistence_RepositoryInterface $mockRepository) {
		$this->galleryRepository = $mockRepository;
	}
	
	
	
	/**
	 * Returns (protected) view of controller for testing
	 *
	 * @return Tx_Fluid_View_TemplateView   View handled by controller
	 */
	public function getView() {
		return $this->view;
	}
	
	/**
	 * Redirect obviously won't work :-)
	 * 
	 * As we test the controller actions directly and redirects are handled via an Exception,
	 * the test will break as soon as we get an Exception thrown!
	 *
	 * @param unknown_type $actionName
	 * @param unknown_type $controllerName
	 * @param unknown_type $extensionName
	 * @param array $arguments
	 * @param unknown_type $pageUid
	 * @param unknown_type $delay
	 * @param unknown_type $statusCode
	 */
	public function redirect($actionName, $controllerName = NULL, $extensionName = NULL, array $arguments = NULL, $pageUid = NULL, $delay = 0, $statusCode = 303) {
		
	}
	
}

?>
