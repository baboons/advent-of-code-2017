<?php
include 'utilities.php';

$h = 0;
for ($i = 106500; $i <= 123320; $i = $i + 17) {
    for ($j = 2; $j < $i; $j++) {
        if (($i % $j) === 0) {
            $h++;
            break;
        }
    }
}

echo $h . PHP_EOL;