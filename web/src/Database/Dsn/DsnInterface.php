<?php
declare(strict_types=1);

namespace BasicApp\Database\Dsn;

interface DsnInterface
{
  public function dsn(): string;
}
