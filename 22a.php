<?php
include 'utilities.php';

$grid = [];
$lines = explode("\n", input());

$half = intval(floor(count($lines) / 2));

for ($i = $half*-1; $i <= $half; $i++) {
    $line_chars = str_split($lines[$i+$half]);

    for ($j = $half*-1; $j <= $half; $j++) {
        $grid[$i][$j] = $line_chars[$j+$half];
    }
}

$burst = $infection = $x = $y = 0;
$direction = 'up';

while ($burst < 10000) {
    if (!isset($grid[$x][$y])) {
        $grid[$x][$y] = '.';
    }

    if ($grid[$x][$y] === '.') {
        $grid[$x][$y] = '#';
        $infection++;

        switch ($direction) {
            case 'up':
                $y--;
                $direction = 'left';
                break;

            case 'right':
                $x--;
                $direction = 'up';
                break;

            case 'down':
                $y++;
                $direction = 'right';
                break;

            case 'left':
                $x++;
                $direction = 'down';
                break;
        }
    } else {
        $grid[$x][$y] = '.';

        switch ($direction) {
            case 'up':
                $y++;
                $direction = 'right';
                break;

            case 'right':
                $x++;
                $direction = 'down';
                break;

            case 'down':
                $y--;
                $direction = 'left';
                break;

            case 'left':
                $x--;
                $direction = 'up';
                break;
        }
    }

    $burst++;
}

echo $infection . PHP_EOL;
