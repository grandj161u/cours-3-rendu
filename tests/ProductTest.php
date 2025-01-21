<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductTest extends TestCase
{

    public function testConstruct()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $this->assertEquals('apple', $product->getName());
        $this->assertEquals(['USD' => 5.0], $product->getPrices());
        $this->assertEquals('food', $product->getType());
    }

    public function testGetName()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $this->assertEquals('apple', $product->getName());
    }

    public function testGetPrices()
    {
        $product = new Product('apple', ['USD' => 5.0, 'EUR' => 4.50], 'food');
        $this->assertEquals(['USD' => 5.0, 'EUR' => 4.50], $product->getPrices());
    }

    public function testGetType()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $this->assertEquals('food', $product->getType());
    }

    public function testSetType()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $product->setType('other');
        $this->assertEquals('other', $product->getType());
    }

    public function testSetTypeException()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $this->expectException(\Exception::class);
        $product->setType(5.0);
    }

    public function testSetPrice()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $product->setPrices(['USD' => 5.0, 'EUR' => 3.0]);
        $this->assertEquals(['USD' => 5.0, 'EUR' => 3.0], $product->getPrices());
    }

    public function testSetPriceCurrency()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $product->setPrices(['PHP' => 1.0]);
        $this->assertEquals(['USD' => 5.0], $product->getPrices());
    }

    public function testSetPriceNegative()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $product->setPrices(['USD' => -1.0]);
        $this->assertEquals(['USD' => 5.0], $product->getPrices());
    }

    public function testSetName()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $product->setName('banana');
        $this->assertEquals('banana', $product->getName());
    }

    public function testGetTvaFood()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $this->assertEquals(0.1, $product->getTVA());
    }

    public function testGetTvaNotFood()
    {
        $product = new Product('apple', ['USD' => 5.0], 'other');
        $this->assertEquals(0.2, $product->getTVA());
    }

    public function listCurrencies()
    {
        $currencies = ['USD'];
        $product = new Product('apple', ['USD' => 5.0], 'other');
        $this->assertEquals($currencies, $product->listCurrencies());
    }

    public function testGetPrice()
    {
        $product = new Product('apple', ['USD' => 5.0, 'EUR' => 4.50], 'food');
        $this->assertEquals(4.5, $product->getPrice('EUR'));
    }

    public function testGetPriceCurrencyInvalid()
    {
        $product = new Product('apple', ['USD' => 5.0, 'EUR' => 4.50], 'food');
        $this->expectException(\Exception::class);
        $product->getPrice('PHP');
    }

    public function testGetPriceCurrencyNotAvailable()
    {
        $product = new Product('apple', ['USD' => 5.0], 'food');
        $this->expectException(\Exception::class);
        $product->getPrice('EUR');
    }
}
