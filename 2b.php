<?php
include 'utilities.php';

$rows = explode("\n", input());
$checksum = 0;

foreach ($rows as $row) {
    $values = preg_split('/\s+/', trim($row));

    foreach ($values as $i => $value) {
        foreach ($values as $j => $check) {

            if ($j === $i) continue;

            $result = $value / $check;

            if(is_int($result)) {
                $checksum += $result;
            }

            continue;
        }
    }
}

echo $checksum . PHP_EOL;