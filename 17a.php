<?php
include 'utilities.php';

$input = input();
$buffer = [0];
$next = 1;
$index = 0;

while ($next <= 2017) {
    $length = count($buffer);
    $index = ($index + $input % $length) % $length;
    array_splice($buffer, $index + 1, 0, $next);
    $next++;

    $index = ($index + 1) % count($buffer);
}

echo $buffer[array_search(2017, $buffer)+1] . PHP_EOL;