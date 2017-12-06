<?php

$input = include 'utils/input.php';

$blocks = preg_split('/\s+/', $input);
$banks = count($blocks);
$combinations = [];
$steps = 0;
$unique = false;

while (!$unique) {

    $position = current(array_keys($blocks, max($blocks)));
    $value = $blocks[$position];

    $blocks[$position] = 0;

    while ($value > 0) {
        $position++;

        if ($position === $banks) {
            $position = 0;
        }

        $blocks[$position]++;
        $value--;
    }

    $steps++;

    $unique = in_array(serialize($blocks), $combinations);
    $combinations[] = serialize($blocks);

}

echo $steps . PHP_EOL;