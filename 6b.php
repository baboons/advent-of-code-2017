<?php
include 'utilities.php';

$blocks = preg_split('/\s+/', input());
$banks = count($blocks);
$combinations = [];
$steps = 0;

while (true) {

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

    if (isset($combinations[serialize($blocks)])) {
        $steps = $steps - $combinations[serialize($blocks)];
        break;
    }

    $combinations[serialize($blocks)] = $steps;

}

echo $steps . PHP_EOL;