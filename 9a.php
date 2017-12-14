<?php
include 'utilities.php';

$garbage = false;
$ignore = 1;
$level = 0;
$score = 0;

foreach (str_split(input()) as $char) {
    $ignore += 1;

    if ($ignore >= 2 && $garbage && $char === '>') {
        $garbage = false;
    } elseif ($ignore >= 2 && $char === '!') {
        $ignore = 0;
    } elseif ($ignore >= 2 && !$garbage) {
        switch($char) {
            case '{':
                $level += 1;
                break;
            case '}':
                $score += $level;
                $level -= 1;
                break;
            case '<':
                $garbage = true;
                break;
        }
    }
}

echo $score . PHP_EOL;