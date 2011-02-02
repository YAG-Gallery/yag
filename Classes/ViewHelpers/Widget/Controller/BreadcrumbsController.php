<?php
/***************************************************************
* Copyright notice
*
*   2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
* All rights reserved
*
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* 
* @package Domain
* @subpackage ViewHelpers
* @author Daniel Lienert <daniel@lienert.cc>
* @author Michael Knoll <mimi@kaktusteam.de>
*/

class Tx_Yag_ViewHelpers_Widget_Controller_BreadcrumbsController extends Tx_Fluid_Core_Widget_AbstractWidgetController {
	
	/**
	 * Holds an instance of gallery context
	 *
	 * @var Tx_Yag_Domain_YagContext
	 */
	protected $yagContext;
	
	
	/**
	 * @return void
	 */
	public function initializeAction() {
		$this->yagContext = Tx_Yag_Domain_YagContext::getInstance(Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance());
	}
	
	
	/**
	 * @return void
	 */
	public function indexAction() {

    	// TODO use cobj functionality to render breadcrumbs here!
    	switch ($this->yagContext->getRequest()->getControllerName()) {
    		
    		case 'Item' :
                $this->assignCurrentAlbumToView();
                $this->assignCurrentGalleryToView();
                $this->assignCurrentItemToView();    			
    			break;
    			
    		case 'ItemList' :
    			$this->assignCurrentGalleryToView();
    			$this->assignCurrentAlbumToView();
    	        break;     
    		
    		case 'Gallery' :
    			if ($this->yagContext->getGpVarActionName() == 'index') {
    		        $this->assignCurrentGalleryToView();
    			}
        		break;
    	}
    	
    	$this->view->assign('feUser', $this->feUser);	
	}
	
	
    /**
     * Assigns currently selected album to view
     */
    protected function assignCurrentAlbumToView() {
        $this->view->assign('album', $this->yagContext->getSelectedAlbum());
    }
    
    
    
    /**
     * Assigns currently selected gallery to view
     */
    protected function assignCurrentGalleryToView() {
        $this->view->assign('gallery', $this->yagContext->getSelectedGallery());
    }
    
    
    
    /**
     * Assigns currently selected item to view
     */
    protected function assignCurrentItemToView() {
    	$item = $this->yagContext->getItemlistContext()->getListData()->getFirstRow()->getCell('image')->getValue();
    	$this->view->assign('item', $item);
    }
	
}
?>