<?php

$input = include 'utils/input.php';
$rows = explode("\n", $input);

$checksum = 0;

foreach ($rows as $row) {
    $values = preg_split('/\s+/', trim($row));
    $checksum += max($values) - min($values);
}

echo $checksum . PHP_EOL;