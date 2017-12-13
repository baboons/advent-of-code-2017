<?php

$input = include 'utils/input.php';

$firewall = $depths = [];

foreach (explode("\n", $input) as $row) {
    [$layer, $depth] = explode(": ", $row);

    $firewall[$layer] = $depth === 1 ? 1 : ($depth - 1) * 2;
    $depths[$layer] = $depth;
}

$steps = max(array_flip($firewall));
$offset = 0;

while (true) {
    $severity = 0;
    $invalid = false;

    for ($i=0; $i<=$steps; $i++) {
        if (isset($firewall[$i]) && (($i + $offset) % $firewall[$i]) === 0) {
            $invalid = true;
        }
    }

    if (!$invalid) {
        break;
    }

    $offset += 1;
}

echo $offset . PHP_EOL;