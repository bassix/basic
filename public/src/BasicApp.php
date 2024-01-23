<?php

declare(strict_types=1);

namespace BasicApp;

use BasicApp\Database\Database;
use BasicApp\Database\Dsn\SqliteDsn;
use BasicApp\Http\Host;
use BasicApp\Http\Request;
use BasicApp\Http\Response;
use BasicApp\Routing\Router;
use BasicApp\Template\Template;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Pimple\Container;
use Psr\Log\LoggerInterface;

class BasicApp
{
  public const NAME = 'basic';
  public const CONFIG_FILE_PATH = '.config/config.php';
  public const ROUTING_FILE_PATH = '.config/routes.php';

  public Container $container;
  private Config $config;
  private Request $request;
  private Database $database;
  private Host $host;
  private LoggerInterface $logger;
  private string $root;
  private Router $router;
  private Template $template;

  public function __construct(string $root = null, Config $config = null, LoggerInterface $logger = null)
  {
    $this->container = new Container();
    $this->container['root'] = $this->root = $root ?? dirname(__DIR__, 1);

    if (null === $logger) {
      $logLevel = Logger::INFO;
      $this->container['logger'] = $this->logger = new Logger(self::NAME);
      $this->logger->pushHandler(new StreamHandler($this->root . '/.log/' . self::NAME . '.log', $logLevel));
    } else {
      $this->container['logger'] = $this->logger = $logger;
    }

    $this->logger->info('###> Instantiating the main application <###');

    $this->container['config'] = $this->config = $config ?? $this->configure();
    $this->container['request'] = $this->request = Request::createFromGlobals();
    $this->container['host'] = $this->host = new Host();

    $this->container['database'] = $this->database = new Database(
      $this->config->dsn ?? new SqliteDsn(':memory:'),
      $this->logger
    );

    $this->container['template'] = $this->template = new Template(
      $this->root . '/template',
      $this->root . '/.var/cache',
      $config['dev'] ?? true,
      $this->logger
    );

    $this->container['router'] = $this->router = new Router(
      $this->root . '/' . self::ROUTING_FILE_PATH,
      $this->container,
      $this->logger
    );

    $this->logger->info('###> Main application instantiated <###');
  }

  public function name(): string
  {
    return ucfirst($this->host()->name());
  }

  public function host(): Host
  {
    return $this->host;
  }

  public function root(): string
  {
    return $this->root;
  }

  public function request(): Request
  {
    return $this->request;
  }

  public function logger(): Logger
  {
    return $this->logger;
  }

  public function database(): ?Database
  {
    return $this->database;
  }

  public function template(): ?Template
  {
    return $this->template;
  }

  /**
   * Run the main application by handling the request with the configured routes and by default (can be disabled) send
   * the response to the client.
   */
  public function run(bool $silent = false): Response
  {
    try {
      $this->logger()->info('####> The basic application has started <####');
      $response = $this->router->handle($this->request);
    } catch (\Exception $e) {
      $this->logger()->critical($e->getMessage());
      die('Uuups... it seams there is something broken :/');
    }

    if (!$silent) {
      $this->respond($response);
    }

    return $response;
  }

  /**
   * Send the response to the client
   */
  public function respond(Response $response): void
  {
    if (!headers_sent()) {
      // First the headers are send...
      foreach ($response->header() as $name => $values) {
        $first = !(0 === stripos($name, 'Set-Cookie'));

        foreach ($values as $value) {
          header(sprintf('%s: %s', $name, $value), $first);
          $first = false;
        }
      }

      // Second the status code are send...
      header(
        sprintf(
          'HTTP/%s %s %s',
          $response->protocolVersion(),
          $response->statusCode(),
          $response->reasonPhrase()
        ),
        true,
        $response->statusCode()
      );
    }

    // Finally the body is send...
    echo $response->body();
  }

  private function configure(): Config
  {
    $config = new Config();

    if (is_file($this->root . '/' . self::CONFIG_FILE_PATH)) {
      include $this->root . '/' . self::CONFIG_FILE_PATH;
      $this->logger->info('Configuration found and loaded');
    } else {
      $this->logger->info('No configuration file "config.php" found, please create it first!');
    }

    return $config;
  }
}
