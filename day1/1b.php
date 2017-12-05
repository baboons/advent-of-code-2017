<?php

$input = trim(file_get_contents(__DIR__ . '/input.txt'));

$sum = 0;
$length = strlen($input);

for ($i=0; $i<$length; $i++) {
    $pos = ($i + ($length / 2)) % $length;

    if ($input[$i] === $input[$pos]) {
        $sum += $input[$i];
    }
}

echo $sum . PHP_EOL;
