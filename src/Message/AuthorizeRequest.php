<?php


namespace Omnipay\CyberSourceSimpleOrder\Message;


class AuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array(
            'ccAuthService_run' => 'true',
            'merchantID' => $this->getMerchantId(),
            'merchantReferenceCode' => $this->getTransactionId(),
            'recurringSubscriptionInfo_subscriptionID' => $this->getToken(),
            'purchaseTotals_currency' => $this->getCurrency(),
            'purchaseTotals_grandTotalAmount' => $this->getAmount()
        );

        return $data;
    }
}