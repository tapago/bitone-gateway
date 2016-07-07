<?php
/**
 * Created by PhpStorm.
 * User: Ederson
 * Date: 05/07/2016
 * Time: 16:57
 */

namespace BitOne\Gateway;


class AuthTest extends \PHPUnit_Framework_TestCase
{
    protected $id = '';
    protected $key = '';
    protected $startDate;
    protected $endDate;
    protected $count;

    /**
     * @group venda
     */
    public function testVendaECaptura(){
        $this->startDate = date('Y-m-d H:i:s');

        $arr = ['10,00','20,00'];

        foreach($arr AS $row) {
            $this->count += 1;
            ############ VENDA SEM CAPTURA
            $sale = new \BitOne\Gateway\Auth($this->id, $this->key);
            $sale->setSaveClient(false)
                ->setReferenceTag("API é")
                ->setCreditClientName("Ederson Sandre")
                ->setCreditNumber('4111 1111 1111 1111')
                ->setCreditExpirationMonth('08')
                ->setCreditExpirationYear('2022')
                ->setCreditCvv('098')
                ->setTotalAmount($row);

            $_sale = $sale->requestTransaction();

            $this->assertEquals(1, $_sale['success']);
            $this->assertEquals(3, $_sale['body']['responseCode']);
            $this->assertEquals(3, $_sale['body']['transactionState']);

            $report = $this->getSaleTransactionId($_sale['body']['transactionId']);
            $this->assertEquals($_sale['body']['transactionState'], $report['transactionStateId']);

            ############ CAPTURA
            $captura = new \BitOne\Gateway\Captura($this->id, $this->key);
            $captura->setTransactionId($_sale['body']['transactionId']);
            $_captura = $captura->requestTransaction();

            $this->assertEquals(1, $_captura['success']);
            $this->assertEquals(10, $_captura['body']['responseCode']);
            $this->assertEquals(10, $_captura['body']['transactionState']);

            $report = $this->getSaleTransactionId($_sale['body']['transactionId']);
            $this->assertEquals($_captura['body']['transactionState'], $report['transactionStateId']);

            ############ CANCELAMENTO
            $cancelamento = new \BitOne\Gateway\Cancel($this->id, $this->key);
            $cancelamento->setTransactionId($_sale['body']['transactionId']);
            $_cancelamento = $cancelamento->requestTransaction();

            $this->assertEquals(1, $_cancelamento['success']);
            $this->assertEquals(12, $_cancelamento['body']['responseCode']);
            $this->assertEquals(12, $_cancelamento['body']['transactionState']);

            $report = $this->getSaleTransactionId($_sale['body']['transactionId']);
            $this->assertEquals($_cancelamento['body']['transactionState'], $report['transactionStateId']);
        }

    }

    /**
     * @group venda
     */
    public function testVendaCapturada(){
        $arr = ['10,00','20,00'];

        foreach($arr AS $row) {
            $this->count += 1;

            ############ VENDA CAPTURADA
            $sale = new \BitOne\Gateway\Sale($this->id, $this->key);
            $sale->setSaveClient(false)
                ->setReferenceTag("API é")
                ->setCreditClientName("Ederson Sandre")
                ->setCreditNumber('4111 1111 1111 1111')
                ->setCreditExpirationMonth('08')
                ->setCreditExpirationYear('2022')
                ->setCreditCvv('098')
                ->setTotalAmount($row);

            $_sale = $sale->requestTransaction();

            $this->assertEquals(1, $_sale['success']);
            $this->assertEquals(10, $_sale['body']['responseCode']);
            $this->assertEquals(10, $_sale['body']['transactionState']);

            $report = $this->getSaleTransactionId($_sale['body']['transactionId']);
            $this->assertEquals($_sale['body']['transactionState'], $report['transactionStateId']);

            ############ CANCELAMENTO
            $cancelamento = new \BitOne\Gateway\Cancel($this->id, $this->key);
            $cancelamento->setTransactionId($_sale['body']['transactionId']);
            $_cancelamento = $cancelamento->requestTransaction();

            $this->assertEquals(1, $_cancelamento['success']);
            $this->assertEquals(12, $_cancelamento['body']['responseCode']);
            $this->assertEquals(12, $_cancelamento['body']['transactionState']);

            $report = $this->getSaleTransactionId($_sale['body']['transactionId']);
            $this->assertEquals($_cancelamento['body']['transactionState'], $report['transactionStateId']);
        }
    }

    /**
     * @group venda
     * @group debito
     */
    public function testVendaDebit(){
        $arr = ['10,00','20,00'];

        foreach($arr AS $row) {
            $this->count += 1;

            ############ VENDA DEBIT
            $sale = new \BitOne\Gateway\Debit($this->id, $this->key);
            $sale->setSaveClient(false)
                ->setReferenceTag("API é")
                ->setCreditClientName("Ederson Sandre")
                ->setCreditNumber('4111 1111 1111 1111')
                ->setCreditExpirationMonth('08')
                ->setCreditExpirationYear('2022')
                ->setCreditCvv('098')
                ->setTotalAmount($row);

            $_sale = $sale->requestTransaction();
            $this->assertEquals(1, $_sale['success']);
            $this->assertEquals(27, $_sale['body']['responseCode']);
            $this->assertEquals(27, $_sale['body']['transactionState']);
            $this->assertFalse(empty($_sale['body']['urlDebitResponse']));

            $report = $this->getSaleTransactionId($_sale['body']['transactionId']);
            $this->assertEquals($_sale['body']['transactionState'], $report['transactionStateId']);
        }
    }

    /**
     * @group venda
     * @group debito
     * @group fail
     */
    public function testFailVendaDebit(){
        $this->count += 1;

        ############ VENDA DEBITO FAIL
        $sale = new \BitOne\Gateway\Debit($this->id, $this->key);
        $sale->setSaveClient(false)
            ->setReferenceTag("API é")
            ->setCreditClientName("Ederson Sandre")
            ->setCreditNumber('4111 1111 1111 1111')
            ->setCreditExpirationMonth('08')
            ->setCreditExpirationYear('2022')
            ->setCreditCvv('098')
            ->setTotalAmount(0)
        ;

        $_sale = $sale->requestTransaction();
        $this->assertEquals(0, $_sale['success']);
        $this->assertEquals(13, $_sale['body']['responseCode']);
        $this->assertEquals(13, $_sale['body']['transactionState']);
        $this->assertTrue(empty($_sale['body']['urlDebitResponse']));

        $report = $this->getSaleTransactionId($_sale['body']['transactionId']);
        $this->assertEquals($_sale['body']['transactionState'], $report['transactionStateId']);

        ############ CANCELAMENTO
        $cancelamento = new \BitOne\Gateway\Cancel($this->id, $this->key);
        $cancelamento->setTransactionId($_sale['body']['transactionId']);
        $_cancelamento = $cancelamento->requestTransaction();

        $this->assertFalse($_cancelamento['success']);

    }

    /**
     * @group relatorio
     */
    public function testReport(){
        $this->endDate = date('Y-m-d H:i:s');

        $report = new \BitOne\Gateway\Debit($this->id, $this->key);
        $report->setStartDate($this->startDate);
        $report->setEndDate($this->endDate);

        $_report = $report->requestTransaction();
        if($_report['success']){
            $this->assertArrayHasKey('body', $_report);
            $this->assertEquals($this->count, count($_report['body']['transactions']));
        }
    }

    private function getSaleTransactionId($id){
        $report = new \BitOne\Gateway\Report($this->id, $this->key);
        $report->setTransactionId($id);
        $report->setReferenceTag(null);

        $_report = $report->requestTransaction();
        if($_report['success']){
            $this->assertArrayHasKey('body', $_report);
            $this->assertEquals(1, count($_report['body']['transactions']));
            $this->assertInternalType('array',$_report['body']['transactions']);
        }

        return $_report['body']['transactions'][0];
    }

}
