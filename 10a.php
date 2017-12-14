<?php
include 'utilities.php';

$size = 256;

$lengths = explode(',', input());
$skip = $current = 0;
$list = range(0, $size-1);

foreach ($lengths as $l => $length) {

    $temp = $list;

    for ($round = 0; $round < $length; $round++) {
        $temp[($current + $round) % $size] = $list[($current + ($length % $size) - $round - 1) % $size];
    }

    $current += ($length + $skip) % $size;
    $skip++;

    $list = $temp;
}

echo $list[0] * $list[1] . PHP_EOL;