<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignPatternTest extends TestCase
{
    /**
     * @test
     */
    public function it_process_order_in_queued()
    {
        $newOrder = new PhysicalProductOrdering();
        $newOrder->process();
        $this->assertTrue($newOrder->queued);
    }
}

abstract class Ordering{
    public $queued = false;
    abstract function availability();
    public function queued(){
        $this->queued = true;
    }
    public function process(){
        try{
            $this->availability();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
        $this->queued();
    }
}

class PhysicalProductOrdering extends Ordering{
    public $inventory = 10;
    public function availability()
    {
        if ($this->inventory == 0){
            throw new \Exception('there is not any product in store house');
        }
    }
}

class DigitalProductOrdering extends Ordering{
    public $isAvailable = true;
    public function availability()
    {
        if (!$this->isAvailable){
            throw new \Exception('you can not download it yet');
        }
    }
}
