<?php
declare(strict_types=1);

use BasicApp\Config;

/** @var Config $config */

// Database service: sqlite in memory
//$config->dsn = new BasicApp\Database\Dsn\SqliteDsn(':memory:');

// Database service: sqlite in file
//$config->dsn = new BasicApp\Database\Dsn\SqliteDsn(__DIR__ . '/var/database.sqlite3');

// Database service: mysql or mariadb
$config->dsn = new BasicApp\Database\Dsn\MariadbDsn(
    'DB',
    'DB_USER',
    'DB_PASSWORD',
    'DB_HOST',
    DB_PORT,
    'utf8',
);
