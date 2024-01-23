<?php
declare(strict_types=1);

namespace BasicApp\Tests\Routing;

use BasicApp\Controller\NotFoundController;
use BasicApp\Database\Database;
use BasicApp\Http\Request;
use BasicApp\Http\Response;
use BasicApp\Http\StatusCode;
use BasicApp\Routing\Router;
use BasicApp\Template\Template;
use PHPUnit\Framework\TestCase;
use Pimple\Container;

class RouterTest extends TestCase
{
  public function testInstantiation(): void
  {
    $router = new Router();

    $this->assertInstanceOf(Router::class, $router);
  }

  public function testHandle()
  {
    $request = Request::create('https://domain.tld/foo/bar/baz');

    $container = new Container([
      'request' => $request,
      'page' => '',
      'template' => $this->createMock(Template::class),
      'database' => $this->createMock(Database::class),
    ]);;

    $router = new Router(
      dirname(__DIR__) . '/.config/routes.php',
      $container
    );

    $response = $router->handle($request);

    $this->assertInstanceOf(Response::class, $response);
    $this->assertEquals(StatusCode::HTTP_NOT_FOUND, $response->statusCode());
  }
}
