<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Person;
use App\Entity\Wallet;
use App\Entity\Product;

class PersonTest extends TestCase
{
    public function testConstruct()
    {
        $wallet = new Wallet('USD');
        $person = new Person('carismexx', 'USD');
        $this->assertEquals('carismexx', $person->getName());
        $this->assertEquals($wallet, $person->getWallet());
    }

    public function testGetName()
    {
        $person = new Person('carismexx', 'USD');
        $this->assertEquals('carismexx', $person->getName());
    }

    public function testSetName()
    {
        $person = new Person('carismexx', 'USD');
        $person->setName('carismexx2');
        $this->assertEquals('carismexx2', $person->getName());
    }

    public function testGetWallet()
    {
        $wallet = new Wallet('USD');
        $person = new Person('carismexx', 'USD');
        $this->assertEquals($wallet, $person->getWallet());
    }

    public function testSetWallet()
    {
        $wallet = new Wallet('USD');
        $person = new Person('carismexx', 'USD');
        $person->setWallet($wallet);
        $this->assertEquals($wallet, $person->getWallet());
    }

    public function testHasFund()
    {
        $wallet = new Wallet('USD');
        $person = new Person('carismexx', 'USD');
        $this->assertFalse($person->hasFund(100));
        $wallet->setBalance(100);
        $person->setWallet($wallet);
        $this->assertTrue($person->hasFund(100));
    }

    public function testTransfertFund()
    {
        $person = new Person('carismexx', 'USD');
        $person2 = new Person('carismexx2', 'USD');
        $person->getWallet()->setBalance(100.0);
        $person2->getWallet()->setBalance(100.0);
        $person->transfertFund(50.0, $person2);
        $this->assertEquals(50.0, $person->getWallet()->getBalance());
        $this->assertEquals(150.0, $person2->getWallet()->getBalance());
    }

    public function testTransfertFundException()
    {
        $this->expectException(\Exception::class);
        $person = new Person('carismexx', 'USD');
        $person2 = new Person('carismexx2', 'EUR');
        $person->transfertFund(50.0, $person2);
    }

    public function testDivideWallet()
    {
        $person = new Person('carismexx', 'USD');
        $person2 = new Person('carismexx2', 'USD');
        $person->getWallet()->setBalance(150.0);
        $person2->getWallet()->setBalance(100.0);
        $arrayPersons = [$person, $person2];
        $person->divideWallet($arrayPersons);
        $this->assertEquals(75.0, $person->getWallet()->getBalance());
        $this->assertEquals(175.0, $person2->getWallet()->getBalance());
    }

    public function testBuyProduct()
    {
        $person = new Person('carismexx', 'USD');
        $person->getWallet()->setBalance(100.0);
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $person->buyProduct($product);
        $this->assertEquals(95.0, $person->getWallet()->getBalance());
    }

    public function testBuyProductException()
    {
        $this->expectException(\Exception::class);
        $person = new Person('carismexx', 'USD');
        $person->getWallet()->setBalance(100.0);
        $product = new Product('apple', ['EUR' => 5.0], 'food');
        $person->buyProduct($product);
    }
}
