<?php

class Tx_Yag_Tests_Mocks_GalleryControllerMock extends Tx_Yag_Controller_GalleryController {

	public function injectMockView(Tx_Extbase_MVC_View_ViewInterface $view) {
		$this->view = $view;
	}
	
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
	
}

?>
