<?php
declare(strict_types=1);

namespace BasicApp\Tests\Http;

use BasicApp\Http\Request;
use BasicApp\Routing\Router;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
  public function testInstantiation(): void
  {
    $request = Request::create('https://domain.tld/foo/bar/baz');

    $this->assertInstanceOf(Request::class, $request);

  }
}
