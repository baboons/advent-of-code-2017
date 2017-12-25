<?php
include 'utilities.php';

$lines = array_filter(array_map(function ($line) {
    return trim($line, ":.-");
}, explode(PHP_EOL, input())));

$start  = substr(array_shift($lines), -1);
$steps  = explode(' ', array_shift($lines))[5];
$chunks = array_chunk($lines, 9);
$moves = [];

foreach ($chunks as $chunk) {
    $state = substr($chunk[0], -1);
    foreach ([0, 4] as $offset) {
        $value = substr($chunk[1 + $offset], -1);
        $moves[$state][$value] = [
            'write' => substr($chunk[2 + $offset], -1),
            'move'  => strpos($chunk[3 + $offset], 'left') !== false ? -1 : 1,
            'state' => substr($chunk[4 + $offset], -1),
        ];
    }
}

$pos   = 0;
$tapes  = [$pos => 0];
$state = $start;

for ($i=0; $i<$steps; $i++) {
    $value       = $tapes[$pos] ?? 0;
    $tapes[$pos] = $moves[$state][$value]['write'];
    $pos        += $moves[$state][$value]['move'];
    $state       = $moves[$state][$value]['state'];
}

echo array_sum($tapes) . PHP_EOL;