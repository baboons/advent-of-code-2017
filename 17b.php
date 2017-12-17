<?php
include 'utilities.php';

$input = input();
$next = 1;
$index = $zeroPos = $afterZero = 0;

while ($next <= 50000000) {
    $index = ($index + $input % $next) % $next;

    if ($index === $zeroPos) {
        $afterZero = $next;
    }

    $next++;
    $index = ($index + 1) % $next;
}

echo $afterZero . PHP_EOL;