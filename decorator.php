<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DesignPatternTest extends TestCase
{
    /**
     * @test
     */
    public function it_return_product_cost_with_features()
    {
        $baseProduct = new Book();
        $epubFeature = new EPub($baseProduct);
        $bestSeller = new BestSeller($epubFeature);
        $this->assertEquals(3500, $bestSeller->getCost());

    }
}

interface Product{
    public function getCost();
}

class Book implements Product{
    public $cost = 3000;
    public function getCost()
    {
        return $this->cost;
    }
}

abstract class BookFeature implements Product{

    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    abstract function getCost();
}


class EPub extends BookFeature{

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function getCost()
    {
        return $this->product->getCost() /2;
    }
}

class BestSeller extends BookFeature{
    public $cost = 2000;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function getCost()
    {
        return $this->product->getCost() + $this->cost;
    }
}
