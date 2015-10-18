<?php

class Tx_Yag_View_ItemList_ListJson extends Tx_PtExtbase_View_BaseView
{
    /**
     * @return string|void
     */
    public function render()
    {
        //		ob_clean();
        header('Content-Type: application/json;charset=UTF-8');
        echo parent::render();
        exit;
    }


    protected function buildItemList()
    {
    }
}
