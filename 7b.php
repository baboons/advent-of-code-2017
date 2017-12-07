<?php
declare(strict_types=1);

$input = include 'utils/input.php';

function getMatches(string $input): array
{
    preg_match_all('/([a-z]+)\s\((\d+)\)(?:\s->\s(.*))?/', $input, $matches);

    [$text, $programs, $weights, $sub] = $matches;

    return [
        $programs,
        $weights,
        $sub,
    ];
}


function findBottom(string $input)
{
    $children = $parents = [];

    [$programs, $weights, $sub] = getMatches($input);

    foreach ($programs as $i => $name) {

        $parents[] = $name;

        if (count($parts = explode(", ", $sub[$i])) > 1) {
            $children = array_merge(
                $children,
                $parts
            );
        }

    }

    return array_values(array_diff($parents, $children))[0];
}

final class Tower
{

    public $name;

    public $weight = 0;

    public $totalWeight = 0;

    public $children = [];

    private $input;

    public function __construct(string $name, string $input)
    {
        $this->name = $name;
        $this->input = $input;

        $this->setWeights();
        $this->setChildren();

        $this->calculate();
    }

    private function setWeights()
    {
        [$programs, $weights, $children] = getMatches($this->input);

        $index = array_flip($programs)[$this->name];

        $this->weight = $weights[$index];
    }

    private function setChildren()
    {
        [$programs, $weights, $children] = getMatches($this->input);

        $index = array_flip($programs)[$this->name];

        if(!empty($children[$index])) {
            foreach (explode(", ", $children[$index]) as $childName) {
                $this->children[] = new Tower($childName, $this->input);
            }
        }
    }

    public function calculate()
    {
        $weight = $this->weight;
        $correctWeight = 0;
        $differentWeight = 0;

        $childWeights = [];

        foreach ($this->children as $child) {
            if (is_null($child->totalWeight)) {
                $child->calculate();
            }
            $childWeights[] = $child->totalWeight;
        }

        if (count(array_unique($childWeights)) > 1) {
            $weights = array_count_values($childWeights);
            foreach ($weights as $weight => $count) {
                if ($count === 1) {
                    $differentWeight = $weight;
                } else {
                    $correctWeight = $weight;
                }
            }
            $differentChild = array_filter($this->children, function ($child) use ($differentWeight) {
                return $child->totalWeight === $differentWeight;
            });

            $differentChild = array_pop($differentChild);
            $correctWeight = $differentChild->weight - ($differentWeight - $correctWeight);

            die($correctWeight . PHP_EOL);

        }

        $weight += array_sum($childWeights);
        $this->totalWeight = $weight;

        return $weight;
    }
}

new Tower(findBottom($input), $input);
