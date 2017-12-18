<?php
include 'utilities.php';

preg_match_all("#^(\w{3})\s+(\w)(:?.*)$#m", input(), $program);

define('A', 1);
define('B', 2);
define('LINES', count($program[0]));
define('STATE', [
    'terminated' => false,
    'waiting' => false,
    'queue' => [],
    'sent' => 0,
    'cursor' => 0
]);

$process = A;
$done = false;

$states = [
    A => STATE + ['register' => ['p' => 0]],
    B => STATE + ['register' => ['p' => 1]]
];

while (!$done) {

    $state =& $states[$process];

    if (!$state['terminated']) {

        $cursor =& $state['cursor'];
        $registers =& $state['register'];
        $queue =& $state['queue'];
        $sent =& $state['sent'];

        $op = $program[1][$cursor];
        $target = $program[2][$cursor];
        $value = trim($program[3][$cursor]);

        $state['waiting'] = false;

        if(!isset($registers[$target])) {
            $registers[$target] = 0;
        }

        if (!empty($value)) {
            $value = is_numeric($value) ? (int) $value : (int) $registers[$value];
        }

        switch ($op) {
            case 'set':
                $registers[$target] = $value;
                break;
            case 'add':
                $registers[$target] += $value;
                break;
            case 'mul':
                $registers[$target] *= $value;
                break;
            case 'mod':
                $registers[$target] %= $value;
                break;
            case 'snd':
                $queue[] = $registers[$target];
                $sent++;
                break;
            case 'rcv':
                $other = ($process == A ? B : A);
                if (count($states[$other]['queue']) > 0) {
                    $registers[$target] = array_shift($states[$other]['queue']);
                } else {
                    $state['waiting'] = true;
                }
                break;
            case 'jgz':
                $target = is_numeric($target) ? (int) $target : (int) $registers[$target];
                if ($target > 0) {
                    $cursor += $value - 1;
                }
                break;
        }

        if (!$state['waiting']) {
            $cursor++;
        }

        if ($cursor < 0 || $cursor >= LINES) {
            $state['terminated'] = true;
        }
    }

    $process = $process == A ? B : A;

    $done = ($states[A]['terminated'] || $states[A]['waiting']) &&
            ($states[B]['terminated'] || $states[B]['waiting']);
}

echo $states[B]['sent'] . PHP_EOL;