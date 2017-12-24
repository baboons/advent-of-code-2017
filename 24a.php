<?php
include 'utilities.php';

$components = array_map(static function (string $component): array {
    return array_map('intval', explode('/', $component));
}, explode("\n", input()));

$bridges = findStrongestBridge($components, [0]);

echo max($bridges) . PHP_EOL;