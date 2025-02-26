<?php
declare(strict_types=1);

namespace BasicApp\Database\Dsn;

class SqliteDsn implements DsnInterface
{
  protected string $type = 'sqlite';
  protected string $file;

  public function __construct(string $file)
  {
    $this->file = $file;
  }

  public function dsn(): string
  {
    return "{$this->type}:{$this->file}";
  }
}
