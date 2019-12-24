<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignPatternTest extends TestCase
{
    /**
     * @test
     */
    public function it_ship_or_queuing_product()
    {

        $cat = new CatProduct();
        $dog = new DogProduct();
        $order = new OrderProcessor();
        $order->addDetails($cat);
        $order->addDetails($dog);


        $this->assertFalse($order->isProcessed());
    }
}

class OrderProcessor{
    public $details = [];
    public function addDetails(OrderDetail $detail){
        $this->details[] = $detail;
    }
    public function isProcessed(){
        foreach ($this->details as $row){
            if(!$row->processed()) return false;
        }
        return true;

    }
}
interface OrderDetail{
    public function processed();
}
class CatProduct implements OrderDetail{
    public $processed = true;
    public function processed(){
        return $this->processed;
    }
}
class DogProduct implements OrderDetail{
    public function processed(){
        return false;
    }
}
