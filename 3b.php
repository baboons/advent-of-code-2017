<?php
declare(strict_types=1);

$input = (int) include 'utils/input.php';

function solve(int $puzzle) : int
{
    $grid = [];
    $x = $y = 0;
    $right = $up = $left = $down = 0;
    $stepRight = 1;
    $stepLeft = 2;
    $value = 0;

    $neighbors = [
        [0, 1],
        [1, 1],
        [1, 0],
        [1, -1],
        [0, -1],
        [-1, -1],
        [-1, 0],
        [-1, 1]
    ];

    while ($value <= $puzzle) {
        $value = 0;

        if ($x === 0 && $y === 0) {
            $value = 1;
        }

        foreach (neighbor($neighbors, $grid, $x, $y) as $i) {
            $value += $i;
        }

        $grid[$y][$x] = $value;

        if ($right < $stepRight) {
            $right++;
            $x++;
        } elseif ($up < $stepRight) {
            $up++;
            $y++;
        } elseif ($left < $stepLeft) {
            $left++;
            $x--;
        } elseif ($down < $stepLeft) {
            $down++;
            $y--;
        } else {
            $right = 0;
            $up = 0;
            $left = 0;
            $down = 0;
            $stepLeft += 2;
            $stepRight += 2;
        }
    }

    return $value;
}

function neighbor(array $neighbors, array $grid, int $x, int $y) : generator
{
    foreach ($neighbors as $neighbor) {
        if (isset($grid[$y + $neighbor[0]][$x + $neighbor[1]])) {
            yield $grid[$y + $neighbor[0]][$x + $neighbor[1]];
        }
    }
}

echo solve($input) . PHP_EOL;