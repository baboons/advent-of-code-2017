<?php

$input = include 'utils/input.php';

$hashes = [];

foreach (range(0, 127) as $iteration) {

    $hash = '';
    $size = 256;
    $list = range(0, $size - 1);
    $lengths = [];
    $skip = $current = 0;
    $key = "$input-$iteration";
    for ($i = 0; $i < strlen($key); $i++) {
        $lengths[] = ord($key[$i]);
    }

    $lengths = array_merge($lengths, [17, 31, 73, 47, 23]);

    for ($i = 0; $i < 64; $i++) {
        foreach ($lengths as $l => $length) {

            $temp = $list;

            for ($round = 0; $round < $length; $round++) {
                $temp[($current + $round) % $size] = $list[($current + ($length % $size) - $round - 1) % $size];
            }

            $current += ($length + $skip) % $size;
            $skip++;

            $list = $temp;
        }
    }

    for ($i = 0; $i < 16; $i++) {

        $value = 0;

        for ($j = 0; $j < 16; $j++) {
            $value ^= $list[$i * 16 + $j];
        }

        $hash .= str_pad(dechex($value), 2, '0');
    }

    $hashes[] = $hash;

}

$used = array_map(function ($v) {
    $result = '';
    foreach (str_split($v) as $c) {
        $result .= str_pad(base_convert($c, 16, 2), 4, '0', STR_PAD_LEFT);
    }
    return substr_count($result, '1');
}, $hashes);

echo array_sum($used) . PHP_EOL;
