<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Daniel Lienert <lienert@punkt.de>
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

namespace DL\Yag\Extlist\Renderer;

use DL\Yag\Domain\Configuration\ConfigurationBuilder;
use DL\Yag\Domain\Context\YagContextFactory;
use DL\Yag\Domain\Model\Item;
use DL\Yag\Domain\Repository\ItemRepository;

class mageObjectRenderer extends \Tx_PtExtlist_Domain_Renderer_AbstractRenderer {
    /**
     * @var ItemRepository
     */
    protected $itemRepository;

    /**
     * @var ConfigurationBuilder
     */
    protected $yagConfigurationBuilder;


    /**
     * @param ItemRepository $itemRepository
     */
    public function injectItemRepository( ItemRepository $itemRepository ) {
        $this->itemRepository = $itemRepository;
    }


    /**
     * @return void
     */
    public function initRenderer() {
        $this->yagConfigurationBuilder = YagContextFactory::getInstance();
    }


    /**
     * Renders the given list through TypoScript.
     * Also uses the column definitions.
     *
     * @param \Tx_PtExtlist_Domain_Model_List_ListData $listData
     *
     * @return \Tx_PtExtlist_Domain_Model_List_ListData
     */
    public function renderList( \Tx_PtExtlist_Domain_Model_List_ListData $listData ) {
        $itemUIds     = array();
        $indexedArray = array();

        foreach ( $listData as $listRow ) {
            /** @var $listRow \Tx_PtExtlist_Domain_Model_List_Row */
            $itemUIds[]                                                 = $listRow->getCell( 'itemUid' )->getValue();
            $indexedArray[ $listRow->getCell( 'itemUid' )->getValue() ] = $listRow;
        }

        $renderedListData = new \Tx_PtExtlist_Domain_Model_List_ListData();

        if ( ! empty( $itemUIds ) ) {
            $items = $this->itemRepository->getItemsByUids( $itemUIds );

            foreach ( $items as $item ) {
                if ( $item instanceof Item ) {
                    $itemUid = $item->getUid();
                    if ( array_key_exists( $itemUid, $indexedArray ) ) {
                        $indexedArray[ $itemUid ]->addCell( new \Tx_PtExtlist_Domain_Model_List_Cell( $item ), 'image' );
                    }
                    $renderedListData->addItem( $indexedArray[ $itemUid ] );
                }
            }
        }

        return $renderedListData;
    }
}
