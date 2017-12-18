<?php
include 'utilities.php';

preg_match_all("#^(\w{3})\s+(\w)(:?.*)$#m", input(), $program);

$register = [
    'sent' => 0
];

for($i=0; $i < count($program[0]); $i++) {
    $op = $program[1][$i];
    $target = $program[2][$i];
    $value = trim($program[3][$i]);

    if(!isset($register[$target])) {
        $register[$target] = 0;
    }

    if (!empty($value)) {
        $value = is_numeric($value) ? (int) $value : (int) $register[$value];
    }

    switch ($op) {
        case 'set';
            $register[$target] = $value;
            break;
        case 'add';
            $register[$target] += $value;
            break;
        case 'mul';
            $register[$target] *= $value;
            break;
        case 'mod';
            $register[$target] %= $value;
            break;
        case 'snd':
            $register['sent'] = $register[$target];
            break;
        case 'rcv';
            if($register[$target] != 0) {
                break 2;
            }
            break;
        default:
            if ($register[$target] > 0) {
                $i += $value - 1;
            }
            break;
    }
}

echo $register['sent'] . PHP_EOL;