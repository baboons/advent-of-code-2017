<?php
include 'utilities.php';

$grid = [];
$lines = explode("\n", input());
$half = intval(floor(count($lines) / 2));

for ($i = $half * -1; $i <= $half; $i++) {
    $line_chars = str_split($lines[$i + $half]);

    for ($j = $half * -1; $j <= $half; $j++) {
        $grid[$i][$j] = $line_chars[$j + $half] === '.' ? 'C' : 'I';
    }
}

$burst = $infection = $x = $y = 0;
$direction = 'up';

while ($burst < 10000000) {
    if (!isset($grid[$x][$y])) {
        $grid[$x][$y] = 'C';
    }

    if ($grid[$x][$y] === 'C') {
        $grid[$x][$y] = 'W';

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
    } else if ($grid[$x][$y] === 'I') {
        $grid[$x][$y] = 'F';

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
    } else if ($grid[$x][$y] === 'W') {
        $grid[$x][$y] = 'I';
        $infection++;

        switch ($direction) {
            case 'up':
                $x--;
                break;

            case 'right':
                $y++;
                break;

            case 'down':
                $x++;
                break;

            case 'left':
                $y--;
                break;
        }
    } else if ($grid[$x][$y] === 'F') {
        $grid[$x][$y] = 'C';

        switch ($direction) {
            case 'up':
                $x++;
                $direction = 'down';
                break;

            case 'right':
                $y--;
                $direction = 'left';
                break;

            case 'down':
                $x--;
                $direction = 'up';
                break;

            case 'left':
                $y++;
                $direction = 'right';
                break;
        }
    }

    $burst++;
}

echo $infection . PHP_EOL;