<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Collection;

class DesignPatternTest extends TestCase
{
    /**
     * @test
     */
    public function it_gets_one_instance_for_each_call()
    {
        $db = new DBSalesData();
        $new = new FilterSalesData($db);
        $result = $new->greaterThan(2000);
        $this->assertSame(array_values([2000, 3000, 4000, 5000]), array_values($result));
    }
}

class FilterSalesData extends FilterSalesRepo{
    public function greaterThan($price){
        return array_filter($this->getSalesData(), function ($item) use ($price){
            return $item >= $price;
        });
    }
}

abstract class FilterSalesRepo{
    public $repo;
    public $salesData;
    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return array
     */
    protected function getSalesData(){
        $this->salesData = $this->repo->getData();
        return $this->salesData;
    }
}


interface Repo{
    public function getData();
}

class DBSalesData implements Repo {
    public function getData()
    {
        return collect([1000, 2000, 3000, 4000, 5000])->toArray();
    }
}

class CSVSalesData implements Repo {
    public function getData()
    {
        return [1000, 2000, 3000, 4000, 5000];
    }
}
