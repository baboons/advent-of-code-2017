<?php

$input = include 'utils/input.php';

function solve(int $value): int {
    $x = 2;
    $y = 2;

    $grid = [];
    for ($i = 0; $i <= (2 * $y); $i++) {
        $grid[] = [];
    }
    $grid[$x][$y] = 1;
    $width = 1;

    $calculateGrid = function($grid, $x, $y) {
        $sum = 0;

        $sum += ($grid[$x - 1][$y] ?? 0);
        $sum += ($grid[$x - 1][$y + 1] ?? 0);
        $sum += ($grid[$x - 1][$y - 1] ?? 0);
        $sum += ($grid[$x][$y + 1] ?? 0);
        $sum += ($grid[$x][$y - 1] ?? 0);
        $sum += ($grid[$x + 1][$y] ?? 0);
        $sum += ($grid[$x + 1][$y - 1] ?? 0);
        $sum += ($grid[$x + 1][$y + 1] ?? 0);

        return $sum;
    };

    while (true) {
        $width += 2;

        $y++; // right
        $grid[$x][$y] = $calculateGrid($grid, $x, $y);
        if ($grid[$x][$y] > $value) {
            return $grid[$x][$y];
        }

        // go up (but not too much)
        for ($i = 0; $i < $width - 2; $i++) {
            $x--;

            $grid[$x][$y] = $calculateGrid($grid, $x, $y);
            if ($grid[$x][$y] > $value) {
                return $grid[$x][$y];
            }
        }

        // go left
        for ($i = 0; $i < $width - 1; $i++) {
            $y--;

            $grid[$x][$y] = $calculateGrid($grid, $x, $y);
            if ($grid[$x][$y] > $value) {
                return $grid[$x][$y];
            }
        }

        // go down
        for ($i = 0; $i < $width - 1; $i++) {
            $x++;

            $grid[$x][$y] = $calculateGrid($grid, $x, $y);
            if ($grid[$x][$y] > $value) {
                return $grid[$x][$y];
            }
        }

        // go right
        for ($i = 0; $i < $width - 1; $i++) {
            $y++;

            $grid[$x][$y] = $calculateGrid($grid, $x, $y);
            if ($grid[$x][$y] > $value) {
                return $grid[$x][$y];
            }
        }
    }

    return -1;
}

echo solve($input) . PHP_EOL;