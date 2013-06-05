<?php

class Tx_Yag_View_ItemList_ListJson extends Tx_PtExtbase_View_BaseView {

	/**
	 * @return string|void
	 */
	public function render() {
		ob_clean();
		echo parent::render();
		exit;
	}


	protected function buildItemList() {

	}

}