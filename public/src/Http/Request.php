<?php
declare(strict_types=1);

namespace BasicApp\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request extends SymfonyRequest
{
  public function cookie(string $key, mixed $default = null): string|int|float|bool|null
  {
    return $this->cookies->get($key, $default);
  }

  public function method(): string
  {
    return $this->getMethod();
  }

  public function post(string $key, mixed $default = null): string|int|float|bool|null
  {
    return $this->request->get($key, $default);
  }

  public function query(string $key, mixed $default = null): string|int|float|bool|null
  {
    return $this->query->get($key, $default);
  }

  public function server(string $key, mixed $default = null): string|int|float|bool|null
  {
    return $this->server->get($key, $default);
  }

  public function uri(): string
  {
    return $this->getUri();
  }
}
