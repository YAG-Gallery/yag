<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Class provides image viewHelper
 * 
 * @author Daniel Lienert <typo3@lienert.cc>
 * @package ViewHelpers
 */
class Tx_Yag_ViewHelpers_OffPageItemListViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
     */
    protected $configurationBuilder;

    /**
     * Initialize arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('type', 'string', 'Should either be pre or post', true);
    }



    public function initialize()
    {
        parent::initialize();
        $this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance();
    }



    /**
     * @return string
     */
    public function render()
    {
        $listData = $this->buildListData();

        $this->preloadResolutionCache($listData);

        $content = '';

        foreach ($listData as $listRow) { /** @var Tx_PtExtlist_Domain_Model_List_Row $listRow */
            
            $this->templateVariableContainer->add('image', $listRow['image']->getValue());
            $this->templateVariableContainer->add('listRow', $listRow);
            $content .= $this->renderChildren();
            $this->templateVariableContainer->remove('image');
            $this->templateVariableContainer->remove('listRow');
        }

        return $content;
    }


    /**
     * @throws Exception
     * @return Tx_PtExtlist_Domain_Model_List_ListData
     */
    protected function buildListData()
    {
        $type = strtolower($this->arguments['type']);
        if ($type != 'pre' && $type != 'post') {
            throw new Exception('The Type should either be pre or post', 1320933448);
        }

        $yagContext = Tx_Yag_Domain_Context_YagContextFactory::getInstance();
        $itemList = $yagContext->getItemlistContext();

        $dataBackend = $itemList->getDataBackend(); /** @var Tx_Yag_Extlist_DataBackend_YagDataBackend $dataBackend */

        if ($type == 'pre') {
            return $dataBackend->getPrePageListData();
        } else {
            return $dataBackend->getPostPageListData();
        }
    }


    /**
     * @param $listData
     */
    protected function preloadResolutionCache($listData)
    {
        Tx_Yag_Domain_FileSystem_ResolutionFileCacheFactory::getInstance()->preloadCacheForItemsAndTheme(
            $listData,
            $this->configurationBuilder->buildThemeConfiguration()
        );
    }
}
