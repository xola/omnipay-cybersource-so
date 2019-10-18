<?php


namespace Omnipay\CyberSourceSimpleOrder\Message;


class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array(
            'ccCreditService_run' => 'true',
            'ccCreditService_captureRequestID' => $this->getTransactionId(),
            'merchantID' => $this->getMerchantId(),
            'merchantReferenceCode' => $this->getTransactionReference(),
            'purchaseTotals_currency' => $this->getCurrency(),
            'purchaseTotals_grandTotalAmount' => $this->getAmount()
        );

        return $data;
    }
}