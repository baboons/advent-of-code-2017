<?php
include 'utilities.php';

$children = $parents = [];

preg_match_all('/([a-z]+)\s\((\d+)\)(?:\s->\s(.*))?/', input(), $matches);

[$text, $programs, $weights, $sub] = $matches;

foreach ($programs as $i => $name) {

    $parents[] = $name;

    if (count($parts = explode(", ", $sub[$i])) > 1) {
        $children = array_merge(
            $children,
            $parts
        );
    }

}

echo array_values(array_diff($parents, $children))[0] . PHP_EOL;