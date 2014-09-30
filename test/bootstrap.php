<?php

$autoloadFile = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadFile)) {
    throw new RuntimeException('Install dependencies to run phpunit.');
}
require_once $autoloadFile;
