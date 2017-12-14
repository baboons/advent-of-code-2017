<?php
include 'utilities.php';

$seen = [0];
$programs = [];

foreach (explode("\n", input()) as $row) {
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

solve(0, $programs, $seen);

echo count($seen) . PHP_EOL;