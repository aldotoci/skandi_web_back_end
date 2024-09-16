#!/usr/bin/env php
<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use App\EMInit;

// replace with path to your own project bootstrap file
new EMInit();
$entityManager = EMInit::$em;

$commands = [
    // If you want to add your own custom console commands,
    // you can do so here.
];

ConsoleRunner::run(
    new SingleManagerProvider($entityManager),
    $commands
);