<?php
include 'utilities.php';

$rows = explode("\n", input());

$register = [
    'sent' => 0
];

for($i=0; $i < count($rows); $i++) {
    $line = $rows[$i];
    $values = preg_split('/\s+/', trim($line));

    if (count($values) === 3) {
        [$op, $target, $value] = $values;
    } else {
        [$op, $target] = $values;
    }

    if(!isset($register[$target])) {
        $register[$target] = 0;
    }

    switch ($op) {
        case 'set';
            $register[$target] = getValue($value, $register);
            break;
        case 'add';
            $register[$target] += getValue($value, $register);
            break;
        case 'mul';
            $register[$target] *= getValue($value, $register);
            break;
        case 'mod';
            $register[$target] %= getValue($value, $register);
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
            if (getValue($target, $register) > 0) {
                $i += getValue($value, $register) - 1;
            }
            break;
    }
}

function getValue(string $v, array $register): string {
    if (is_numeric($v)) {
        return (int) $v;
    }

    return $register[$v];
}

echo $register['sent'] . PHP_EOL;
