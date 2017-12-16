<?php
include 'utilities.php';

$dancers = range('a', 'p');

foreach (explode(',', input()) as $move) {
    $action = substr($move, 0, 1);
    $info = substr($move, 1);

    switch ($action) {
        case 's':
            for($i=0; $i < $info; $i++) {
                array_unshift($dancers, array_pop($dancers));
            }
        break;

        case 'x':
            [$a, $b] = explode('/', $info);
            $temp = $dancers;

            $dancers[$a] = $temp[$b];
            $dancers[$b] = $temp[$a];
            break;

        case 'p':
            [$a, $b] = explode('/', $info);
            $temp = $dancers;


            $key1 = array_search ($a, $dancers);
            $key2 = array_search ($b, $dancers);
            $dancers[$key1] = $temp[$key2];
            $dancers[$key2] = $temp[$key1];
            break;
    }
}


echo implode($dancers) . PHP_EOL;