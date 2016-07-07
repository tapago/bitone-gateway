<?php
/**
 * Created by PhpStorm.
 * User: edersonsandre
 * Date: 02/07/16
 * Time: 01:42
 */

namespace BitOne\Gateway;


use BitOne\Gateway\Filter\Filter;

class AbstractGateway {

    protected $merchantId;
    protected $merchantKey;
    protected $origin;
    protected $apiKey;
    protected $saveClient = false;
    protected $saveCard;
    protected $useAvs;
    protected $devMode;
    protected $processor;
    protected $totalAmount;
    protected $amount;
    protected $shippingAmount = null;
    protected $iataFee = null;
    protected $descriptor = 3;
    protected $currency = 'BRL';
    protected $referenceTag = 'API Integração';
    protected $clientName;
    protected $clientEmail;
    protected $creditClientName;
    protected $creditNumber;
    protected $creditExpirationMonth;
    protected $creditExpirationYear;
    protected $creditCvv;
    protected $creditInstallments = 1;
    protected $creditChargeInterest = 1;
    protected $cancelAmount;
    protected $transactionId;
    protected $method = 'POST';
    protected $uri;
    protected $data;
    protected $orderId;
    protected $startDate;
    protected $endDate;
    protected $transactionType;
    protected $transactionState;
    protected $clientId;
    protected $onlyToday;
    protected $thisMonth;

    public function __construct($merchantId, $merchantKey)
    {
        $this->setMerchantId($merchantId);
        $this->setMerchantKey($merchantKey);

        $this->setUri('https://api.bit.one/bitOneApi/gw/req');
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param mixed $transactionType
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
    }

    /**
     * @return mixed
     */
    public function getTransactionState()
    {
        return $this->transactionState;
    }

    /**
     * @param mixed $transactionState
     */
    public function setTransactionState($transactionState)
    {
        $this->transactionState = $transactionState;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getOnlyToday()
    {
        return $this->onlyToday;
    }

    /**
     * @param mixed $onlyToday
     */
    public function setOnlyToday($onlyToday)
    {
        $this->onlyToday = $onlyToday;
    }

    /**
     * @return mixed
     */
    public function getThisMonth()
    {
        return $this->thisMonth;
    }

    /**
     * @param mixed $thisMonth
     */
    public function setThisMonth($thisMonth)
    {
        $this->thisMonth = $thisMonth;
    }

     /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCancelAmount()
    {
        return $this->cancelAmount;
    }

    /**
     * @param mixed $cancelAmount
     */
    public function setCancelAmount($cancelAmount)
    {
        $this->cancelAmount = $cancelAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCaptureAmount()
    {
        return $this->captureAmount;
    }

    /**
     * @param mixed $captureAmount
     */
    public function setCaptureAmount($captureAmount)
    {
        $this->captureAmount = $captureAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * @param mixed $clientEmail
     */
    public function setClientEmail($clientEmail)
    {
        $this->clientEmail = $clientEmail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @param mixed $clientName
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreditChargeInterest()
    {
        return $this->creditChargeInterest;
    }

    /**
     * @param mixed $creditChargeInterest
     */
    public function setCreditChargeInterest($creditChargeInterest)
    {
        $this->creditChargeInterest = $creditChargeInterest;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreditClientName()
    {
        return $this->creditClientName;
    }

    /**
     * @param mixed $creditClientName
     */
    public function setCreditClientName($creditClientName)
    {
        $this->creditClientName = $creditClientName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreditCvv()
    {
        return $this->creditCvv;
    }

    /**
     * @param mixed $creditCvv
     */
    public function setCreditCvv($creditCvv)
    {
        $this->creditCvv = $creditCvv;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreditExpirationMonth()
    {
        return $this->creditExpirationMonth;
    }

    /**
     * @param mixed $creditExpirationMonth
     */
    public function setCreditExpirationMonth($creditExpirationMonth)
    {
        $this->creditExpirationMonth = $creditExpirationMonth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreditExpirationYear()
    {
        return $this->creditExpirationYear;
    }

    /**
     * @param mixed $creditExpirationYear
     */
    public function setCreditExpirationYear($creditExpirationYear)
    {
        $this->creditExpirationYear = $creditExpirationYear;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreditInstallments()
    {
        return $this->creditInstallments;
    }

    /**
     * @param mixed $creditInstallments
     */
    public function setCreditInstallments($creditInstallments)
    {
        $this->creditInstallments = $creditInstallments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreditNumber()
    {
        return $this->creditNumber;
    }

    /**
     * @param mixed $creditNumber
     */
    public function setCreditNumber($creditNumber)
    {
        $this->creditNumber = $creditNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescriptor()
    {
        return $this->descriptor;
    }

    /**
     * @param mixed $descriptor
     */
    public function setDescriptor($descriptor)
    {
        $this->descriptor = $descriptor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDevMode()
    {
        return $this->devMode;
    }

    /**
     * @param mixed $devMode
     */
    public function setDevMode($devMode)
    {
        $this->devMode = $devMode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIataFee()
    {
        return $this->iataFee;
    }

    /**
     * @param mixed $iataFee
     */
    public function setIataFee($iataFee)
    {
        $this->iataFee = $iataFee;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param mixed $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantKey()
    {
        return $this->merchantKey;
    }

    /**
     * @param mixed $merchantKey
     */
    public function setMerchantKey($merchantKey)
    {
        $this->merchantKey = $merchantKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param mixed $origin
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * @param mixed $processor
     */
    public function setProcessor($processor)
    {
        $this->processor = $processor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferenceTag()
    {
        return !empty($this->referenceTag) ? Filter::RemoverAcentos($this->referenceTag) : null;

    }

    /**
     * @param mixed $referenceTag
     */
    public function setReferenceTag($referenceTag)
    {
        $this->referenceTag = $referenceTag;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSaveCard()
    {
        return $this->saveCard;
    }

    /**
     * @param mixed $saveCard
     */
    public function setSaveCard($saveCard)
    {
        $this->saveCard = $saveCard;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSaveClient()
    {
        return $this->saveClient;
    }

    /**
     * @param mixed $saveClient
     */
    public function setSaveClient($saveClient)
    {
        $this->saveClient = $saveClient;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingAmount()
    {
        return $this->shippingAmount;
    }

    /**
     * @param mixed $shippingAmount
     */
    public function setShippingAmount($shippingAmount)
    {
        $this->shippingAmount = $shippingAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param mixed $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param mixed $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUseAvs()
    {
        return $this->useAvs;
    }

    /**
     * @param mixed $useAvs
     */
    public function setUseAvs($useAvs)
    {
        $this->useAvs = $useAvs;
        return $this;
    }

}