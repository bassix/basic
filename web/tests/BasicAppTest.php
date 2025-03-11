<?php
declare(strict_types=1);

namespace BasicApp\Tests;

use BasicApp\BasicApp;
use BasicApp\Database\Database;
use BasicApp\Http\Host;
use BasicApp\Http\Request;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class BasicAppTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $basicApp = new BasicApp(__DIR__, null, new NullLogger());

        $this->assertInstanceOf(BasicApp::class, $basicApp);
        $this->assertEquals(__DIR__, $basicApp->root());
        $this->assertInstanceOf(Host::class, $basicApp->host());
        $this->assertInstanceOf(Request::class, $basicApp->request());
        $this->assertInstanceOf(Database::class, $basicApp->database());
    }
}
