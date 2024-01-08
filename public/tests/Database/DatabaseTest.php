<?php
declare(strict_types=1);

namespace BasicApp\Tests\Database;

use BasicApp\Database\Database;
use BasicApp\Database\Dsn\SqliteDsn;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testInstantiation(): void
    {
        $database = new Database(new SqliteDsn(':memory:'));
        $this->assertInstanceOf(Database::class, $database);
    }
}
