<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de
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
 * Class definition file for a GalleryController testcase.
 * 
 * @version $Id:$
 */



/**
 * Class implements a testcase for a GalleryController
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-01-01
 * @package Typo3
 * @subpackage yag
 */
/**
 * Testcase for the OrganizationController class
 */
class Tx_Yag_Tests_Controller_testcase extends Tx_Extbase_BaseTestCase {
    
    /**
     * @test
     */
    public function indexActionWorks() {
        $mockGalleryRepository = $this->getMock('Tx_Yag_Domain_Repository_GalleryRepository', array('findByPageId'), array(), '', FALSE, FALSE, FALSE);       
        $mockGalleryRepository->expects($this->once())
            ->method('findByPageId')
            ->will($this->returnValue(array('gallery1','gallery2')));

        $mockView = $this->getMock('Tx_Fluid_Core_View_TemplateView', array('assign'), array(), '', FALSE);
        $mockView->expects($this->once())
            ->method('assign')
            ->with('galleries', array('gallery1', 'gallery2'));

        $mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('dummy'),array(), '', FALSE);
        $mockController->_set('galleryRepository', $mockGalleryRepository);
        $mockController->_set('view', $mockView);
        $mockController->indexAction();
    }   
    
    
    
    /**
     * @test
     */
    public function showActionWorks() {
    	$mockGallery = $this->getMock('Tx_Yag_Domain_Model_Gallery', array(), array(), '', FALSE);
    	
    	// Dirty trick, as object is cloned when passed to view via assign. So make
    	// compared object cloned to in order to make assertion working.
    	$clonedMockGallery = clone $mockGallery;
    	
    	$mockView = $this->getMock('Tx_Fluid_Core_View_TemplateView', array('assign'), array(), '', FALSE);
    	$mockView->expects($this->once())
    	   ->method('assign')
    	   ->with('gallery', $clonedMockGallery);
    	
    	$mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('dummy'),array(), '', FALSE);
    	$mockController->_set('view', $mockView);
    	
    	$mockController->showAction($clonedMockGallery);
    }
    
    
    
    /**
     * @test
     */
    public function editActionWorks() {
    	$mockGallery = $this->getMock('Tx_Yag_Domain_Model_Gallery', array('getAlbums'), array(), '', FALSE);
    	$mockGallery->expects($this->once())
    	   ->method('getAlbums')
    	   ->will($this->returnValue(array('album1', 'album2')));
        
        // Dirty trick, as object is cloned when passed to view via assign. So make
        // compared object cloned to in order to make assertion working.
        $clonedMockGallery = clone $mockGallery;
    	
    	$mockAlbumRepository = $this->getMock('Tx_Yag_Domain_Repository_AlbumRepository', array('findAll'), array(), '', FALSE);
    	$mockAlbumRepository->expects($this->once())
    	   ->method('findAll')
    	   ->will($this->returnValue(array('album1', 'album2')));
        
        $mockView = $this->getMock('Tx_Fluid_Core_View_TemplateView', array('assign'), array(), '', FALSE);
        
        // I'm not really satisfied with this, as it does not matter in which order the functions are called, 
        // as long as they are called... 
        $mockView->expects($this->at(0))
            ->method('assign')
            ->with('availableAlbums', array('album1','album2'));
        $mockView->expects($this->at(1))
            ->method('assign')
            ->with('selectedAlbums', array('album1', 'album2'));
        $mockView->expects($this->at(2))
            ->method('assign')
            ->with('gallery', $clonedMockGallery);
        
        $mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('checkForAdminRights'),array(true), '', FALSE);
        $mockController->_set('view', $mockView);
        $mockController->_set('albumRepository', $mockAlbumRepository);
        
        $mockController->editAction($clonedMockGallery);
    }
    
    
    
    /**
     * @test
     */
    public function updateActionWorks() {
    	$mockGallery = $this->getMock('Tx_Yag_Domain_Model_Gallery', array(), array(), '', FALSE);
        
        // Dirty trick, as object is cloned when passed to view via assign. So make
        // compared object cloned to in order to make assertion working.
        $clonedMockGallery = clone $mockGallery;
        
    	$mockGalleryRepository = $this->getMock('Tx_Yag_Domain_Repository_GalleryRepository', array('update'), array(), '', FALSE, FALSE, FALSE);       
        $mockGalleryRepository->expects($this->once())
            ->method('update')
            ->with($clonedMockGallery);

        $mockFlashMessages = $this->getMock('Tx_Extbase_MVC_Controller_FlashMessages', array('add'), array(), '', FALSE);
        $mockFlashMessages->expects($this->once())
            ->method('add')
            ->with('Your gallery has been updated!');
            
        $mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('checkForAdminRights', 'redirect'),array(true,true), '', FALSE);
        $mockController->_set('flashMessages', $mockFlashMessages);
        $mockController->_set('galleryRepository', $mockGalleryRepository);
        $mockController->expects($this->once())
            ->method('redirect')
            ->with('show', NULL, NULL, array('gallery' => $mockGallery));
            
        $mockController->updateAction($mockGallery);
        
    }
    
    
    
    /**
     * @test
     */
    public function deleteActionWorks() {
    	$mockGallery = $this->getMock('Tx_Yag_Domain_Model_Gallery', array(), array(), '', FALSE);
        
        // Dirty trick, as object is cloned when passed to view via assign. So make
        // compared object cloned to in order to make assertion working.
        $clonedMockGallery = clone $mockGallery;
        
    	$mockRequest = $this->getMock('Tx_Extbase_MVC_Request', array('hasArgument'), array(), '', FALSE);
    	$mockRequest->expects($this->once())
    	   ->method('hasArgument')
    	   ->will($this->returnValue(false));
    	
        $mockView = $this->getMock('Tx_Fluid_Core_View_TemplateView', array('assign'), array(), '', FALSE);
        $mockView->expects($this->once())
           ->method('assign')
           ->with('gallery', $clonedMockGallery);
    	
    	$mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('checkForAdminRights', 'redirect'),array(true,true), '', FALSE);
        $mockController->_set('request', $mockRequest);
        $mockController->_set('view', $mockView);
        
        $mockController->deleteAction($mockGallery);
    }
    
    
    
    /**
     * @test
     */
    public function reallyDeleteActionWorks() {
    	$mockGallery = $this->getMock('Tx_Yag_Domain_Model_Gallery', array(), array(), '', FALSE);
        
        // Dirty trick, as object is cloned when passed to view via assign. So make
        // compared object cloned to in order to make assertion working.
        $clonedMockGallery = clone $mockGallery;
        
        $mockGalleryRepository = $this->getMock('Tx_Yag_Domain_Repository_GalleryRepository', array('remove'), array(), '', FALSE, FALSE, FALSE);       
        $mockGalleryRepository->expects($this->once())
            ->method('remove')
            ->with($clonedMockGallery);
        
        $mockRequest = $this->getMock('Tx_Extbase_MVC_Request', array('hasArgument'), array(), '', FALSE);
        $mockRequest->expects($this->once())
           ->method('hasArgument')
           ->will($this->returnValue(true));
        
        $mockView = $this->getMock('Tx_Fluid_Core_View_TemplateView', array('assign'), array(), '', FALSE);
        $mockView->expects($this->once())
           ->method('assign')
           ->with('deleted', 1);
        
        $mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('checkForAdminRights', 'redirect'),array(true,true), '', FALSE);
        $mockController->_set('request', $mockRequest);
        $mockController->_set('view', $mockView);
        $mockController->_set('galleryRepository', $mockGalleryRepository);
        
        $mockController->deleteAction($mockGallery);
    }
    
    
    
    /**
     * @test
     */
    public function newActionWorks() {
    	$mockGallery = $this->getMock('Tx_Yag_Domain_Model_Gallery', array(), array(), '', FALSE);
        
        // Dirty trick, as object is cloned when passed to view via assign. So make
        // compared object cloned to in order to make assertion working.
        $clonedMockGallery = clone $mockGallery;
        
        $mockView = $this->getMock('Tx_Fluid_Core_View_TemplateView', array('assign'), array(), '', FALSE);
        $mockView->expects($this->once())
           ->method('assign')
           ->with('newGallery', $clonedMockGallery);
           
        $mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('checkForAdminRights', 'redirect'),array(true,true), '', FALSE);
        $mockController->_set('view', $mockView);
        
        $mockController->newAction($clonedMockGallery);
    }
    
    
    
    /**
     * @test
     */
    public function createActionWorks() {
    	$mockGallery = $this->getMock('Tx_Yag_Domain_Model_Gallery', array(), array(), '', FALSE);
        
        // Dirty trick, as object is cloned when passed to view via assign. So make
        // compared object cloned to in order to make assertion working.
        $clonedMockGallery = clone $mockGallery;
        
        $mockGalleryRepository = $this->getMock('Tx_Yag_Domain_Repository_GalleryRepository', array('add'), array(), '', FALSE, FALSE, FALSE);       
        $mockGalleryRepository->expects($this->once())
            ->method('add')
            ->with($clonedMockGallery);

        $mockFlashMessages = $this->getMock('Tx_Extbase_MVC_Controller_FlashMessages', array('add'), array(), '', FALSE);
        $mockFlashMessages->expects($this->once())
            ->method('add')
            ->with('Your new gallery was created.');
            
        $mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('checkForAdminRights', 'redirect'),array(true,true), '', FALSE);
        $mockController->_set('flashMessages', $mockFlashMessages);
        $mockController->_set('galleryRepository', $mockGalleryRepository);
        $mockController->expects($this->once())
            ->method('redirect')
            ->with('index');
            
        $mockController->createAction($clonedMockGallery);
    }
    
    
    
    /**
     * @test
     */
    public function removeAlbumActionWorks() {
    	$mockGallery = $this->getMock('Tx_Yag_Domain_Model_Gallery', array(), array(), '', FALSE);
        // Dirty trick, as object is cloned when passed to view via assign. So make
        // compared object cloned to in order to make assertion working.
        $clonedMockGallery = clone $mockGallery;
        
        $mockAlbum = $this->getMock('Tx_Yag_Domain_Model_Album', array(), array(), '', FALSE);
        $clonedMockAlbum = clone $mockAlbum;
        
        $mockRequest = $this->getMock('Tx_Extbase_MVC_Request', array('hasArgument'), array(), '', FALSE);
        $mockRequest->expects($this->once())
            ->method('hasArgument')
            ->will($this->returnValue(false));
        
        $mockView = $this->getMock('Tx_Fluid_Core_View_TemplateView', array('assign'), array(), '', FALSE);
        $mockView->expects($this->at(0))
            ->method('assign')
            ->with('gallery', $clonedMockGallery);
        $mockView->expects($this->at(1))
            ->method('assign')
            ->with('album', $clonedMockAlbum);
        
        $mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('checkForAdminRights', 'redirect'),array(true,true), '', FALSE);
        $mockController->_set('request', $mockRequest);
        $mockController->_set('view', $mockView);
        
        $mockController->removeAlbumAction($mockGallery, $mockAlbum);
    }
    
    
    
    /**
     * @test
     */
    public function reallyRemoveAlbumActionWorks() {
        $mockAlbum = $this->getMock('Tx_Yag_Domain_Model_Album', array(), array(), '', FALSE);
        $clonedMockAlbum = clone $mockAlbum;
        
        $mockGallery = $this->getMock('Tx_Yag_Domain_Model_Gallery', array('removeAlbum'), array(), '', FALSE);
        // Dirty trick, as object is cloned when passed to view via assign. So make
        // compared object cloned to in order to make assertion working.
        $clonedMockGallery = clone $mockGallery;
        $clonedMockGallery->expects($this->once())
            ->method('removeAlbum')
            ->with($clonedMockAlbum);
        
        $mockRequest = $this->getMock('Tx_Extbase_MVC_Request', array('hasArgument'), array(), '', FALSE);
        $mockRequest->expects($this->once())
            ->method('hasArgument')
            ->will($this->returnValue(true));
        
        $mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('checkForAdminRights', 'redirect'),array(true,true), '', FALSE);
        $mockController->_set('request', $mockRequest);
        $mockController->expects($this->once())
            ->method('redirect')
            ->with('edit', NULL, NULL, array('gallery' => $clonedMockGallery));
        
        $mockController->removeAlbumAction($clonedMockGallery, $clonedMockAlbum);
    }
    
    
    
    /**
     * @test
     */
    public function addAlbumActionWorks() {
    	$mockAlbum = $this->getMock('Tx_Yag_Domain_Model_Album', array(), array(), '', FALSE);
        $clonedMockAlbum = clone $mockAlbum;
        
        $mockGallery = $this->getMock('Tx_Yag_Domain_Model_Gallery', array('setAlbumsByAlbumUids'), array(), '', FALSE);
        // Dirty trick, as object is cloned when passed to view via assign. So make
        // compared object cloned to in order to make assertion working.
        $clonedMockGallery = clone $mockGallery;
        $clonedMockGallery->expects($this->once())
            ->method('setAlbumsByAlbumUids')
            ->with(array('1','2','3','4'));
        
        $mockRequest = $this->getMock('Tx_Extbase_MVC_Request', array('hasArgument','getArgument'), array(), '', FALSE);
        $mockRequest->expects($this->once())
            ->method('hasArgument')
            ->will($this->returnValue(true));
        $mockRequest->expects($this->once())
            ->method('getArgument')
            ->will($this->returnValue('1,2,3,4'));
        
        $mockController = $this->getMock($this->buildAccessibleProxy('Tx_Yag_Controller_GalleryController'), array('checkForAdminRights', 'redirect'),array(true,true), '', FALSE);
        $mockController->_set('request', $mockRequest);
        $mockController->expects($this->once())
            ->method('redirect')
            ->with('edit', NULL, NULL, array('gallery' => $clonedMockGallery));
        
        $mockController->addAlbumAction($clonedMockGallery, $clonedMockAlbum);
    }

}

?>
