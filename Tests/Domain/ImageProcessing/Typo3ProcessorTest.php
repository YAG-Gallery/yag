<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Class implements tests for image processor
 *
 * @package Tests
 * @subpackage Domain/ImageProcessing
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Tests_Domain_ImageProcessing_Typo3ProcessorTest extends Tx_Yag_Tests_BaseTestCase {

	/**
	 * @var path to the testImage
	 */
	protected $testImagePath;


	public function setUp() {
		$this->testImagePath = t3lib_extMgm::extPath($this->extensionName) . 'Tests/TestImages/';
		$this->initConfigurationBuilderMock();
	}


	/**
	 * @test
	 */
	public function classExists() {
		$this->isTrue(class_exists('Tx_Yag_Domain_ImageProcessing_Typo3Processor'));
	}



	/**
	 * @test
	 */
	public function createImageResolution() {

		$testImage = $this->testImagePath . 'test_testImage_200.jpg';

		if(file_exists($testImage)) unlink($testImage);

		$resolutionSettings = array(
			'name' => 'medium',
			'maxW' => 200,
			'maxH' => 200,
		);

		$resolutionConfig = new Tx_Yag_Domain_Configuration_Image_ResolutionConfig($this->configurationBuilder, $resolutionSettings);
		$item = $this->getTestItemObject();
		$resolutionFileCacheObject = new Tx_Yag_Domain_Model_ResolutionFileCache($item);
		
		$typo3Processor = $this->getTypo3ProcessorMock($testImage);
		$typo3Processor->_callRef('processFile', $resolutionConfig, $item, $resolutionFileCacheObject);

		$referenceImage = t3lib_extMgm::extPath($this->extensionName) . 'Tests/TestImages/ref_testImage_200.jpg';

		$this->assertTrue(file_exists($testImage), 'No Image was created in Path ' . $testImage);

		echo '
			<img src="../'. str_replace(PATH_site, '', $testImage) .'" />
			<img src="../'. str_replace(PATH_site, '', $referenceImage) .'" />
		';
	}



	/**
	 * @test
	 */
	public function createImageWithWatermark() {

		$testImage = $this->testImagePath . 'test_testImage_200_watermark.jpg';

		if(file_exists($testImage)) unlink($testImage);

		$resolutionTs = '
			medium = GIFBUILDER
			medium {
			  // w & h aus gifBuilderObj 10 auslesen
			  XY = [10.w],[10.h]

			  format = jpg
			  quality = 86

			  10 = IMAGE
			  10 {
				 file.maxH = 200
				 file.maxW = 200
				 file.import.field = yagImage
			  }

			  //Wasserzeichendatei einbinden

			  20 = IMAGE
			  20 {
				 file = EXT:yag/Tests/TestImages/watermark.png

				 // zentrieren des Wasserzeichen (im Beispiel watermark.png= 50x50 Pixel)
				 offset = [10.w]/2-25,[10.h]/2-25
			  }

			}
		';

		$tsParser  = t3lib_div::makeInstance('t3lib_TSparser'); /** @var $tsParser  t3lib_TSparser */
		$tsParser->parse($resolutionTs);
		$tsArray = $tsParser->setup;
		
		$resolutionSettings = t3lib_div::makeInstance('Tx_Extbase_Service_TypoScriptService')->convertTypoScriptArrayToPlainArray($tsArray);
		$resolutionSettings = $resolutionSettings['medium'];
		$resolutionSettings['name'] = 'medium';

		$resolutionConfig = new Tx_Yag_Domain_Configuration_Image_ResolutionConfig($this->configurationBuilder, $resolutionSettings);
		$item = $this->getTestItemObject();
		$resolutionFileCacheObject = new Tx_Yag_Domain_Model_ResolutionFileCache($item);

		$typo3Processor = $this->getTypo3ProcessorMock($testImage);
		$typo3Processor->_callRef('processFile', $resolutionConfig, $item, $resolutionFileCacheObject);

		$referenceImage = t3lib_extMgm::extPath($this->extensionName) . 'Tests/TestImages/ref_testImage_200_watermark.jpg';

		echo '
			<img src="../'. str_replace(PATH_site, '', $testImage) .'" title="Test Image"/>
			<img src="../'. str_replace(PATH_site, '', $referenceImage) .'" title="Reference Image"/>
		';

		$this->assertTrue(file_exists($testImage) && is_file($testImage), 'No Image was created in Path ' . $testImage);
	}


	/**
	 * @return Tx_Yag_Domain_ImageProcessing_Typo3Processor
	 */
	protected function getTypo3ProcessorMock($testImageName = 'test.jpg') {

		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$configurationManager = $objectManager->get('Tx_Extbase_Configuration_ConfigurationManagerInterface');
		$contentObject = isset($this->cObj) ? $this->cObj : t3lib_div::makeInstance('tslib_cObj');
		$configurationManager->setContentObject($contentObject);

		$accessibleProcessorClassName = $this->buildAccessibleProxy('Tx_Yag_Domain_ImageProcessing_Typo3Processor');

		$accessibleProcessor = $this->getMock($accessibleProcessorClassName, array('generateAbsoluteResolutionPathAndFilename')); /** @var $accessibleProcessor Tx_Yag_Domain_ImageProcessing_Typo3Processor  */
		$accessibleProcessor->_injectProcessorConfiguration($this->configurationBuilder->buildImageProcessorConfiguration());
		$accessibleProcessor->injectConfigurationManager($configurationManager);
		$accessibleProcessor->expects($this->once())
			->method('generateAbsoluteResolutionPathAndFilename')
			->will($this->returnValue($testImageName));

		return $accessibleProcessor;
	}
}
?>