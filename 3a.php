<?php

$input = (int) include 'utils/input.php';

$counter = 1;
$turns = 0;
$x = 0;
$y = 0;

while ($counter < $input) {
    $length = floor($turns/2)+1;

    for ($i=0; $i < $length && $counter !== $input; $i++) {
        switch ($turns % 4) {
            case 0:
                $x++;
                break;
            case 1:
                $y++;
                break;
            case 2:
                $x--;
                break;
            default:
                $y--;
                break;
        }
        $counter++;
    }

    $turns++;
}

echo abs($x) + abs($y) . PHP_EOL;