<?php

define('INPUT_DIR', 'inputs');

$filename = substr(pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_FILENAME), 0, -1);

if (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] === '-t') {

    if (isset($_SERVER['argv'][2])) {
        return $_SERVER['argv'][2];
    }

    $filename .= 't';
}

return trim(
    file_get_contents(__DIR__ . '/../' . INPUT_DIR . '/' . $filename . '.txt')
);