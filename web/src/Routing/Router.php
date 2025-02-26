<?php
declare(strict_types=1);

namespace BasicApp\Routing;

use BasicApp\Controller\NotFoundController;
use BasicApp\Http\Request;
use BasicApp\Http\Response;
use Pimple\Container;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Router to route URL paths to controllers.
 *
 * Resources:
 *
 * * https://www.gyro-php.org/tutorials/routing.html
 * * https://steampixel.de/simple-and-elegant-url-routing-with-php/
 */
class Router
{
  public Container $container;
  private LoggerInterface|NullLogger $logger;

  /**
   * @var Route[]
   */
  private $routes = [];

  public function __construct(string $config = null, Container $container = null, LoggerInterface $logger = null)
  {
    if (null === $logger) {
      $this->logger = new NullLogger();
    } else {
      $this->logger = $logger;
    }

    if (null === $container) {
      $this->container = new Container();
    } else {
      $this->container = $container;
    }

    if (null !== $config && file_exists($config)) {
      $this->loadRoutes($config);
    } else {
      $this->logger->warning("Routing config file \"{$config}\" not found!");
    }
  }

  public function loadRoutes(string $routingConfig): void
  {
    $routes = [];

    $this->logger->info("Routing loading \"{$routingConfig}\" configuration file");

    include $routingConfig;

    $routesCount = count($routes);
    $this->logger->info("Loaded \"{$routesCount}\" routes");

    $this->routes = $routes;
  }

  public function handle(Request $request, string $basePath = '/'): Response
  {
    // Parse current url
    $parsedUrl = parse_url($request->uri());
    $path = '' !== $parsedUrl['path'] ? '/' . $parsedUrl['path'] : '/';

    $this->logger->info("Route \"{$path}\" requested to handle");

    foreach ($this->routes as $route) {
      // Check path match..
      if (!preg_match('#' . $this->getRequestQuery($route, $basePath) . '#', $path, $matches)) {
        continue;
      }

      $this->logger->info("Corresponding route \"{$route->route}\" class \"{$route->control}\" found");

      // Check method match...
      if (strtolower($request->method()) === strtolower($route->method)) {
        $this->logger->info("Corresponding method \"{$route->method}\" found");

        // Always remove first element. This contains the whole string...
        array_shift($matches);

        if ('' !== $basePath && '/' !== $basePath) {
          // Remove base path...
          array_shift($matches);
        }
      }

      /*
      if (is_callable($route->class)) {
          call_user_func_array($route->class, $matches);
      }
      */

      $this->container['page'] = $page = isset($matches[0]) && !empty($matches[0]) ? $matches[0] : 'index';

      $this->logger->info("Corresponding method \"{$route->method}\" route \"{$route->route}\" class \"{$route->control}\" found");

      //return call_user_func($route->class);
      //return (new $route->class($this->container))($matches[0]);
      return call_user_func_array(new $route->control($this->container), $matches);
    }

    return (new NotFoundController($this->container))();
  }

  public function getRequestQuery(Route $route, string $basePath): string
  {
    $query = $route->route;

    // Add base path to matching string
    if ('' !== $basePath && '/' !== $basePath) {
      $query = '(' . $basePath . ')' . $query;
    }

    // Add 'find string start' automatically
    $query = '^' . $query;

    // Add 'find string end' automatically
    $query = $query . '$';

    return $query;
  }
}
