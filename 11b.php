<?php

$input = include 'utils/input.php';

$directions = explode(',', $input);

$furthest = $x = $y = $z = 0;

foreach($directions as $direction) {
    switch ($direction) {
        case "n":
            $x++;
            $z--;
            break;
        case "s":
            $z++;
            $x--;
            break;
        case "ne":
            $x++;
            $y--;
            break;
        case "nw":
            $y++;
            $z--;
            break;
        case "se":
            $z++;
            $y--;
            break;
        case "sw":
            $y++;
            $x--;
            break;
    }

    if (($distance = distance($x, $y, $z)) > $furthest) {
        $furthest = $distance;
    }
}

function distance($x, $y, $z) {
    return (abs($x) + abs($y) + abs($z)) / 2;
}

echo $furthest . PHP_EOL;