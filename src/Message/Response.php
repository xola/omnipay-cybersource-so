<?php


namespace Omnipay\CyberSourceSimpleOrder\Message;


use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{
    protected $statusCode;
    private $isSuccess = false;
    private $errorMessage = "";

    private static $result_codes = array(
        '100' => 'Successful transaction.',
        '101' => 'The request is missing one or more required fields.',
        '102' => 'One or more fields in the request contains invalid data.',
        '110' => 'Only a partial amount was approved.',
        '150' => 'Error: General system failure.',
        '151' => 'Error: The request was received but there was a server timeout.',
        '152' => 'Error: The request was received, but a service did not finish running in time.',
        '200' => 'The authorization request was approved by the issuing bank but declined by CyberSource because it did not pass the Address Verification Service (AVS) check.',
        '201' => 'The issuing bank has questions about the request.',
        '202' => 'Expired card.',
        '203' => 'General decline of the card.',
        '204' => 'Insufficient funds in the account.',
        '205' => 'Stolen or lost card.',
        '207' => 'Issuing bank unavailable.',
        '208' => 'Inactive card or card not authorized for card-not-present transactions.',
        '209' => 'American Express Card Identification Digits (CID) did not match.',
        '210' => 'The card has reached the credit limit.',
        '211' => 'Invalid CVN.',
        '221' => 'The customer matched an entry on the processor\'s negative file.',
        '230' => 'The authorization request was approved by the issuing bank but declined by CyberSource because it did not pass the CVN check.',
        '231' => 'Invalid credit card number.',
        '232' => 'The card type is not accepted by the payment processor.',
        '233' => 'General decline by the processor.',
        '234' => 'There is a problem with your CyberSource merchant configuration.',
        '235' => 'The requested amount exceeds the originally authorized amount.',
        '236' => 'Processor failure.',
        '237' => 'The authorization has already been reversed.',
        '238' => 'The authorization has already been captured.',
        '239' => 'The requested transaction amount must match the previous transaction amount.',
        '240' => 'The card type sent is invalid or does not correlate with the credit card number.',
        '241' => 'The request ID is invalid.',
        '242' => 'You requested a capture, but there is no corresponding, unused authorization record.',
        '243' => 'The transaction has already been settled or reversed.',
        '246' => 'The capture or credit is not voidable because the capture or credit information has laready been submitted to your processor. Or, you requested a void for a type of transaction that cannot be voided.',
        '247' => 'You requested a credit for a capture that was previously voided.',
        '250' => 'Error: The request was received, but there was a timeout at the payment processor.',
        '520' => 'The authorization request was approved by the issuing bank but declined by CyberSource based on your Smart Authorization settings.',
    );


    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->crawlResponse();
    }

    private function crawlResponse()
    {
        if ($this->getData()->decision != 'ACCEPT') {
            // Request is missing fields
            if ($this->getData()->reasonCode == 101) {
                $missing_fields = 'Missing fields: ';

                $fields = $this->preg_grep_keys('/^missingField_\d+$/', (array)$this->getData());
                if (empty($fields)) {
                    $missing_fields = $missing_fields . 'Unknown';
                } else {
                    $missing_fields = $missing_fields . implode(', ', $this->vals_from_keys($fields, $this->getData()));
                }

                $this->isSuccess = false;
                $this->errorMessage = $missing_fields;
                return;
            }

            // Request contains invalid fields
            if ($this->getData()->reasonCode == 102) {
                $invalid_fields = 'Invalid fields: ';

                $fields = $this->preg_grep_keys('/^invalidField_\d+$/', (array)$this->getData());
                if (empty($fields)) {
                    $invalid_fields = $invalid_fields . 'Unknown';
                } else {
                    $invalid_fields = $invalid_fields . implode(', ', $this->vals_from_keys($fields, $this->getData()));
                }

                $this->isSuccess = false;
                $this->errorMessage =  $invalid_fields;
                return;
            }

            // Throw error defined by CyberSource
            $this->isSuccess = false;
            $this->errorMessage = self::$result_codes[$this->getData()->reasonCode ];
        } else {
            $this->isSuccess = true;
        }
    }

    /**
     * @param $keys {array}
     * @param $input {object}
     * @return array
     */
    private function vals_from_keys($keys, $input)
    {
        $vals = [];
        foreach ($keys as $key) {
            array_push($vals, $input->$key);
        }
        return $vals;
    }

    private function preg_grep_keys($pattern, $input, $flags = 0)
    {
        return preg_grep($pattern, array_keys($input), $flags);
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        // Success if the statusCode is within the 2xx range
        return $this->isSuccess;
    }

    public function getMessage()
    {
        return $this->errorMessage;
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