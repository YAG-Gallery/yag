<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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

namespace DL\Yag\Tests\Unit\Domain\ImageProcessing;

use DL\Yag\Domain\Configuration\Image\ResolutionConfig;
use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Domain\ImageProcessing\Typo3Processor;
use DL\Yag\Domain\Model\ResolutionFileCache;
use DL\Yag\Tests\Unit\BaseTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class implements tests for image processor
 *
 * @package Tests
 * @subpackage Domain/ImageProcessing
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class Typo3ProcessorTest extends BaseTestCase
{
    /**
     * @var path to the testImage
     */
    protected $testImagePath;


    public function setUp()
    {
        parent::setUp();

        $this->testImagePath = $this->sourceDirectory . 'Tests/Unit/TestImages/';
        $this->initConfigurationBuilderMock();
    }


    /**
     * @test
     */
    public function classExists()
    {
        $this->isTrue(class_exists('DL\\Yag\\Domain\\ImageProcessing\\Typo3Processor'));
    }



    /**
     * @test
     */
    public function createImageResolution()
    {
        $testImage = $this->testImagePath . 'test_testImage_200.jpg';

        if (file_exists($testImage)) {
            unlink($testImage);
        }

        $resolutionSettings = array(
            'name' => 'medium',
            'maxW' => 200,
            'maxH' => 200,
        );

        $resolutionConfig = new ResolutionConfig($this->configurationBuilder, $resolutionSettings);
        $item = $this->getTestItemObject();
        $resolutionFileCacheObject = new ResolutionFileCache($item);
        
        $typo3Processor = $this->getTypo3ProcessorMock($testImage);
        $typo3Processor->_callRef('processFile', $resolutionConfig, $item, $resolutionFileCacheObject);

        $referenceImage = $this->sourceDirectory . 'Tests/Unit/TestImages/ref_testImage_200.jpg';

        $this->assertTrue(file_exists($testImage), 'No Image was created in Path ' . $testImage);

        echo '<div style="padding:10px">
				<img src="../'. str_replace(PATH_site, '', $testImage) .'" />
				<img src="../'. str_replace(PATH_site, '', $referenceImage) .'" />
			</div>
		';
        ob_flush();
    }



    /**
     * @test
     */
    public function createImageWithWatermark()
    {
        $testImage = $this->testImagePath . 'test_testImage_200_watermark.jpg';

        if (file_exists($testImage)) {
            unlink($testImage);
        }

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
				 file = EXT:yag/Tests/Unit/TestImages/watermark.png

				 // zentrieren des Wasserzeichen (im Beispiel watermark.png= 50x50 Pixel)
				 offset = [10.w]/2-25,[10.h]/2-25
			  }

			}
		';

        $tsParser  = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser'); /** @var $tsParser  \TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser */
        $tsParser->parse($resolutionTs);
        $tsArray = $tsParser->setup;
        
        $resolutionSettings = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Service\\TypoScriptService')->convertTypoScriptArrayToPlainArray($tsArray);
        $resolutionSettings = $resolutionSettings['medium'];
        $resolutionSettings['name'] = 'medium';

        $resolutionConfig = new ResolutionConfig($this->configurationBuilder, $resolutionSettings);
        $item = $this->getTestItemObject();
        $resolutionFileCacheObject = new ResolutionFileCache($item);

        $typo3Processor = $this->getTypo3ProcessorMock($testImage);
        $typo3Processor->_callRef('processFile', $resolutionConfig, $item, $resolutionFileCacheObject);

        $referenceImage = $this->sourceDirectory . 'Tests/Unit/TestImages/ref_testImage_200_watermark.jpg';

        echo '
			<img src="../'. str_replace(PATH_site, '', $testImage) .'" title="Test Image"/>
			<img src="../'. str_replace(PATH_site, '', $referenceImage) .'" title="Reference Image"/>
		';

        $this->assertTrue(file_exists($testImage) && is_file($testImage), 'No Image was created in Path ' . $testImage);
    }


    /**
     * @param string $testImageName
     * @return Typo3Processor
     */
    protected function getTypo3ProcessorMock($testImageName = 'test.jpg')
    {
        $configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface'); /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager */

        $contentObject = isset($this->cObj) ? $this->cObj : GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');

        $configurationManager->setContentObject($contentObject);

        $accessibleProcessorClassName = $this->buildAccessibleProxy('DL\\Yag\\Domain\\ImageProcessing\\Typo3Processor');

        $accessibleProcessor = $this->getMock($accessibleProcessorClassName, array('generateAbsoluteResolutionPathAndFilename')); /** @var $accessibleProcessor Typo3Processor  */

        $pidDetector = $this->objectManager->get('DL\\Yag\\Utility\\PidDetector');

        $accessibleProcessor->_injectProcessorConfiguration($this->configurationBuilder->buildImageProcessorConfiguration());
        $accessibleProcessor->injectConfigurationManager($configurationManager);
        $accessibleProcessor->injectFileSystemDiv(new Div());
        $accessibleProcessor->injectPidDetector($pidDetector);

        $accessibleProcessor->expects($this->once())
            ->method('generateAbsoluteResolutionPathAndFilename')
            ->will($this->returnValue($testImageName));

        return $accessibleProcessor;
    }
}
