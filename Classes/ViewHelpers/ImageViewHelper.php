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
class Tx_Yag_ViewHelpers_ImageViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'img';


    /**
     * @var Tx_Yag_Domain_Repository_ItemRepository
     */
    protected $itemRepository;



    /**
     * @param Tx_Yag_Domain_Repository_ItemRepository $itemRepository
     */
    public function injectItemRepository(Tx_Yag_Domain_Repository_ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }


    /**
     * Initialize arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('alt', 'string', 'Specifies an alternate text for an image', false);
        $this->registerArgument('centerVertical', 'integer', 'Height of the outer box to center the image vertically', false);
        $this->registerArgument('resolutionName', 'string', 'An optional resolution name', false);
        $this->registerArgument('width', 'integer', 'An optional with of the rendered image', false);
        $this->registerArgument('height', 'integer', 'An optional height of the image', false);
        $this->registerArgument('quality', 'integer', 'An optional quality of the image', false, 80);
    }


    /**
     * Render the image
     * 
     * @param Tx_Yag_Domain_Model_Item $item
     * @return string
     * @throws Tx_Fluid_Core_ViewHelper_Exception
     */
    public function render(Tx_Yag_Domain_Model_Item $item = null)
    {
        if (!($item instanceof Tx_Yag_Domain_Model_Item)) {
            $item = $this->itemRepository->getSystemImage('imageNotFound');
        }

        $imageResolution = $item->getResolutionByConfig($this->getResolutionConfig());
        
        if (!$this->arguments['alt'] && $item->getTitle()) {
            $this->tag->addAttribute('alt', $item->getTitle());
        }
        
        if (!$this->arguments['title'] && $item->getTitle()) {
            $this->tag->addAttribute('title', $item->getTitle());
        }

        if ($this->hasArgument('centerVertical') && $this->arguments['centerVertical']) {
            $paddingTop = floor(((int) $this->arguments['centerVertical'] - $imageResolution->getHeight()) / 2);
            $this->tag->addAttribute('style', sprintf('margin-top:%dpx;', $paddingTop));
        }

        $imageSource = TYPO3_MODE === 'BE' ? '../' . $imageResolution->getPath() : $GLOBALS['TSFE']->absRefPrefix . $imageResolution->getPath();
        
        $this->tag->addAttribute('src', $imageSource);
        $this->tag->addAttribute('width', $imageResolution->getWidth());
        $this->tag->addAttribute('height', $imageResolution->getHeight());

        return $this->tag->render();
    }

    /**
     * @return null|Tx_Yag_Domain_Configuration_Image_ResolutionConfig
     */
    protected function getResolutionConfig()
    {
        if ($this->hasArgument('resolutionName')) {
            $resolutionConfig = $this->resolutionConfigCollection = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()
                ->buildThemeConfiguration()
                ->getResolutionConfigCollection()
                ->getResolutionConfig(trim($this->arguments['resolutionName']));
        } elseif ($this->hasArgument('width') || $this->hasArgument('height')) {
            $resolutionSettings = array(
                'width' => $this->arguments['width'],
                'height' => $this->arguments['height'],
                'quality' => $this->arguments['quality'],
                'name' => implode('_', array('custom', $this->arguments['width'], $this->arguments['height'], $this->arguments['quality']))
            );
            $resolutionConfig = new Tx_Yag_Domain_Configuration_Image_ResolutionConfig(Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance(), $resolutionSettings);
        } else {
            $resolutionConfig = null;
        }

        return $resolutionConfig;
    }

    protected function hasArgument($argumentName)
    {
        return isset($this->arguments[$argumentName]);
    }
}
