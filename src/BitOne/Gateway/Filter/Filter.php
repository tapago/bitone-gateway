<?php
/**
 * Created by PhpStorm.
 * User: Ederson
 * Date: 04/07/2016
 * Time: 08:41
 */

namespace BitOne\Gateway\Filter;


class Filter
{
    public static function Digits($data) {
        $filter = new \Zend\Filter\Digits();
        return $filter->filter($data);
    }

    public static function Int($data) {
        $filter = new \Zend\Filter\Int();
        return $filter->filter($data);
    }

    public static function StringToLower($data) {
        $filter = new \Zend\Filter\StringToLower();
        return $filter->filter($data);
    }

    public static function StringToUpper($data) {
        $filter = new \Zend\Filter\StringToUpper();
        return strtr($filter->filter($data), "áéíóúâêôãõàèìòùç", "ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ");
    }

    public static function StringTrim($data) {
        $filter = new \Zend\Filter\StringTrim();
        return $filter->filter($data);
    }

    public static function Boolean($data) {
        $filter = new \Zend\Filter\Boolean();
        return $filter->filter($data);
    }

    public static function NumberFormat($data) {
        return NumberFormat::toFloat($data);
    }

    public static function RemoverAcentos($texto)
    {
        $texto = htmlentities($texto);
        return preg_replace("/&([a-z])[a-z]+;/i", "$1", $texto);
    }

}