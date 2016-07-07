<?php
/**
 * Created by PhpStorm.
 * User: Ederson
 * Date: 05/07/2016
 * Time: 09:59
 */

namespace BitOne\Gateway;


class Status
{
    public static function transactionState($key = null){
        $state[1] = 'CANCELADA';
        $state[2] = 'ESTORNADO';
        $state[3] = 'APROVADA / AUTORIZADA';
        $state[4] = 'REVISÃO DE FRAUDE';
        $state[5] = 'FRAUDE';
        $state[6] = 'PENDENTE';
        $state[8] = 'EXPIRADA';
        $state[9] = 'NÃO AUTORIZADA';
        $state[10] = 'CAPTURA';
        $state[11] = 'NÃO CAPTURADA';
        $state[12] = 'CANCELADA';
        $state[13] = 'FALHA NA TRANSAÇÃO';
        $state[27] = 'DEBITO PENDENTE';

        if(!empty($state)){
            $state = array_key_exists($key, $state) ? $state[$key] : null;
        }

        return $state;
    }

    public static function transactionType($key = null){
        $state[1] = 'SALE';
        $state[2] = 'AUTH';
        $state[3] = 'CAPTURE';
        $state[4] = 'VOID';
        $state[5] = 'ESTORNO';
        $state[6] = 'DEBIT';
        $state[10] = 'INIQUIRY';

        if(!empty($state)){
            $state = array_key_exists($key, $state) ? $state[$key] : null;
        }

        return $state;
    }
}