<?php
declare(strict_types=1);

namespace BasicApp\Controller;

use BasicApp\Database\Database;
use BasicApp\Http\Request;
use BasicApp\Template\Template;
use Pimple\Container;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class AbstractController
{
  public Container $container;
  protected Request $request;
  protected string $page;
  protected Database $database;
  protected Template $template;
  protected LoggerInterface|NullLogger $logger;

  public function __construct(Container $container, LoggerInterface $logger = null)
  {
    $this->logger = $logger ?? new NullLogger();
    $this->container = $container;
    $this->request = $this->container['request'];
    $this->page = $this->container['page'];
    $this->template = $this->container['template'];
    $this->database = $this->container['database'];
    $this->logger->info('####> Controller instantiated <####');
  }
}
