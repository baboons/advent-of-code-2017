<?php
include 'utilities.php';

$dancers   = range('a', 'p');
$moves     = explode(',', input());
$start     = implode('', $dancers);
$rounds    = 1000000000;
$rotations = 0;

/**
 * @param array $dancers
 * @param array $moves
 * @return array
 */
function dance(array $dancers, array $moves): array
{
    foreach ($moves as $move) {
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

    return $dancers;
}

for ($i=1; $i<$rounds; $i++) {
    $dancers = dance($dancers, $moves);

    if (implode("", $dancers) === $start) {
        $rotations = $i;
        break;
    }
}

for( $i=0; $i < ($rounds - $rotations) % $rotations; $i++) {
    $dancers = dance($dancers, $moves);
}


echo implode($dancers) . PHP_EOL;