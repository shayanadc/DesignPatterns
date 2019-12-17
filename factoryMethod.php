<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignPatternTest extends TestCase
{
    /**
     * @test
     */
    public function it_converts_array_to_string_for_logging()
    {
        $data = ['message' => 'Error occurred...'];
        $service = new ErrorLogDisplayService();
        $messageToLog = $service->display($data);
        $this->assertEquals('Error occurred...', $messageToLog);


    }
}

interface Parser{
    public function parse(array $data);
}

class LogParser implements Parser{
    public function parse($data)
    {
        return implode( ",", $data);
    }
}

class ResponseParser implements Parser{
    public function parse($data)
    {
        return json_encode($data);
    }
}
abstract class DisplayService{

    public function display($data){

        $parser = $this->getParser();
        return $parser->parse($data);

    }
    abstract function getParser(): Parser;
}

class ErrorLogDisplayService extends DisplayService{

    public function getParser(): Parser{
        return new LogParser();
    }
}

class ResponseJsonDisplayService extends DisplayService{

    public function getParser(): Parser{
        return new ResponseParser();
    }
}
