<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2013 Sebastian Helzle <sebastian@helzle.net>
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
 * Class 
 * 
 * @author Daniel Lienert <typo3@lienert.cc>
 * @author Sebastian Helzle <sebastian@helzle.net>
 * @package ViewHelpers
 */
class Tx_Yag_ViewHelpers_Javascript_ItemListJsonViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
     */
    protected $configurationBuilder;

    /**
     * @var array
     */
    protected $resolutions;


    /**
     * @var Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection
     */
    protected $resolutionConfigCollection;


    /**
     * @var Tx_Yag_Domain_FileSystem_Div
     */
    protected $fileSystemDiv;


    /**
     * @param Tx_Yag_Domain_FileSystem_Div $fileSystemDiv
     */
    public function injectFileSystemDiv(Tx_Yag_Domain_FileSystem_Div $fileSystemDiv)
    {
        $this->fileSystemDiv = $fileSystemDiv;
    }


    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('resolutions', 'string', 'Comma separated list of resolution identifiers', false, '');
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Classes/Core/ViewHelper/Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper::initialize()
     */
    public function initialize()
    {
        parent::initialize();
        $this->configurationBuilder =  Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance();

        $this->resolutionConfigCollection = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()
            ->buildThemeConfiguration()
            ->getResolutionConfigCollection();


        if ($this->arguments['resolutions']) {
            $this->resolutions = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->arguments['resolutions']);
        } else {
            foreach ($this->resolutionConfigCollection as $identifier => $config) {
                $this->resolutions[] = $identifier;
            }
        }
    }


    /**
     * Renders image tags
     *
     * @param Tx_PtExtlist_Domain_Model_List_ListData $listData
     * @return string
     */
    public function render(Tx_PtExtlist_Domain_Model_List_ListData $listData)
    {
        $listDataArray = array();

        foreach ($listData as $row) {
            $image = $row->getCell('image')->getValue(); /** @var Tx_YAG_Domain_Model_Item $image  */

            $itemMetaData = array(
                'title' => $image->getTitle(),
                'description' => $image->getDescription(),
                'href' => $image->getHref(),
                'hrefTarget' => $image->getHrefTarget(),
                'tags' => $image->getTagsSeparated()
            );

            $imageMeta = $image->getItemMeta();

            if ($imageMeta instanceof Tx_Yag_Domain_Model_ItemMeta) {
                $itemMetaData['gpsLatitude'] = $imageMeta->getGpsLatitude();
                $itemMetaData['gpsLongitude'] = $imageMeta->getGpsLongitude();
            }

            foreach ($this->resolutions as $resolutionIdentifier) {
                $resolutionConfig = $image->getResolutionByConfig($this->resolutionConfigCollection->getResolutionConfig($resolutionIdentifier));

                $itemMetaData[$resolutionIdentifier] = $resolutionConfig->getPath();
                $itemMetaData[$resolutionIdentifier . 'Width'] = $resolutionConfig->getWidth();
                $itemMetaData[$resolutionIdentifier . 'Height'] = $resolutionConfig->getHeight();
            }

            $listDataArray[]= $itemMetaData;
        }

        return json_encode($listDataArray);
    }
}
