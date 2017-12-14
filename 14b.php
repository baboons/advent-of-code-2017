<?php
include 'utils/functions.php';

$input = include 'utils/input.php';

$grid = [];
$regions = 0;

foreach (range(0, 127) as $row => $iteration) {
    $hash = knotHash("$input-$iteration", true);

    for ($b = 0; $b < 128; $b++) {
        $grid[$row][$b] = $hash[$b] ? 1 : 0;
    }
}

foreach (range(0, 127) as $r) {
    foreach (range(0, 127) as $c) {
        if ($grid[$r][$c] === 1) {
            $regions++;
            $explore = [[$c, $r]];

            while (count($explore) > 0) {
                [$x, $y] = array_shift($explore);

                if ($x < 0 || $x >= 128) continue;
                if ($y < 0 || $y >= 128) continue;

                if ($grid[$y][$x] === 1) {
                    $grid[$y][$x] = 2;
                    $explore[] = [$x+1, $y];
                    $explore[] = [$x-1, $y];
                    $explore[] = [$x, $y+1];
                    $explore[] = [$x, $y-1];
                }
            }
        }
    }
}

echo $regions . PHP_EOL;