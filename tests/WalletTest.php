<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Person;
use App\Entity\Wallet;
use App\Entity\Product;

class WalletTest extends TestCase
{
    public function testConstruct()
    {
        $wallet = new Wallet('USD');
        $this->assertEquals('USD', $wallet->getCurrency());
        $this->assertEquals(0, $wallet->getBalance());
    }

    public function testGetBalance()
    {
        $wallet = new Wallet('USD');
        $this->assertEquals(0, $wallet->getBalance());
    }

    public function testGetCurrency()
    {
        $wallet = new Wallet('USD');
        $this->assertEquals('USD', $wallet->getCurrency());
    }

    public function testSetBalance()
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(6.0);
        $this->assertEquals(6.0, $wallet->getBalance());
    }

    public function testSetBalanceException()
    {
        $wallet = new Wallet('USD');
        $this->expectException(\Exception::class);
        $wallet->setBalance(-56.0);
    }

    public function testSetCurrency()
    {
        $wallet = new Wallet('USD');
        $wallet->setCurrency('EUR');
        $this->assertEquals('EUR', $wallet->getCurrency());
    }

    public function testSetCurrencyException()
    {
        $wallet = new Wallet('USD');
        $this->expectException(\Exception::class);
        $wallet->setCurrency('PHP');
    }

    public function testRemoveFund()
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(80.0);
        $wallet->removeFund(50.0);
        $this->assertEquals(30.0, $wallet->getBalance());
    }

    public function testRemoveFundExceptionInvalid()
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(80.0);
        $this->expectException(\Exception::class);
        $wallet->removeFund(-50.0);
    }

    public function testRemoveFundExceptionInsufficient()
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(80.0);
        $this->expectException(\Exception::class);
        $wallet->removeFund(81.0);
    }

    public function testAddFund()
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(80.0);
        $wallet->addFund(54.0);
        $this->assertEquals(134.0, $wallet->getBalance());
    }

    public function testAddFundException()
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(80.0);
        $this->expectException(\Exception::class);
        $wallet->addFund(-50.0);
    }
}
