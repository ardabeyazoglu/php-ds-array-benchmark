<?php

namespace PhpDsArrayBenchmark\Tests;

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
 * @Revs(10)
 * @OutputTimeUnit("milliseconds", precision=3)
 */
class ArrayBench
{
    private $data;
    private $count;
    private $colCount;

    public function init()
    {
        $data = require("data/sample_data.php");
        $this->data = array_merge($data, $data, $data, $data, $data, $data, $data, $data);
        $this->colCount = count($this->data[0]);
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
            $cells = [];
            foreach ($values as $col => $value) {
                $cells[] = [
                    "colspan" => 2,
                    "rowspan" => 4,
                    "column" => $col,
                    "value" => $value,
                    "styles" => [
                        "color" => "red",
                        "bold" => false
                    ],
                ];
            }
            $data[] = $cells;
        }

        //return $data;
        return json_encode($data);
    }

    public function benchSplFixedArray()
    {
        $data = new SplFixedArray($this->count);
        foreach ($this->data as $key => $values) {
            $cells = new SplFixedArray($this->colCount);
            $i = 0;
            foreach ($values as $col => $value) {
                $cells[$i++] = [
                    "colspan" => 2,
                    "rowspan" => 4,
                    "column" => $col,
                    "value" => $value,
                    "styles" => [
                        "color" => "red",
                        "bold" => false
                    ],
                ];
            }
            $data[$key] = $cells;
        }

        //return $data;
        return json_encode($data);
    }

    public function benchDsVector()
    {
        $data = new Vector();
        $data->allocate($this->count);
        foreach ($this->data as $values) {
            $cells = new Vector();
            $cells->allocate($this->colCount);

            foreach ($values as $col => $value) {
                $cells->push([
                    "colspan" => 2,
                    "rowspan" => 4,
                    "column" => $col,
                    "value" => $value,
                    "styles" => [
                        "color" => "red",
                        "bold" => false
                    ],
                ]);
            }
            $data->push($cells);
        }
        
        //return $data;
        return json_encode($data);
    }

    
}
