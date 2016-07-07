<?php
/**
 * Created by PhpStorm.
 * User: edersonsandre
 * Date: 02/07/16
 * Time: 01:44
 */

namespace BitOne\Gateway;


class Report extends AbstractGateway
{
    use TraitGateway;

    public function __construct($merchantId, $merchantKey)
    {
        parent::__construct($merchantId, $merchantKey);
        $this->setUri('https://api.bit.one/bitOneReports/rpt');
    }

    protected function _mount()
    {
        $data['merchantId'] = $this->getMerchantId();
        $data['merchantKey'] = $this->getMerchantKey();

        $data['transactionReport']['transactionId'] = $this->getTransactionId();
        $data['transactionReport']['orderId'] = $this->getOrderId();
        $data['transactionReport']['currency'] = $this->getCurrency();
        $data['transactionReport']['referenceTag'] = $this->getReferenceTag();
        $data['transactionReport']['startDate'] = $this->getStartDate();
        $data['transactionReport']['endDate'] = $this->getStartDate();
        $data['transactionReport']['transactionType'] = $this->getTransactionType();
        $data['transactionReport']['transactionState'] = $this->getTransactionState();
        $data['transactionReport']['clientId'] = $this->getClientId();
        $data['transactionReport']['onlyToday'] = $this->getOnlyToday();
        $data['transactionReport']['thisMonth'] = $this->getThisMonth();

        return $data;
    }

    public function objectToArray($obj)
    {
        if (is_object($obj)) $obj = (array)$obj;
        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = $this->objectToArray($val);
            }
        } else {
            $new = $obj;
        }

        return $new;
    }

    public function response($request)
    {
        $data = !empty($request->body) ? $this->objectToArray(json_decode(utf8_encode($request->body))) : null;

        $body = !empty($data['reportTransaction']) ? (Array)$data['reportTransaction'] : null;

        $response['status_code'] = $request->status_code;
        $response['success'] = (!empty($data['success']) && $data['success']);
        $response['body'] = $body;

        return $response;
    }

}