<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <knoll@punkt.de>
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
	 * @var Tx_Yag_Domain_Configuration_Image_ResolutionConfigCollection
	 */
	protected $resolutionConfigCollection;
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Core/ViewHelper/Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper::initialize()
	 */
	public function initialize() {
		parent::initialize();
		
		$this->resolutionConfigCollection = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()
													->buildThemeConfiguration()
													->getResolutionConfig();
	}
	
	
	/**
	 * Initialize arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
		//$this->registerTagAttribute('alt', 'string', 'Specifies an alternate text for an image', TRUE);
	}


	/**
	 * Render the image
	 * 
	 * @param mixed $item
	 * @param string $resolutionName
	 * @param int $width width in px
	 * @param int $height height in px
	 * @param int $quality jpeg quality in percent
	 * @throws Tx_Fluid_Core_ViewHelper_Exception
	 */
	public function render($item, $resolutionName = NULL, $width = NULL, $height = NULL, $quality = NULL) {
		
		if(get_class($item) != 'Tx_Yag_Domain_Model_Item') return;
		
		if($resolutionName) {
			$resolutionConfig = $this->resolutionConfigCollection->getResolutionConfig($resolutionName);
		} elseIf ($width || $height) {
			$resolutionSettings = array(
				'width' => $width,
				'height' => $height,
				'quality' => $quality
			);
			$resolutionConfig = new Tx_Yag_Domain_Configuration_Image_ResolutionConfig(Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance(),$resolutionSettings);
		} else {
			$resolutionConfig = NULL;
		}
		
		$imageResolution = $item->getResolutionByConfig($resolutionConfig);

		// TODO: implement manual setting of resolution
		$this->tag->addAttribute('src', $imageResolution->getPath());
		$this->tag->addAttribute('width', $imageResolution->getWidth());
		$this->tag->addAttribute('height', $imageResolution->getHeight());
		
		if(!$this->arguments['alt']) {
			$this->tag->addAttribute('alt', $item->getTitle());
		}
		
		if (!$this->arguments['title']) {
			$this->tag->addAttribute('title', $item->getTitle());
		}

		return $this->tag->render();
	}
}