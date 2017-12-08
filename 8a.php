<?php

$input = include 'utils/input.php';

$register = [];

foreach (explode("\n", $input) as $row) {

    [$var, $op, $value, $if, $ifVar, $ifOp, $ifValue] = preg_split("/\s+/", $row);

    if(!isset($register[$var])) $register[$var] = 0;
    if(!isset($register[$ifVar])) $register[$ifVar] = 0;

    $continue = false;

    switch($ifOp) {
        case '>':
            if ($register[$ifVar] > $ifValue) $continue = true;
            break;
        case '<':
            if ($register[$ifVar] < $ifValue) $continue = true;
            break;
        case '>=':
            if ($register[$ifVar] >= $ifValue) $continue = true;
            break;
        case '<=':
            if ($register[$ifVar] <= $ifValue) $continue = true;
            break;
        case '==':
            if ($register[$ifVar] == $ifValue) $continue = true;
            break;
        case '!=':
            if ($register[$ifVar] != $ifValue) $continue = true;
            break;
        default:
            die("Invalid operand $ifOp" . PHP_EOL);
            break;
    }

    if (!$continue) {
        continue;
    }

    switch ($op) {
        case 'inc':
            $register[$var] += $value;
            break;
        case 'dec':
            $register[$var] -= $value;
            break;
    }

}

echo max($register) . PHP_EOL;

