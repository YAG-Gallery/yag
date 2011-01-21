<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
*  All rights reserved
*
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
 * Controller for YAG navigation widgets
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Controller_NavigationController extends Tx_Yag_Controller_AbstractController {
    
	/**
	 * Derzeitiges Problem:
	 * 
	 * Die einzelnen Widgets werden im TS-Kontext (standalone template) nicht in der "richtigen" Reihenfolge aufgerufen. Darum
	 * kann es z.B. passieren, dass wir den Gallery Controller aufrufen (per Link bzw. action) und dieser einen Wert im Kontext
	 * der Gallery setzen sollte, davor aber ein anderes Widget bereits ausgeführt wird und dieser Wert fehlt.
	 * 
	 * Lösung des Problems: 
	 * 
	 * Alle Gallery-spezifischen Zustände werden in ein Zustandsobjekt gepackt, das zu Beginn eines jeden
	 * Plugins als Singleton instanziiert wird. Dieser Kontext liest alle Werte aus Session und GET/POST Vars aus und beschreibt
	 * damit den gesamten Zustand der Gallery.
	 * 
	 * Die Filter holen ihre Werte ausschließlich aus diesem Zustand (den sie ebenfalls als Singleton bekommen) und setzen 
	 * keine eigenen Werte mehr aus Parametern etc.
	 */
	
	
	
	/**
	 * Show action
	 * 
	 * @return string Rendered show action
	 */
    public function showAction() {
    	// TODO use cobj functionality to render breadcrumbs here!
    	switch ($this->yagContext->getGpVarControllerName()) {
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
    	$albumUid = $this->yagContext->getItemlistContext()->getDataBackend()->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('albumFilter')->getAlbumUid();
        $album = t3lib_div::makeInstance(Tx_Yag_Domain_Repository_AlbumRepository)->findByUid($albumUid);
        $this->view->assign('album', $album);
    }
    
    
    
    /**
     * Assigns currently selected gallery to view
     */
    protected function assignCurrentGalleryToView() {
        $galleryUid = $this->yagContext->getAlbumListContext()->getDataBackend()->getFilterboxCollection()->getFilterboxByFilterboxIdentifier('internalFilters')->getFilterByFilterIdentifier('galleryFilter')->getGalleryUid();
        $gallery = t3lib_div::makeInstance(Tx_Yag_Domain_Repository_GalleryRepository)->findByUid($galleryUid);
        $this->view->assign('gallery', $gallery);
    }
    
    
    
    /**
     * Assigns currently selected item to view
     */
    protected function assignCurrentItemToView() {
    	// Take a look inside item controller how to get main item
    }
	
}
 
?>