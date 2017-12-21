<?php
include 'utilities.php';

ini_set('memory_limit', '4G');

$lines = explode(PHP_EOL, input());
$rules = [];

foreach ($lines as $line) {

    $rule = explode(' => ', $line);
    $matchRule = rule2array($rule[0]);
    $matchRuleFlipped = flip($matchRule);
    $rules[array2rule($matchRule)] = $rule[1];
    $rules[array2rule($matchRuleFlipped)] = $rule[1];

    foreach (range(1, 3) as $i) {
        $matchRule = rotate($matchRule);
        $matchRuleFlipped = rotate($matchRuleFlipped);
        $rules[array2rule($matchRule)] = $rule[1];
        $rules[array2rule($matchRuleFlipped)] = $rule[1];
    }
}
$pattern = rule2array('.#./..#/###');

echo pixelsByIterations($pattern, $rules, 18) . PHP_EOL;