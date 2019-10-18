<?php


namespace Omnipay\CyberSourceSimpleOrder\Message;


class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array(
            'ccAuthService_run' => 'true',
            'ccCaptureService_run' => 'true',
            'merchantID' => $this->getMerchantId(),
            'merchantReferenceCode' => $this->getTransactionReference(),
            'recurringSubscriptionInfo_subscriptionID' => $this->getToken(),
            'purchaseTotals_currency' => $this->getCurrency(),
            'purchaseTotals_grandTotalAmount' => $this->getAmount()
        );

        return $data;
    }
}