<?php

$input = include 'utils/input.php';

$firewall = $depths = [];

foreach (explode("\n", $input) as $row) {
    [$layer, $depth] = explode(": ", $row);

    $firewall[$layer] = $depth === 1 ? 1 : ($depth - 1) * 2;
    $depths[$layer] = $depth;
}

$steps = max(array_flip($firewall));
$severity = 0;

for ($i=0; $i<=$steps; $i++) {
    if (isset($firewall[$i]) && ($i % $firewall[$i]) === 0) {
        $severity += $i * $depths[$i];
    }
}

echo $severity . PHP_EOL;