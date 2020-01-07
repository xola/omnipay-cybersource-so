<?php

namespace Omnipay\CyberSourceSimpleOrder;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * @method RequestInterface completeAuthorize(array $options = array())
 * @method RequestInterface completePurchase(array $options = array())
 * @method RequestInterface createCard(array $options = array())
 * @method RequestInterface updateCard(array $options = array())
 * @method RequestInterface deleteCard(array $options = array())
 */
class Gateway extends AbstractGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName()
    {
        return 'CyberSource Simple Order API';
    }

    public function getDefaultParameters()
    {
        return array(
            'testMode' => false,
            'merchant_id' => '',
            'merchant_key' => '',
        );
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchant_id');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchant_id', $value);
    }

    public function getMerchantKey()
    {
        return $this->getParameter('merchant_key');
    }

    public function setMerchantKey($value)
    {
        return $this->setParameter('merchant_key', $value);
    }

    /**
     * Processes a payment authorization for a tokenized card payment.
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CyberSourceSimpleOrder\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Processes a capture on a payment authorization.
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CyberSourceSimpleOrder\Message\CaptureRequest', $parameters);
    }

    /**
     * Processes a payment to be authorized and captured at the same time.
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CyberSourceSimpleOrder\Message\PurchaseRequest', $parameters);
    }

    /**
     * Process a Void request for a previous Capture or Credit (Refund) request.
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CyberSourceSimpleOrder\Message\VoidRequest', $parameters);
    }

    /**
     * Process a Credit (Refund) for a submitted payment.
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CyberSourceSimpleOrder\Message\RefundRequest', $parameters);
    }

    /**
     * Unimplemented calls from AbstractGateway
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
    }
}