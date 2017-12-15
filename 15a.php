<?php
include 'utilities.php';

preg_match_all("#\d+#", input(), $matches);

[$a, $b] = current($matches);

$count = 0;

for ($i=0; $i < 40000000; $i++) {
    $a = $a * 16807 % 2147483647;
    $b = $b * 48271 % 2147483647;

    if (($a & 0xffff) === ($b & 0xffff)) {
        $count++;
    }
}

echo $count . PHP_EOL;