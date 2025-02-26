<?php
declare(strict_types=1);

use BasicApp\BasicApp;

if (is_file(__DIR__ . '/vendor/autoload.php')) {
    $loader = require __DIR__ . '/vendor/autoload.php';
} else {
    die('The main autoloader not found! Did you forget to run "composer install"?');
}

$basicApp = new BasicApp();
$basicApp->run();
