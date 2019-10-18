<?php


namespace Omnipay\CyberSourceSimpleOrder\Message;


class VoidRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array(
            'voidService_run' => 'true',
            'merchantID' => $this->getMerchantId(),
            'merchantReferenceCode' => $this->getTransactionReference(),
            'voidService_voidRequestID' => $this->getTransactionId()
        );

        return $data;
    }
}