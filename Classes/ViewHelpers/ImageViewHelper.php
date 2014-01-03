<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * @author Daniel Lienert <daniel@lienert.cc>
 * @package ViewHelpers
 */
class Tx_Yag_ViewHelpers_ImageViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {

	
	/**
	 * @var string
	 */
	protected $tagName = 'img';


	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;


	/**
	 * @param Tx_Extbase_Object_ObjectManager $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		if(method_exists(parent, 'injectObjectManager')) parent::injectObjectManager($objectManager);
			$this->objectManager = $objectManager;
	}


	/**
	 * Initialize arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerUniversalTagAttributes();
		$this->registerTagAttribute('alt', 'string', 'Specifies an alternate text for an image', FALSE);
		$this->registerArgument('centerVertical', 'integer', 'Height of the outer box to center the image vertically', FALSE);
		$this->registerArgument('resolutionName', 'string', 'An optional resolution name', FALSE);
		$this->registerArgument('width', 'integer', 'An optional with of the rendered image', FALSE);
		$this->registerArgument('height', 'integer', 'An optional height of the image', FALSE);
		$this->registerArgument('quality', 'integer', 'An optional quality of the image', FALSE, 80);
	}


	/**
	 * Render the image
	 * 
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @return string
	 * @throws Tx_Fluid_Core_ViewHelper_Exception
	 */
	public function render(Tx_Yag_Domain_Model_Item $item = NULL) {
		
		if(!($item instanceof Tx_Yag_Domain_Model_Item)) {
			$itemRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository');
			$item = $itemRepository->getSystemImage('imageNotFound');	
		}

		$imageResolution = $item->getResolutionByConfig($this->getResolutionConfig());
		
		if(!$this->arguments['alt'] && $item->getTitle()) {
			$this->tag->addAttribute('alt', $item->getTitle());
		}
		
		if (!$this->arguments['title'] && $item->getTitle()) {
			$this->tag->addAttribute('title', $item->getTitle());
		}

		if($this->hasArgument('centerVertical')) {
			$paddingTop = floor(((int) $this->arguments['centerVertical'] - $imageResolution->getHeight()) / 2);
			$this->tag->addAttribute('style', sprintf('margin-top:%dpx;', $paddingTop));
		}

		$imageSource = TYPO3_MODE === 'BE' ? '../' . $imageResolution->getPath() : $GLOBALS['TSFE']->absRefPrefix . $imageResolution->getPath();
		
		$this->tag->addAttribute('src', $imageSource);
		$this->tag->addAttribute('width', $imageResolution->getWidth() . 'px');
		$this->tag->addAttribute('height', $imageResolution->getHeight() . 'px');

		return $this->tag->render();
	}



	/**
	 * @return null|Tx_Yag_Domain_Configuration_Image_ResolutionConfig
	 */
	protected function getResolutionConfig() {

		if(trim($this->hasArgument('resolutionName'))) {
			$resolutionConfig = $this->resolutionConfigCollection = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()
				->buildThemeConfiguration()
				->getResolutionConfigCollection()
				->getResolutionConfig(trim($this->arguments['resolutionName']));
		} elseIf ($this->hasArgument('width') || $this->hasArgument('height')) {
			$resolutionSettings = array(
				'width' => $this->arguments['width'],
				'height' => $this->arguments['height'],
				'quality' => $this->arguments['quality'],
				'name' => implode('_', array('custom', $this->arguments['width'], $this->arguments['height'], $this->arguments['quality']))
			);
			$resolutionConfig = new Tx_Yag_Domain_Configuration_Image_ResolutionConfig(Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance(),$resolutionSettings);
		} else {
			$resolutionConfig = NULL;
		}

		return $resolutionConfig;
	}

}
