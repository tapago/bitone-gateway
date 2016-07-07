<?php
/**
 * Created by PhpStorm.
 * User: Ederson
 * Date: 05/07/2016
 * Time: 09:51
 */

namespace BitOne\Gateway;


use BitOne\Gateway\Filter\Filter;

trait TraitGateway
{
    protected  function _mount(){
        $data['merchantId'] = $this->getMerchantId();
        $data['merchantKey'] = $this->getMerchantKey();
        $data['order'][$this->_key]['options']['saveClient'] = $this->getSaveClient();
        $data['order'][$this->_key]['totalAmount'] = Filter::NumberFormat($this->getTotalAmount());
        $data['order'][$this->_key]['shippingAmount'] = $this->getShippingAmount();
        $data['order'][$this->_key]['iataFee'] = $this->getIataFee();
        $data['order'][$this->_key]['descriptor'] = $this->getDescriptor();
        $data['order'][$this->_key]['currency'] = $this->getCurrency();
        $data['order'][$this->_key]['referenceTag'] = $this->getReferenceTag();
        $data['order'][$this->_key]['creditPayment']['creditClientName'] = $this->getCreditClientName();
        $data['order'][$this->_key]['creditPayment']['creditNumber'] = Filter::Digits($this->getCreditNumber());
        $data['order'][$this->_key]['creditPayment']['creditExpirationMonth'] = $this->getCreditExpirationMonth();
        $data['order'][$this->_key]['creditPayment']['creditExpirationYear'] = Filter::Digits($this->getCreditExpirationYear());
        $data['order'][$this->_key]['creditPayment']['creditCvv'] = Filter::Digits($this->getCreditCvv());
        $data['order'][$this->_key]['creditPayment']['creditInstallments'] = $this->getCreditInstallments();
        $data['order'][$this->_key]['creditPayment']['creditChargeInterest'] = $this->getCreditChargeInterest();

        return $data;
    }

    public function response($request)
    {
        $data = !empty($request->body) ? (Array) json_decode($request->body) : null;
        $message = !empty($data['responseMessage']) ? $data['responseMessage']  : null;

        $response['status_code'] = $request->status_code;
        $response['success'] = (!empty($data['success']) && $data['success']);
        $response['message'] = $message;
        $response['body'] = $data;

        return $response;
    }

    public function requestTransaction() {
        try{
            $this->setData($this->_mount());

            $headers = array('Accept' => 'application/json');
            $request = \Requests::post($this->getUri(), $headers, json_encode($this->getData()));

            $response =  $this->response($request);
        }catch (\Exception $e){
            $response['status_code'] = 400;
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

}