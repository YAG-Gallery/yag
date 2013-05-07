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
	 * Initialize arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
		$this->registerTagAttribute('alt', 'string', 'Specifies an alternate text for an image', FALSE);
	}


	/**
	 * Render the image
	 * 
	 * @param Tx_Yag_Domain_Model_Item $item
	 * @param string $resolutionName
	 * @param int $width width in px
	 * @param int $height height in px
	 * @param int $quality jpeg quality in percent
	 * @return string
	 * @throws Tx_Fluid_Core_ViewHelper_Exception
	 */
	public function render(Tx_Yag_Domain_Model_Item $item = NULL, $resolutionName = NULL, $width = NULL, $height = NULL, $quality = NULL) {
		
		if(get_class($item) != 'Tx_Yag_Domain_Model_Item') {
			$itemRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_ItemRepository');
			$item = $itemRepository->getSystemImage('imageNotFound');	
		}

		if($resolutionName) {
			$resolutionConfig = $this->resolutionConfigCollection = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()
													->buildThemeConfiguration()
													->getResolutionConfigCollection()
					  								->getResolutionConfig($resolutionName);
		} elseIf ($width || $height) {
			$resolutionSettings = array(
				'width' => $width,
				'height' => $height,
				'quality' => $quality,
				'name' => implode('_', array('custom', $width, $height, $quality))
			);
			$resolutionConfig = new Tx_Yag_Domain_Configuration_Image_ResolutionConfig(Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance(),$resolutionSettings);
		} else {
			$resolutionConfig = NULL;
		}
		
		$imageResolution = $item->getResolutionByConfig($resolutionConfig);
		
		if(!$this->arguments['alt']) {
			$this->tag->addAttribute('alt', $item->getTitle());
		}
		
		if (!$this->arguments['title']) {
			$this->tag->addAttribute('title', $item->getTitle());
		}

		$imageSource = TYPO3_MODE === 'BE' ? '../' . $imageResolution->getPath() : $GLOBALS['TSFE']->absRefPrefix . $imageResolution->getPath();
		
		$this->tag->addAttribute('src', $imageSource);
		$this->tag->addAttribute('width', $imageResolution->getWidth());
		$this->tag->addAttribute('height', $imageResolution->getHeight());

		return $this->tag->render();
	}	
}
