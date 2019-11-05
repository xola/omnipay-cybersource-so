<?php


namespace Omnipay\CyberSourceSimpleOrder\Message;


class CaptureRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array(
            'ccCaptureService_run' => 'true',
            'ccCaptureService_authRequestID' => $this->getTransactionReference(),
            'merchantID' => $this->getMerchantId(),
            'merchantReferenceCode' => $this->getTransactionId(),
            'purchaseTotals_currency' => $this->getCurrency(),
            'purchaseTotals_grandTotalAmount' => $this->getAmount()
        );

        return $data;
    }
}