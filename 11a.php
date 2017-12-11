<?php

$input = include 'utils/input.php';

$x = $y = 0;

$movements = [
    'nw' => [-1,1],
    'n'  => [0,2],
    'ne' => [1,1],
    'sw' => [-1,-1],
    's'  => [0,-2],
    'se' => [1,-1],
];

foreach (explode(',', $input) as $direction) {
    $x += $movements[$direction][0];
    $y += $movements[$direction][1];
}

echo (abs($x) + abs($y)) / 2 . PHP_EOL;