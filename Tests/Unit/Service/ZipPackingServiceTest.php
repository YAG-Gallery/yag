<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ry25
 * Date: 28.04.13
 * Time: 19:04
 * To change this template use File | Settings | File Templates.
 */

namespace DL\Yag\Tests\Unit\Service;

use DL\Yag\Service\ZipPackingService;
use DL\Yag\Tests\Unit\BaseTestCase;

class ZipPackingServiceTest extends BaseTestCase
{
    /**
     * @var ZipPackingService
     */
    protected $zipPackingService;


    /**
     * @var string
     */
    protected $zipPackingServiceProxyClass;


    public function setUp()
    {
        parent::setUp();
        $this->zipPackingServiceProxyClass = $this->buildAccessibleProxy('DL\\Yag\\Service\\ZipPackingService');
    }



    /**
     * @test
     */
    public function getRequestedResolutionConfigReturnsMedium()
    {
        $this->initConfigurationBuilderMock();

        $this->zipPackingService = $this->objectManager->get($this->zipPackingServiceProxyClass);
        $this->zipPackingService->_injectConfigurationBuilder($this->configurationBuilder);

        $this->zipPackingService->_set('resolutionIdentifier', 'medium');
        $resolutionConfig = $this->zipPackingService->_call('getRequestedResolutionConfig');

        $this->assertInstanceOf('DL\\Yag\\Domain\\Configuration\\Image\\ResolutionConfig', $resolutionConfig);
        $this->assertEquals('default.medium', $resolutionConfig->getName());
    }
}
