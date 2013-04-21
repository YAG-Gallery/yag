<?php

abstract class Tx_Yag_View_AbstractFeedView extends Tx_PtExtbase_View_BaseView {


	protected $feedItemType = 'unknown';


	public function initializeView() {

		$feedFormat = $this->controllerContext->getRequest()->getFormat();
		$feedFormat = ucfirst(strtolower($feedFormat));
		$templatePathAndFileName = $this->getTemplateRootPath() . "/Feeds/$feedFormat.html";
		$this->setTemplatePathAndFilename($templatePathAndFileName);

	}



	/**
	 * @return string|void
	 */
	public function render() {
		$this->assign('feedInfo', $this->buildFeedInfo());
		$this->assign('feedItemType', $this->feedItemType);

		ob_clean();
		echo parent::render();
		exit;
	}



	/**
	 * @param Tx_Extbase_MVC_Controller_ControllerContext $controllerContext
	 * @return bool
	 */
	public function canRender(Tx_Extbase_MVC_Controller_ControllerContext $controllerContext) {
		return true;
	}


	/**
	 * @return array
	 */
	protected function buildFeedInfo() {
		return array(
			'creationDate' => new DateTime(),
		);
	}
}