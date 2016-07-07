<?php
/**
 * Created by PhpStorm.
 * User: edersonsandre
 * Date: 02/07/16
 * Time: 01:44
 */

namespace BitOne\Gateway;

class Inquiry {

    use TraitGateway;

    protected $_key = 'inquiry';

    protected  function _mount(){
        $data['merchantId'] = $this->getMerchantId();
        $data['merchantKey'] = $this->getMerchantKey();

        $data['order'][$this->_key]['transactionId'] = $this->getTransactionId();

        return $data;
    }

}