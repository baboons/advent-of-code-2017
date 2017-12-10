<?php

$input = include 'utils/input.php';

$hash = '';
$size = 256;
$list = range(0, $size-1);
$lengths = [];
$skip = $current = 0;

function solve($input, $lengths, &$list, &$skip, &$current, $size = 256) {

    foreach ($lengths as $l => $length) {

        $temp = $list;

        for ($round = 0; $round < $length; $round++) {
            $temp[($current + $round) % $size] = $list[($current + ($length % $size) - $round - 1) % $size];
        }

        $current += ($length + $skip) % $size;
        $skip++;

        $list = $temp;
    }
}


for ($i = 0; $i < strlen($input); $i++) {
    $lengths[] = ord($input[$i]);
}

$lengths = array_merge($lengths, [17, 31, 73, 47, 23]);

for ($i = 0; $i < 64; $i++) {
    solve($input, $lengths, $list, $skip, $current);
}

for ($i = 0; $i < 16; $i++) {

    $value = 0;

    for ($j = 0; $j < 16; $j++) {
        $value ^= $list[$i * 16 + $j];
    }

    $hash .= str_pad(dechex($value), 2, '0');
}

echo $hash . PHP_EOL;