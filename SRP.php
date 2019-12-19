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
        $csvRepo = new CSVSalesRepository();
        $report = new SalesReporter($csvRepo);
        $jsonReportMaker = new JsonSalesFormatter();
        $jsonReport = $report->greaterThan(11000, $jsonReportMaker);
        $this->assertEquals("[{\"price\":12000},{\"price\":21000},{\"price\":20000}]", $jsonReport);



        $dbRepo = new DBSalesRepository();
        $report = new SalesReporter($dbRepo);
        $stringReportMaker = new StringSalesFormatter();
        $stringReport = $report->greaterThan(11000, $stringReportMaker);
        $this->assertEquals("12000,21000,20000", $stringReport);
    }
}


abstract class FilterSalesRepo{
    public $repo;
    public function greaterThan($data)
    {
        return array_filter($this->getSales(), function ($item) use ($data){
            return $item['price'] >= $data;
        });
    }
}

interface SalesRepository{
    public function getSales();
}

class CSVSalesRepository extends FilterSalesRepo implements SalesRepository {
    public function getSales()
    {
        // retrieve data from CSV
        return [['price' => 12000],['price' => 21000],['price' => 20000],['price' => 10000]];
    }
}
class DBSalesRepository extends FilterSalesRepo implements SalesRepository {
    public function getSales()
    {
        // retrieve data from DB
        return [['price' => 12000],['price' => 21000],['price' => 20000],['price' => 10000]];
    }

}
class SalesReporter{
    public $repo;
    public function __construct(FilterSalesRepo $repository)
    {
        $this->repo = $repository;
    }


    public function greaterThan($price, SalesFormatter $formatter){
        $data = $this->repo->greaterThan($price);
        return $formatter->format($data);

    }
}
interface SalesFormatter{
    public function format(array $data);
}

class JsonSalesFormatter implements SalesFormatter {
    public function format($data)
    {
        return json_encode($data);
    }
}

class StringSalesFormatter implements SalesFormatter {
    public function format($data)
    {
        return implode(',', array_map(function($el){ return $el['price']; }, $data));
    }
}
