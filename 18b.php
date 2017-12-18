<?php
include 'utilities.php';

define("A", 1);
define("B", 2);

$program = array_map(function ($line) {

    $values = preg_split('/\s+/', trim($line));

    if (count($values) === 3) {
        [$op, $target, $value] = $values;
    } else {
        [$op, $target] = $values;
    }

    return [
        'op' => $op,
        'target' => $target,
        'value' => (isset($value) ? $value : false)
    ];

}, explode("\n", input()));

$process = A;
$done = false;
$lines = count($program);

$states = [
    A => [
        'terminated' => false,
        'waiting' => false,
        'registers' => ['p' => 0],
        'queue' => [],
        'sent' => 0,
        'cursor' => 0
    ],
    B => [
        'terminated' => false,
        'waiting' => false,
        'registers' => ['p' => 1],
        'queue' => [],
        'sent' => 0,
        'cursor' => 0
    ]
];

while (!$done) {
    $state =& $states[$process];

    if (!$state['terminated']) {

        $cursor =& $state['cursor'];
        $registers =& $state['registers'];
        $queue =& $state['queue'];
        $sent =& $state['sent'];
        $step = $program[$cursor];
        $target = $step['target'];
        $value = $step['value'];

        $state['waiting'] = false;

        switch ($step['op']) {
            case 'set':
                $registers[$target] = getValue($process, $value);
                break;
            case 'add':
                $registers[$target] = getValue($process, $target) + getValue($process, $value);
                break;
            case 'mul':
                $registers[$target] = getValue($process, $target) * getValue($process, $value);
                break;
            case 'mod':
                $registers[$target] = getValue($process, $target) % getValue($process, $value);
                break;
            case 'snd':
                $queue[] = getValue($process, $target);
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
                if (getValue($process, $target) > 0) {
                    $cursor += getValue($process, $value) - 1;
                }
                break;
        }

        if (!$state['waiting']) {
            $cursor++;
        }

        if ($cursor < 0 || $cursor >= $lines) {
            $state['terminated'] = true;
        }
    }

    $process = $process == A ? B : A;

    $done = ($states[A]['terminated'] || $states[A]['waiting']) &&
            ($states[B]['terminated'] || $states[B]['waiting']);
}

function getValue(int $process, string $target): string
{
    global $states;

    if (is_numeric($target)) {
        return (int) $target;
    }

    $registers =& $states[$process]['registers'];

    if (!array_key_exists($target, $registers)) {
        $registers[$target] = 0;
    }

    $value = $registers[$target];

    return $value;
}

echo $states[B]['sent'] . PHP_EOL;