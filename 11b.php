<?php
include 'utilities.php';

$furthest = $x = $y = $z = 0;

$movements = [
    'n' =>  [1,  0, -1],
    'ne' => [1, -1,  0],
    'nw' => [0,  1, -1],
    's' =>  [-1, 0,  1],
    'se' => [0, -1,  1],
    'sw' => [-1, 1,  0],
];

foreach (explode(',', input()) as $direction) {
    $x += $movements[$direction][0];
    $y += $movements[$direction][1];
    $z += $movements[$direction][2];

    if (($distance = (abs($x) + abs($y) + abs($z)) / 2) > $furthest) {
        $furthest = $distance;
    }
}

echo $furthest . PHP_EOL;