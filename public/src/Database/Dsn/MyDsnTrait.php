<?php
declare(strict_types=1);

namespace BasicApp\Database\Dsn;

trait MyDsnTrait
{
  protected string $type = 'mysql';
  protected string $host;
  protected int $port;
  protected string $database;
  protected string $user;
  protected string $password;
  protected string $charset;

  public function __construct(
    string $database,
    string $user,
    string $password,
    string $host = null,
    int $port = null,
    string $charset = null
  ) {
    $this->database = $database;
    $this->user = $user;
    $this->password = $password;
    $this->host = $host ?? 'localhost';
    $this->port = $port ?? 3306;
    $this->charset = $charset ?? 'utf8';
  }

  public function dsn(): string
  {
    return "{$this->type}:host={$this->host};port={$this->port};dbname={$this->database};user={$this->user};password={$this->password};charset={$this->charset}";
  }
}
