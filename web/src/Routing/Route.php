<?php
declare(strict_types=1);

namespace BasicApp\Routing;

use BasicApp\Controller\DefaultController;

class Route
{
  public const METHOD_GET = 'get';
  public const METHOD_POST = 'post';
  public const METHOD_PUT = 'put';
  public const METHOD_UPDATE = 'update';
  public const METHOD_DELETE = 'delete';

  public string $method;
  public string $route;
  public string $control;

  public function __construct(string $method = self::METHOD_GET, string $route = '/', string $control = DefaultController::class)
  {
    $this->method = $method;
    $this->route = $route;
    $this->control = $control;
  }
}
