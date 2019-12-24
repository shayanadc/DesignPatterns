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
        $new = new SpecificProduct();
        $new->manage();
        $this->assertEquals('delivered to post office', $new->state);

    }
}
interface Manageable{
    public function manage();
}
interface Processing{
    public function process();
}
interface Shipping{
    public function ship();
}

class DigitalProduct implements Processing, Manageable{
    public $state = 'waiting';
    public function process()
    {
        $this->state = 'queued';
    }
    public function manage()
    {
        $this->process();
    }
}

class PhysicalProduct implements Shipping, Manageable {
    public $state = 'waiting';

    public function ship()
    {
        $this->state = 'delivered to post office';
    }
    public function manage()
    {
        $this->ship();
    }
}

class SpecificProduct implements Shipping, Processing , Manageable {
    public $state = 'waiting';
    public $inventory = 10;
    public function ship()
    {
        $this->state = 'delivered to post office';
    }
    public function process()
    {
        $this->state = 'queued';
    }
    public function manage()
    {
        $this->process();
        
        //simulate queue
        sleep(1);

        if($this->inventory > 0)
            $this->ship();
    }
}
