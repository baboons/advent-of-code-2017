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