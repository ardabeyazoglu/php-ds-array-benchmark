<?php

namespace PhpDsArrayBenchmark\Tests;

use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;
use PhpBench\Benchmark\Metadata\Annotations\AfterMethods;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use PhpBench\Benchmark\Metadata\Annotations\OutputTimeUnit;
use SplFixedArray;
use Ds\Deque;

/**
 * @BeforeMethods({"init"})
 * @AfterMethods({"tearDown"})
 * @Iterations(5)
 * @Revs(50)
 * @OutputTimeUnit("milliseconds", precision=3)
 */
class ArrayBench
{
    private $data;
    private $count;
    private $colCount;

    public function init()
    {
        $this->data = require_once("data/sample_data.php");
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
            $row = [
                "cells" => []
            ];
            foreach ($values as $col => $value) {
                $row["cells"][] = [
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
            $data[] = $row;
        }

        return json_encode($data);
    }

    public function benchSplFixedArray()
    {
        $data = new SplFixedArray($this->count);
        foreach ($this->data as $key => $values) {
            $row = [
                "cells" => new SplFixedArray($this->colCount)
            ];
            $i = 0;
            foreach ($values as $col => $value) {
                $row["cells"][$i++] = [
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
            $data[$key] = $row;
        }

        return json_encode($data);
    }

    public function benchDsVector()
    {
        $data = new Deque();
        $data->allocate($this->count);
        foreach ($this->data as $values) {
            $row = [
                "cells" => new Deque()
            ];
            $row["cells"]->allocate($this->colCount);
            foreach ($values as $col => $value) {
                $row["cells"]->push([
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
            $data->push($row);
        }
        
        return json_encode($data);
    }

    
}
