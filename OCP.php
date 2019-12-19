<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignPatternTest extends TestCase
{
    /**
     * @test
     */
    public function it_performs_sale_by_type()
    {
        $product = new PhysicalBook();
        $order = new OrderProcessor($product);
        $order->perform();
        $this->assertEquals('Queued', $order->state);
    }
}


interface OrderPerformer{
    public function perform();
}
class PDFBook implements OrderPerformer{
    public $state;
    public function perform()
    {
        $this->state = 'Delivered';
    }
}

class PhysicalBook implements OrderPerformer{
    public $state;
    public function perform()
    {
        $this->state = 'Queued';
    }
}
class OrderProcessor{
    public $state = 'waiting';
    public function __construct(OrderPerformer $order)
    {
        $this->order = $order;
    }
    public function perform(){
        $this->order->perform();
        $this->state = $this->order->state;
    }
}
