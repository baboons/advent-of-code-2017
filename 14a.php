<?php
include 'utilities.php';

$input = input();
$hashes = [];

foreach (range(0, 127) as $iteration) {
    $hashes[] = knotHash("$input-$iteration");
}

$used = array_map(function ($v) {
    $result = '';
    foreach (str_split($v) as $c) {
        $result .= str_pad(base_convert($c, 16, 2), 4, '0', STR_PAD_LEFT);
    }
    return substr_count($result, '1');
}, $hashes);

echo array_sum($used) . PHP_EOL;
