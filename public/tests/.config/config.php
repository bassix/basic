<?php
declare(strict_types=1);

use BasicApp\Config;

/** @var Config $config */

// Database service: sqlite in memory
$config->dsn = new BasicApp\Database\Dsn\SqliteDsn(':memory:');
