<?php
/**
 * Created by PhpStorm.
 * User: edersonsandre
 * Date: 02/07/16
 * Time: 01:44
 */

namespace BitOne\Gateway;

use BitOne\Gateway\Filter\Filter;

class Cancel extends AbstractGateway{

    use TraitGateway;

    protected $_key = 'voidPayment';

    protected  function _mount(){
        $data['merchantId'] = $this->getMerchantId();
        $data['merchantKey'] = $this->getMerchantKey();

        $data['order'][$this->_key]['transactionId'] = $this->getTransactionId();

        return $data;
    }

}