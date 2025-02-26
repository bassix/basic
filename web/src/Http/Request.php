<?php
declare(strict_types=1);

namespace BasicApp\Http;

class Request
{
  public function uri(): string
  {
    return ltrim($_SERVER['REQUEST_URI'], '/');
  }

  public function method(): string
  {
    return strtolower($_SERVER['REQUEST_METHOD']) ?? 'get';
  }

  public function request(string $key, $value = null): string | null
  {
    return $_REQUEST[$key] ?? $value;
  }

  public function get(string $key, $value = null): string | null
  {
    return $_GET[$key] ?? $value;
  }

  public function post(string $key, $value = null): string | null
  {
    return $_POST[$key] ?? $value;
  }

  public function cookie(string $key, $value = null): string | null
  {
    return $_COOKIE[$key] ?? $value;
  }
}
