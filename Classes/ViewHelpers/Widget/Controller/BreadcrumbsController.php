<?php
/***************************************************************
 * Copyright notice
 *
 *   2010 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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

namespace DL\Yag\ViewHelpers\Widget\Controller;

/**
 *
 * @package    ViewHelpers
 * @subpackage Widget\Controller
 * @author     Daniel Lienert <typo3@lienert.cc>
 * @author     Michael Knoll <mimi@kaktusteam.de>
 */
class BreadcrumbsController extends AbstractWidgetController {
    /**
     * Tis array converts a controller_action to a generic controller_action.
     * E.g. (gallery_index, gallery_showsingle, ...) all show a list of albums abd are therefore
     * mapped to gallery_index. With this only a ptah of unique second parameters are rendered.
     *
     * @var array
     */
    protected $breadCrumbsDefinition = array(
        'gallery_list'       => 'gallery_list',
        'gallery_index'      => 'gallery_index',
        'gallery_showsingle' => 'gallery_index',
        'album_list'         => 'gallery_index',
        'album_showsingle'   => 'itemlist_list',
        'itemlist_list'      => 'itemlist_list',
        'item_show'          => 'item_show'
    );


    /**
     * @return void
     */
    public function indexAction() {
        $defaultPluginControllerAction = $this->yagContext->getPluginModeIdentifier();
        $currentControllerAction       = strtolower( $this->yagContext->getControllerContext()->getRequest()->getControllerName() . '_' . $this->yagContext->getControllerContext()->getRequest()->getControllerActionName() );
        $breadCrumbViewArray           = $this->buildBreadsCrumbViewArray( $defaultPluginControllerAction, $currentControllerAction );

        if ( array_key_exists( 'gallery_list', $breadCrumbViewArray ) ) {
            $this->view->assign( 'galleryList', true );
        }
        if ( array_key_exists( 'album_list', $breadCrumbViewArray ) ) {
            $this->view->assign( 'albumList', true );
        }
        if ( array_key_exists( 'gallery_index', $breadCrumbViewArray ) ) {
            $this->assignCurrentGalleryToView();
        }
        if ( array_key_exists( 'itemlist_list', $breadCrumbViewArray ) ) {
            $this->assignCurrentAlbumToView();
        }
        if ( array_key_exists( 'item_show', $breadCrumbViewArray ) ) {
            $this->assignCurrentItemToView();
        }

        $this->view->assign( 'feUser', $this->feUser );
    }


    /**
     * Build an array of breadCrumbIdentifier on startControllerAction and endControllerAction
     *
     * @param string $defaultPluginControllerAction
     * @param string $currentControllerAction
     *
     * @return array
     */
    protected function buildBreadsCrumbViewArray( $defaultPluginControllerAction, $currentControllerAction ) {
        $breadCrumbIdentifierArray      = $this->getBreadCrumbIdentifierArray();
        $breadCrumbsDefinitionKey2Index = array_flip( array_keys( $breadCrumbIdentifierArray ) );
        $defaultPluginControllerAction  = strtolower( $defaultPluginControllerAction );
        $currentControllerAction        = strtolower( $currentControllerAction );

        $startIndex  = $breadCrumbsDefinitionKey2Index[ $this->breadCrumbsDefinition[ $defaultPluginControllerAction ] ];
        $endIndex    = $breadCrumbsDefinitionKey2Index[ $this->breadCrumbsDefinition[ $currentControllerAction ] ];
        $arrayLength = $endIndex - $startIndex;

        $breadCrumbViewArray = array_slice( $breadCrumbIdentifierArray, $startIndex, $arrayLength + 1 );
        $breadCrumbViewArray = array_flip( $breadCrumbViewArray );

        return $breadCrumbViewArray;
    }


    /**
     * Build an array with unique breadcrumbIdentifiers
     * @return array
     */
    protected function getBreadCrumbIdentifierArray() {
        $uniqueIdentifier = array_unique( array_values( $this->breadCrumbsDefinition ) );

        return array_combine( $uniqueIdentifier, $uniqueIdentifier );
    }

    /**
     * Assigns currently selected gallery to view
     */
    protected function assignCurrentGalleryToView() {
        $this->view->assign( 'gallery', $this->yagContext->getGallery() );
    }

    /**
     * Assigns currently selected album to view
     */
    protected function assignCurrentAlbumToView() {
        $this->view->assign( 'album', $this->yagContext->getAlbum() );
    }

    /**
     * Assigns currently selected item to view
     */
    protected function assignCurrentItemToView() {
        $item = $this->yagContext->getItemlistContext()->getListData()->getFirstRow()->getCell( 'image' )->getValue();
        $this->view->assign( 'item', $item );
    }
}
