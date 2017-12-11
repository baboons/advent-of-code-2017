<?php

$input = include 'utils/input.php';

$directions = explode(',', $input);

$x = $y = $z = 0;

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
}

echo (abs($x) + abs($y) + abs($z)) / 2;
