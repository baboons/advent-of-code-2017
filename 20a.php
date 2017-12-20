<?php
include 'utilities.php';

$particles = [];
$lines = explode("\n", input());

foreach($lines as $id => $line) {
    $line = explode(', ', $line);
    $particle = (object) [ 'id' => $id];

    foreach ($line as $set) {
        $type = $set[0];
        $set = explode(',', substr($set, 3, strlen($set) - 4));
        [$particle->{$type.'x'}, $particle->{$type.'y'}, $particle->{$type.'z'}] = $set;
    }

    $particle->start = $particle->px + $particle->py  +$particle->pz;
    $particles[] = $particle;
}

for ($i = 0; $i < 1000; $i++) {
    $positions = [];
    foreach ($particles as &$particle) {
        $particle->vx += $particle->ax;
        $particle->vy += $particle->ay;
        $particle->vz += $particle->az;
        $particle->px += $particle->vx;
        $particle->py += $particle->vy;
        $particle->pz += $particle->vz;

        $distance = abs($particle->px) + abs($particle->py) + abs($particle->pz);
        $particle->dx = $distance - $particle->start;
    }
}

usort($particles, function ($a, $b) {
    $a = abs($a->dx);
    $b = abs($b->dx);
    if ($a == $b) return 0;
    return $a < $b ? -1 : 1;
});

echo $particles[0]->id . PHP_EOL;