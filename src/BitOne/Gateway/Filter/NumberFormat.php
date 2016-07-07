<?php
/**
 * Created by PhpStorm.
 * User: Ederson
 * Date: 04/07/2016
 * Time: 09:00
 */

namespace BitOne\Gateway\Filter;


class NumberFormat
{
    /**
     * toFloat
     * @param $valor
     * @return mixed
     */
    public static function toFloat($valor) {
        return self::formatMoney($valor, 0);
    }

    /**
     * toMoney
     * @param $valor
     * @return mixed
     */
    public static function toMoney($valor) {
        return self::formatMoney($valor, 1);
    }

    /**
     * FormataValorMoeda
     * @param $valor
     * @param $formato
     * @return string
     */
    protected static function formatMoney($valor, $formato) {
        $valor = trim($valor);
        $m_limpar = null;
        $m_aux = null;

        if ($formato == 1) {
            $valor = number_format(($valor), 2, ',', '.');
            return $valor;
        } else {
            $negativo = '';

            if (strpos($valor, '-') !== false) {
                $negativo = '-';
            }

            if (substr($valor, 0, 1) == ',' OR substr($valor, 0, 1) == '.')
                $valor = '0' . $valor;

            if (strlen($valor) == 0) {
                return false;
            } else {
                $m_pos = -1;
                while ($m_pos < strlen($valor)) {
                    $m_pos ++;
                    $m_letra = substr($valor, $m_pos, 1);
                    if (strpos("\,\.", $m_letra) > 0) {
                        $m_letra = '*';
                        $m_aux = $m_pos;
                    }
                    if ($m_letra <> '*')
                        $m_limpar = $m_limpar . $m_letra;
                }

                if ($m_aux > 0) {
                    $m_aux = strlen($valor) - $m_aux;
                    $m_limpar = Filter::Digits(substr($m_limpar, 0, strlen($m_limpar) - $m_aux + 1)) . "." . Filter::Digits(substr($m_limpar, strlen($m_limpar) - $m_aux + 1, $m_aux));
                    $m_retorno = $m_limpar;
                } else {
                    $m_limpar = Filter::Digits($m_limpar) . '.00';
                    $m_retorno = $m_limpar;
                }
            }

            $m_retorno = $negativo . $m_retorno;

            return number_format($m_retorno, 2, '.', '');
        }
    }
}