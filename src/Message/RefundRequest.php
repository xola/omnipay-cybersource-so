<?php


namespace Omnipay\CyberSourceSimpleOrder\Message;


class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array(
            'ccCreditService_run' => 'true',
            'ccCreditService_captureRequestID' => $this->getTransactionReference(),
            'merchantID' => $this->getMerchantId(),
            'merchantReferenceCode' => $this->getTransactionId(),
            'purchaseTotals_currency' => $this->getCurrency(),
            'purchaseTotals_grandTotalAmount' => $this->getAmount()
        );

        return $data;
    }
}