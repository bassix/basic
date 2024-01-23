<?php
declare(strict_types=1);

namespace BasicApp\Http;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class Response extends SymfonyResponse
{
  private Body $body;

  public function body(string|Body $body = null): string
  {
    if ($body instanceof Body) {
      $this->body = $body;
    } elseif (null !== $body) {
      $this->body->content($body);
    }

    return $this->body->content();
  }

  public function header(): ResponseHeaderBag
  {
    return $this->headers;
  }

  public function statusCode(int $statusCode = null): int
  {
    if (null !== $statusCode) {
      $this->statusCode = $statusCode;
    }

    return $this->statusCode;
  }

  public function protocolVersion(): string
  {
    return '1.1';
  }

  public function reasonPhrase(): string
  {
    return StatusCode::$messages[$this->statusCode];
  }
}
