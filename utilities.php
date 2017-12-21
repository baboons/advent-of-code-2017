<?php
declare(strict_types=1);

/**
 * @return string
 */
function input(): string
{
    define('INPUT_DIR', 'inputs');

    $filename = substr(pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_FILENAME), 0, -1);

    if (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] === '-t') {

        if (isset($_SERVER['argv'][2])) {
            return $_SERVER['argv'][2];
        }

        $filename .= 't';
    }

    return trim(
        file_get_contents(__DIR__ . '/' . INPUT_DIR . '/' . $filename . '.txt')
    );
}

/**
 * @param string $input
 * @param bool $binary
 * @return string
 */
function knotHash(string $input, bool $binary = false): string {
    $hash = '';
    $size = 256;
    $list = range(0, $size-1);
    $lengths = [];
    $skip = $current = 0;

    for ($i = 0; $i < strlen($input); $i++) {
        $lengths[] = ord($input[$i]);
    }

    $lengths = array_merge($lengths, [17, 31, 73, 47, 23]);

    for ($i = 0; $i < 64; $i++) {
        foreach ($lengths as $l => $length) {

            $temp = $list;

            for ($round = 0; $round < $length; $round++) {
                $temp[($current + $round) % $size] = $list[($current + ($length % $size) - $round - 1) % $size];
            }

            $current += ($length + $skip) % $size;
            $skip++;

            $list = $temp;
        }
    }

    for ($i = 0; $i < 16; $i++) {

        $value = 0;

        for ($j = 0; $j < 16; $j++) {
            $value ^= $list[$i * 16 + $j];
        }

        if ($binary) {
            $hash .= str_pad(decbin($value), 8, '0', STR_PAD_LEFT );
        } else {
            $hash .= str_pad(dechex($value), 2, '0');
        }
    }

    return $hash;
}

/**
 * @param array $rule
 * @return array
 */
function rotate(array $rule): array
{
    $return = [];

    for ($i = 0; $i < count($rule[0]); $i++) {
        for ($j = 0; $j < count($rule[0]); $j++) {
            $value = $rule[count($rule[0]) - $j - 1][$i];

            if (isset($return[$i])) {
                $return[$i][] = $value;
            } else {
                $return[$i] = [$value];
            }
        }
    }

    return $return;
}

/**
 * @param array $rule
 * @return array
 */
function flip(array $rule): array
{
    return array_reverse($rule);
}

/**
 * @param array $pattern
 * @param string $count
 * @return int
 */
function pixels(array $pattern, string $count = '#'): int
{
    $sum = 0;

    foreach($pattern as $row) {
        foreach($row as $value) {
            if($value === $count) {
                $sum++;
            }
        }
    }

    return $sum;
}

/**
 * @param array $pattern
 * @param array $rules
 * @param int $iterations
 * @return int
 */
function pixelsByIterations(array $pattern, array $rules, int $iterations): int
{
    foreach (range(1, $iterations) as $loop) {
        $matchSize = count($pattern) % 2 == 0 ? 2 : 3;

        $pos = [
            'x' => 0,
            'y' => 0,
        ];

        $rowOffset = 0;

        $newPattern = [];

        while (isset($pattern[$pos['y']][$pos['x']])) {
            $block = [];

            foreach (range($pos['y'], $pos['y'] + $matchSize - 1) as $i) {
                $row = [];

                foreach (range($pos['x'], $pos['x'] + $matchSize - 1) as $j) {
                    $row[] = $pattern[$i][$j];
                }

                $block[] = $row;
            }

            $block = rule2array($rules[array2rule($block)]);

            foreach ($block as $i => $row) {
                if (isset($newPattern[$i + $rowOffset])) {
                    $newPattern[$i + $rowOffset] = array_merge($newPattern[$i + $rowOffset], $row);
                } else {
                    $newPattern[$i + $rowOffset] = $row;
                }
            }

            $pos['x'] += $matchSize;

            if (!isset($pattern[$pos['y']][$pos['x']])) {
                $pos['x'] = 0;
                $pos['y'] += $matchSize;
                $rowOffset += $matchSize + 1;
            }
        }

        $pattern = $newPattern;
    }

    return pixels($pattern);
}

/**
 * @param string $rule
 * @return array
 */
function rule2array(string $rule): array
{
    return array_map(function($part) {
        return str_split($part);
    }, explode('/', $rule));
}

/**
 * @param array $array
 * @return string
 */
function array2rule(array $array): string
{
    return implode('/', array_map(function($parts) {
        return implode('', $parts);
    }, $array));
}