<?php

declare(strict_types=1);

namespace BasicApp\Tests\Database\Dsn;

use BasicApp\Database\Dsn\MyDsnTrait;
use BasicApp\Database\Dsn\SqliteDsn;
use PHPUnit\Framework\TestCase;

class DsnInterfaceTest extends TestCase
{
    public function testHandle(): void
    {
        $dsn = new SqliteDsn(':memory:');

        $this->assertInstanceOf(SqliteDsn::class, $dsn);
        $this->assertEquals('sqlite::memory:', $dsn->dsn());

        $mock = $this
            ->getMockBuilder(MyDsnTrait::class)
            ->setConstructorArgs([
                'database' => 'database_name',
                'user'     => 'foo',
                'password' => 'bar',
                'host'     => 'database_host',
                'port'     => 7632,
            ])
            ->getMockForTrait();
        $this->assertSame('mysql:host=database_host;port=7632;dbname=database_name;user=foo;password=bar;charset=utf8', $mock->dsn());
    }
}
