<?php
include 'utilities.php';

$lines = explode("\n", input());
$letters = [];

$map = array_map(function ($v) {
    return str_split($v);
}, $lines);

array_shift($map);

$start = [0, array_search("|",$map[0]), 'down'];

puzzle($map, $start, $letters);
echo implode('', $letters) . "\n";

function puzzle($map, $position, &$letters)
{
    $next = false;
    [$y, $x, $direction] = $position;

    $char = $map[$y][$x];
    if ($char == ' ') {
        return false;
    }

    if (!in_array($char, ['-', '|', '+', ' '])) {
        $letters[] = $char;
    }

    if ($char == "+") {
        switch ($direction) {
            case 'right':
            case 'left':
                if (!isset($map[$y - 1][$x]) || $map[$y - 1][$x] === ' ') {
                    $next = [$y + 1, $x, 'down'];
                } else {
                    $next = [$y - 1, $x, 'up'];
                }
                break;
            case 'up':
            default:
            case 'down':
                if (!isset($map[$y][$x - 1]) || $map[$y][$x - 1] === ' ') {
                    $next = [$y, $x + 1, 'right'];
                } else {
                    $next = [$y, $x - 1, 'left'];
                }
        }

        return puzzle($map, $next, $letters);
    } else {
        switch ($direction) {
            case 'right':
                $next = [$y, $x + 1, $direction];
                break;
            case 'left':
                $next = [$y, $x - 1, $direction];
                break;
            case 'up':
                $next = [$y - 1, $x, $direction];
                break;
            case 'down':
                $next = [$y + 1, $x, $direction];
                break;
        }

    }

    puzzle($map, $next, $letters);
}