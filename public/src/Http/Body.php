<?php
declare(strict_types=1);

namespace BasicApp\Http;

class Body
{
  private string $content = '';

  public function __construct(string $content = null)
  {
    $this->content = $content ?? '';
  }

  public function content(string $content = null): string
  {
    if (null !== $content) {
      $this->content = $content;
    }

    return $this->content;
  }
}
