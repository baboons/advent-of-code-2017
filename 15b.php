<?php
include 'utilities.php';

preg_match_all("#\d+#", input(), $matches);

[$a, $b] = current($matches);

$count = $sum = 0;

while ($count < 5000000) {

    while (true) {
        $a = $a * 16807 % 2147483647;
        if ($a % 4 === 0) {
            break;
        }
    }

    while (true) {
        $b = $b * 48271 % 2147483647;
        if ($b % 8 === 0) {
            break;
        }
    }

    if (($a & 0xffff) === ($b & 0xffff)) {
        $sum++;
    }

    $count++;
}

echo $sum . PHP_EOL;