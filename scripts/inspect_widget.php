<?php

require __DIR__ . '/../vendor/autoload.php';

$r = new ReflectionClass('Filament\\Widgets\\Widget');
foreach ($r->getProperties() as $p) {
    echo ($p->isStatic() ? 'static ' : 'nonstatic ') . $p->getName() . PHP_EOL;
}
