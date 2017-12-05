<?php

$input = trim(file_get_contents(__DIR__ . '/input.txt'));
$rows = explode("\n", $input);

$count = 0;

foreach($rows as $row) {
    $words = preg_split('/\s+/', trim($row));

    if(count(array_unique($words)) === count($words)) {
        $count++;
    }
}

echo $count . PHP_EOL;