<?php
include 'utilities.php';

$particles = [];
$lines = explode("\n", input());

foreach($lines as $id => $line) {
    $line = explode(', ', $line);
    $particle = (object) ['id' => $id, 'destroyed' => 0];

    foreach ($line as $set) {
        $type = $set[0];
        $set = explode(',', substr($set, 3, strlen($set) - 4));
        [$particle->{$type.'x'}, $particle->{$type.'y'}, $particle->{$type.'z'}] = $set;
    }

    $particle->start = $particle->px + $particle->py  +$particle->pz;
    $particles[] = $particle;
}

$alive = count($particles);

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

        if (!$particle->destroyed) {
            $idx = "$particle->px,$particle->py,$particle->pz";
            if (isset($positions[$idx])) {
                $alive--;
                $particle->destroyed = 1;
                if (!$positions[$idx]->destroyed) {
                    $alive--;
                    $positions[$idx]->destroyed = 1;
                }
            } else
                $positions[$idx] = $particle;
        }
    }
}

usort($particles, function ($a, $b) {
    $a = abs($a->dx);
    $b = abs($b->dx);
    if ($a == $b) return 0;
    return $a < $b ? -1 : 1;
});

echo $alive . PHP_EOL;