<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder;

	/**
	 * @var path to the testImage
	 */
	protected $testImagePath;


	public function setUp() {
		$tsFilePath = t3lib_extMgm::extPath($this->extensionName) . 'Configuration/TypoScript/setup.txt';
		$typoscript = Tx_PtExtbase_Div::loadTypoScriptFromFile($tsFilePath);
		$settings = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($typoscript);

		Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::injectSettings($settings['plugin']['tx_yag']['settings']);
		$this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance('test', 'backend');

		$this->testImagePath = t3lib_extMgm::extPath($this->extensionName) . 'Tests/TestImages/testImage_test.jpg';
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

		$resolutionSettings = array(
			'name' => 'medium',
			'maxW' => 200,
			'maxH' => 200,
		);

		$resolutionConfig = new Tx_Yag_Domain_Configuration_Image_ResolutionConfig($this->configurationBuilder, $resolutionSettings);
		$item = $this->getTestItemObject();
		$resolutionFileCacheObject = new Tx_Yag_Domain_Model_ResolutionFileCache($item);
		
		$typo3Processor = $this->getTypo3ProcessorMock();
		$typo3Processor->_callRef('processFile', $resolutionConfig, $item, $resolutionFileCacheObject);

		$referenceImage = t3lib_extMgm::extPath($this->extensionName) . 'Tests/TestImages/ref_testImage_200.jpg';

		$this->assertTrue(file_exists($this->testImagePath), 'No Image was created in Path ' . $this->testImagePath);
		$this->assertEquals(md5_file($this->testImagePath), md5_file($referenceImage), 'The generated file md5 is not like the reference file');

		echo '
			<img src="../'. str_replace(PATH_site, '', $this->testImagePath) .'" />
			<img src="../'. str_replace(PATH_site, '', $referenceImage) .'" />
		';
	}



	/**
	 * @test
	 */
	public function createImageWithWatermark() {

		$resolutionSettings = array(
			'name' => 'medium',
			'maxW' => 200,
			'maxH' => 200,
			'_typoScriptNodeValue' => 'IMAGE'
		);

		$resolutionConfig = new Tx_Yag_Domain_Configuration_Image_ResolutionConfig($this->configurationBuilder, $resolutionSettings);


	}


	/**
	 * @return Tx_Yag_Domain_ImageProcessing_Typo3Processor
	 */
	protected function getTypo3ProcessorMock() {

		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$configurationManager = $objectManager->get('Tx_Extbase_Configuration_ConfigurationManagerInterface');
		$contentObject = isset($this->cObj) ? $this->cObj : t3lib_div::makeInstance('tslib_cObj');
		$configurationManager->setContentObject($contentObject);

		$accessibleProcessorClassName = $this->buildAccessibleProxy('Tx_Yag_Domain_ImageProcessing_Typo3Processor');

		$accessibleProcessor = $this->getMock($accessibleProcessorClassName, array('generateAbsoluteResolutionPathAndFilename'), array($this->configurationBuilder->buildImageProcessorConfiguration())); /** @var $accessibleProcessor Tx_Yag_Domain_ImageProcessing_Typo3Processor  */
		$accessibleProcessor->injectConfigurationManager($configurationManager);

		$accessibleProcessor->expects($this->once())
			->method('generateAbsoluteResolutionPathAndFilename')
			->will($this->returnValue($this->testImagePath));

		return $accessibleProcessor;
	}
}
?>