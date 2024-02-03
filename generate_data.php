<?php

$csvPath = __DIR__ .  "/data/SampleCSVFile_10600kb.csv";
shell_exec("pigz -d -c $csvPath.gz > /tmp/test.unicode.csv");
//shell_exec("iconv -t UTF-8//IGNORE /tmp/test.encoded.csv -o test.unicode.csv");

$file = new SplFileObject("/tmp/test.unicode.csv", "r");
$file->setCsvControl(",");

$data = [];

while (!$file->eof()) {
    $row = $file->fgetcsv();
    $row2 = [];
    foreach ($row as $key => $value) {
        $row2["column$key"] = $value;
    }
    $data[] = $row2;
}

file_put_contents(__DIR__ . "/data/" . basename($csvPath) . ".php", "<?php \n return " . var_export($data, true) . ";");
