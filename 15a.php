<?php
include 'utilities.php';

define('MILLION',   1000 * 1000);
define('FACTOR_A',  16807);
define('FACTOR_B',  48271);
define('DIV',       2147483647);

preg_match_all("#\d+#", input(), $matches);

[$a, $b] = current($matches);

$count = 0;

for ($i=0; $i < 40 * MILLION; $i++) {
    $a = $a * FACTOR_A % DIV;
    $b = $b * FACTOR_B % DIV;

    if (($a & 0xffff) === ($b & 0xffff)) {
        $count++;
    }
}

echo $count . PHP_EOL;