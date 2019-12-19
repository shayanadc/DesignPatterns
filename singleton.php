<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignPatternTest extends TestCase
{
    /**
     * @test
     */
    public function it_gets_one_instance_for_each_call()
    {
        $instance1 = DBConnection::getInstance();
        $instance2 = DBConnection::getInstance();
        $this->assertEquals($instance1,$instance2);

    }
}

class DBConnection{
    private static $instance = null;

    public function __construct()
    {
        return self::getInstance();
    }

    public static function getInstance()
    {
        if(!static::$instance)
        {
            static::$instance = new self();
        }

        return static::$instance;
    }
}
