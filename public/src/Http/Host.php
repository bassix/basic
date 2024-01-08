<?php
declare(strict_types=1);

namespace BasicApp\Http;

class Host
{
  public function name(): string
  {
    return gethostname();
  }
}
