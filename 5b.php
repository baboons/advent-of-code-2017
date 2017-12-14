<?php
include 'utilities.php';

$rows = explode("\n", input());
$steps = $i = 0;

while ($i < count($rows)) {

    $value = (int) $rows[$i];

    if ($value > 2) {
        $rows[$i]--;
    } else {
        $rows[$i]++;
    }

    if($value !== 0) {
        $i += $value;
    }

    $steps++;
}

echo $steps . PHP_EOL;