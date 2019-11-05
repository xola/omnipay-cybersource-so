<?php


namespace Omnipay\CyberSourceSimpleOrder\Message;


class VoidRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array(
            'voidService_run' => 'true',
            'merchantID' => $this->getMerchantId(),
            'merchantReferenceCode' => $this->getTransactionId(),
            'voidService_voidRequestID' => $this->getTransactionReference()
        );

        return $data;
    }
}