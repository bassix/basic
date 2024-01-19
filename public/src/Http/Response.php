<?php
declare(strict_types=1);

namespace BasicApp\Http;

class Response
{
  private int $statusCode;
  private Header $headers;
  private Body $body;

  public function __construct(string|Body $body = null, int $statusCode = StatusCode::HTTP_OK, Header $headers = null)
  {
    $this->statusCode = $statusCode;
    $this->headers = $headers ?? new Header();

    if ($body instanceof Body) {
      $this->body = $body;
    } else {
      $this->body = new Body($body);
    }
  }

  public function body(string|Body $body = null): string
  {
    if ($body instanceof Body) {
      $this->body = $body;
    } elseif (null !== $body) {
      $this->body->content($body);
    }

    return $this->body->content();
  }

  public function header(): Header
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
