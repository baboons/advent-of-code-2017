<?php

$input = include 'utils/input.php';
$rows = explode("\n", $input);

$steps = 0;
$i = 0;

while ($i < count($rows)) {

    $value = (int) $rows[$i];
    $rows[$i]++;

    if($value !== 0) {
        $i += $value;
    }

    $steps++;
}

echo $steps . PHP_EOL;