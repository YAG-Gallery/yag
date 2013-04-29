<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ry25
 * Date: 28.04.13
 * Time: 19:04
 * To change this template use File | Settings | File Templates.
 */


class Tx_Yag_Tests_Service_ZipPackingServiceTest extends Tx_Yag_Tests_BaseTestCase {


	/**
	 * @var Tx_Yag_Service_ZipPackingService
	 */
	protected $zipPackingService;


	/**
	 * @var string
	 */
	protected $zipPackingServiceProxyClass;


	public function setUp() {
		$this->zipPackingServiceProxyClass = $this->buildAccessibleProxy('Tx_Yag_Service_ZipPackingService');
	}



	/**
	 * @test
	 */
	public function getRequestedResolutionConfigReturnsMedium() {
		$this->initConfigurationBuilderMock();

		$this->zipPackingService = $this->objectManager->get($this->zipPackingServiceProxyClass);
		$this->zipPackingService->_injectConfigurationBuilder($this->configurationBuilder);

		$this->zipPackingService->_set('resolutionIdentifier', 'medium');
		$resolutionConfig = $this->zipPackingService->_call('getRequestedResolutionConfig');

		$this->assertInstanceOf('Tx_Yag_Domain_Configuration_Image_ResolutionConfig', $resolutionConfig);
		$this->assertEquals('default.medium', $resolutionConfig->getName());
	}
}