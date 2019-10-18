<?php


namespace Omnipay\CyberSourceSimpleOrder\Message;


use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{
    protected $statusCode;

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        // Success if the statusCode is within the 2xx range
        return $this->getCode() >= 200 && $this->getCode() < 300;
    }

    public function getMessage()
    {
        return $this->getData();
    }

    public function getCode()
    {
        return $this->statusCode = 200;
    }

    public function getData()
    {
        return $this->nvpToArray(parent::getData());
    }

    private function nvpToArray($response)
    {
        $arr = preg_split('/\\n/', $response);
        $responseMap = [];
        foreach($arr as $param) {
            if (empty($param)) {
                continue;
            }

            $keyValuePair = preg_split('/=/', $param);
            $responseMap[$keyValuePair[0]] = $keyValuePair[1];
        }
        return (object) $responseMap;
    }
}