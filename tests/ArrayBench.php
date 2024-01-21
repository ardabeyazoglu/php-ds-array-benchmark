<?php

namespace PhpDsArrayBenchmark;

use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;
use PhpBench\Benchmark\Metadata\Annotations\AfterMethods;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use PhpBench\Benchmark\Metadata\Annotations\OutputTimeUnit;
use SplFixedArray;
use Ds\Vector;

/**
 * @BeforeMethods({"init"})
 * @AfterMethods({"tearDown"})
 * @Iterations(3)
 * @Revs(100)
 * @OutputTimeUnit("milliseconds", precision=3)
 */
class ArrayBench
{
    private $data;
    private $count;

    public function init()
    {
        $this->data = range(1, 100000);
        $this->count = count($this->data);
    }

    public function tearDown()
    {
        $this->data = null;
    }

    public function benchArray()
    {
        $data = [];
        foreach ($this->data as $values) {
            $row = [];
            $data[] = $row;
        }

        return json_encode($data);
    }

    public function benchSplFixedArray()
    {
        $data = new SplFixedArray($this->count);
        foreach ($this->data as $values) {
            $row = [];
            $data[] = $row;
        }

        return json_encode($data);
    }

    public function _benchDsVector()
    {
        $data = new Vector();
        $data->allocate($this->count);
        foreach ($this->data as $values) {
            $row = [];
            $data->push($row);
        }
        
        return json_encode($data);
    }

    
}
