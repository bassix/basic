<?php
declare(strict_types=1);

namespace BasicApp\Http;

class Header
{
  private array $headers = [];

  public function set(string $key, string $value): self
  {
    $this->headers[$key] = $value;

    return $this;
  }

  public function get(string $key): string
  {
    return $this->headers[$key];
  }

  /**
   * @return string[]
   */
  public function all(): array
  {
    return $this->headers;
  }
}
