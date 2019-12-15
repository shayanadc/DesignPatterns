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
    public function it_returns_string_in_upper_case()
    {
        $formatter = new CapitalTXTFormatter();
        $editor = new TextEditor($formatter);
        $published = $editor->publishText('txt');
        $this->assertEquals('TXT', $published);
    }
}

class CapitalTXTFormatter implements TextFormatter{

    public function publish($data)
    {
        return strtoupper($data);
    }
}

class LowerTXTFormatter implements TextFormatter{

    public function publish($data)
    {
        return strtoupper($data);
    }
}

interface TextFormatter{
    public function publish($data);

}

class TextEditor {
    public $formatter;
    public function __construct(TextFormatter $textFormatter)
    {
        $this->formatter = $textFormatter;
    }
    public function publishText($data){
        // publish based on chosen strategy
        return $this->formatter->publish($data);
    }
}
