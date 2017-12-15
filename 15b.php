<?php
include 'utilities.php';

define('MILLION',   1000 * 1000);
define('FACTOR_A',  16807);
define('FACTOR_B',  48271);
define('DIV',       2147483647);

preg_match_all("#\d+#", input(), $matches);

[$a, $b] = current($matches);

$count = $sum = 0;
$binaryA = $binaryB = false;

while($count < 5 * MILLION) {

    if (!$binaryA) {
        $a = $a * FACTOR_A % DIV;

        if ($a % 4 === 0) {
            $binaryA = str_pad(substr(decbin($a), -16), 16, 0, STR_PAD_LEFT);
        }

    } elseif (!$binaryB) {
        $b = $b * FACTOR_B % DIV;

        if ($b % 8 === 0) {
            $binaryB = str_pad(substr(decbin($b), -16), 16, 0, STR_PAD_LEFT);
        }
    }

    if($binaryA && $binaryB) {
        $count++;

        if($binaryA === $binaryB) {
            $sum++;
        }

        $binaryA = false;
        $binaryB = false;
    }
}

echo $sum . PHP_EOL;