<?php
/**
 * Created by PhpStorm.
 * User: edersonsandre
 * Date: 02/07/16
 * Time: 01:44
 */

namespace BitOne\Gateway;



use BitOne\Gateway\Filter\Filter;

class Auth extends AbstractGateway {

    use TraitGateway;

    protected $_key = 'auth';

}