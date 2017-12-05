<?php

$input = include 'utils/input.php';

function solve(int $value) : int
{
    $counter = 1;
    $turns = 0;
    $x = 0;
    $y = 0;
    
    while ($counter < $value) {
        $length = (floor($turns/2)) +1;
        for ($i=0; $i < $length && $counter !== $value; $i++) {
            
            switch ($turns % 4) {
                case 0:
                    $x++;
                    break;
                case 1:
                    $y++;
                    break;
                case 2:
                    $x--;
                    break;
                default:
                    $y--;
                    break;
            }
            $counter++;
        }
        $turns++;
    }

    return abs($x) + abs($y);
}

echo solve($input) . PHP_EOL;