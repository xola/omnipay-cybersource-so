<?php

namespace Omnipay\CyberSourceSimpleOrder\Message;

use CybsClient;
use Omnipay\Common\Exception\InvalidRequestException;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $testApiHosts = array(
        'wsdl' => 'https://ics2wstest.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.120.wsdl',
        'nvp_wsdl' => 'https://ics2wstest.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_NVP_1.120.wsdl'
    );

    protected $liveApiHosts = array(
        'wsdl' => 'https://ics2ws.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.120.wsdl',
        'nvp_wsdl' => 'https://ics2ws.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_NVP_1.120.wsdl'
    );

    public function getMerchantId()
    {
        return $this->getParameter('merchant_id');
    }

    public function getMerchantKey()
    {
        return $this->getParameter('merchant_key');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchant_id', $value);
    }

    public function setMerchantKey($value)
    {
        return $this->setParameter('merchant_key', $value);
    }

    public function getApiHosts()
    {
        return $this->getParameter('testMode') ? $this->testApiHosts : $this->liveApiHosts;
    }

    public function sendData($data)
    {
        $options = array_merge(
            array(
                'merchant_id' => $this->getMerchantId(),
                'transaction_key' => $this->getMerchantKey(),
            ),
            $this->getApiHosts()
        );

        try {
            $client = new CybsClient(array(), $options, true);
            $requestNvp = $this->arrayToNvp($data);
            $reply = $client->runTransaction($requestNvp);

            return $this->response = new Response($this, $reply);
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage());
        }
    }

    protected function getResourcePath()
    {
        return '';
    }

    public function getEndpoint()
    {
        return '';
    }

    private function arrayToNvp($request)
    {
        if (!is_array($request)) {
            throw new Exception('Name-value pairs must be in array');
        }
        // if (!array_key_exists('merchantID', $request)) {
        //     $request['merchantID'] = $this->getMerchantId();
        // }
        $nvpRequest = "";
        foreach ($request as $k => $v) {
            $nvpRequest .= ($k . "=" . $v . "\n");
        }

        return $nvpRequest;
    }
}