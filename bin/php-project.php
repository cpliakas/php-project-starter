<?php

// Try to find the appropriate autoloader.
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} elseif (__DIR__ . '/../../../autoload.php') {
    require __DIR__ . '/../../../autoload.php';
}

$application = new PhpProject\Console\PhpProjectApplication();
$application->run();
