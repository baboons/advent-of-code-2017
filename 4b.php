<?php

$input = include 'utils/input.php';
$rows = explode("\n", $input);

$count = 0;

foreach ($rows as $row) {
    $words = preg_split('/\s+/', trim($row));

    foreach ($words as &$word) {
        $letters = str_split($word);
        sort($letters);
        $word = implode('', $letters);
    }

    if (count(array_unique($words)) === count($words)) {
        $count++;
    }
}

echo $count . PHP_EOL;