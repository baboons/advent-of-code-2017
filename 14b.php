<?php

$input = include 'utils/input.php';

$hashes = [];
$regions = 0;

foreach (range(0, 127) as $row => $iteration) {

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

    $binary = '';

    for ($i = 0; $i < 16; $i++) {

        $value = 0;

        for ($j = 0; $j < 16; $j++) {
            $value ^= $list[$i * 16 + $j];
        }

        $bin = str_pad(decbin($value), 8, '0', STR_PAD_LEFT );
        $binary .= $bin;
    }

    for ($b = 0; $b < 128; $b++) {
        $grid[$row][$b] = $binary[$b] ? 1 : 0;
    }
}

foreach (range(0, 127) as $y) {
    foreach (range(0, 127) as $x) {

        if ($grid[$y][$x] === 1) {
            $regions++;
            contageon($grid, $x, $y);
        }
    }
}

function contageon(&$grid, $x, $y) {
    $explore = [[$x, $y]];

    while (count($explore) > 0) {
        [$x, $y] = array_shift($explore);

        if ($x < 0 || $x >= 128) continue;
        if ($y < 0 || $y >= 128) continue;

        if($grid[$y][$x] === 1) {
            $grid[$y][$x] = 2;

            $explore[] = [$x+1, $y];
            $explore[] = [$x-1, $y];
            $explore[] = [$x, $y+1];
            $explore[] = [$x, $y-1];
        }
    }
}

echo $regions . PHP_EOL;