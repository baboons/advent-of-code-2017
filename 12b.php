<?php

$input = include 'utils/input.php';

$seen = [0];
$programs = $groups = [];

foreach (explode("\n", $input) as $row) {
    [$id, $parts] = explode(" <-> ", $row);
    $programs[$id] = explode(', ', $parts);
}

function solve($n, &$programs, &$seen) {
    foreach ($programs[$n] as $id) {
        if (!in_array($id, $seen )) {
            $seen[] = $id;
            solve($id, $programs, $seen);
        }
    }
};

foreach ($programs as $x => $y) {
    solve($x, $programs, $seen);
    $groups[serialize($seen)] = true;
}

echo count($groups) . PHP_EOL;