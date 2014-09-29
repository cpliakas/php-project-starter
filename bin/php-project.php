<?php

use Cpliakas\PhpProjectStarter\Console as Console;
use Symfony\Component\Console\Application;

// Try to find the appropriate autoloader.
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} elseif (__DIR__ . '/../../../autoload.php') {
    require __DIR__ . '/../../../autoload.php';
}

$application = new Application();
$application->add(new Console\NewCommand());
$application->run();
