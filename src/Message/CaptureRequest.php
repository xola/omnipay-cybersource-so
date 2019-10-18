<?php


namespace Omnipay\CyberSourceSimpleOrder\Message;


class CaptureRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array(
            'ccCaptureService_run' => 'true',
            'ccCaptureService_authRequestID' => $this->getTransactionId(),
            'merchantID' => $this->getMerchantId(),
            'merchantReferenceCode' => $this->getTransactionReference(),
            'purchaseTotals_currency' => $this->getCurrency(),
            'purchaseTotals_grandTotalAmount' => $this->getAmount()
        );

        return $data;
    }
}