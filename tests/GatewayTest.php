<?php

namespace Omnipay\CyberSourceSimpleOrder;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    public $gateway;

    /** @var array */
    public $options = array();

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setTestMode(true);
        $this->gateway->setMerchantId('your_merchant_id');
        $this->gateway->setMerchantKey('your_transaction_key');
    }

    public function testAuthorize()
    {
        $response = $this->gateway->authorize($this->options)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getMessage());
    }
}