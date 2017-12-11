<?php

$input = include 'utils/input.php';

$directions = explode(',', $input);
$furthest = $x = $y = 0;

$movements = [
    'nw' => [-1,1],
    'n'  => [0,2],
    'ne' => [1,1],
    'sw' => [-1,-1],
    's'  => [0,-2],
    'se' => [1,-1],
];

foreach ($directions as $direction) {
    $x += $movements[$direction][0];
    $y += $movements[$direction][1];

    if (($distance = (abs($x) + abs($y)) / 2) > $furthest) {
        $furthest = $distance;
    }
}

echo $furthest . PHP_EOL;