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
    public function it_returns_payment_gateway()
    {
        $mustFree = new DownloadableProduct();
        $adapter = new DownloadableToNonFreeAdapter($mustFree);
        $this->assertEquals('download link is up coming ...', $adapter->perform());
    }
}

interface MustPay{
    public function perform();
}

class NonFreeProduct implements MustPay {

    public function perform(){
        return 'redirect to payment gateway...';
    }

}

interface MustFree{
    public function getDownloadLink();
}

class DownloadableProduct implements MustFree{
    public function getDownloadLink(){
        return 'download link is up coming ...';
    }
}


class DownloadableToNonFreeAdapter implements MustPay {
    public $inst;
    public function __construct(MustFree $mustFree)
    {
        $this->inst = $mustFree;
    }

    public function perform(){
        return $this->inst->getDownloadLink();
    }
}
