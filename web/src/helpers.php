<?php

declare(strict_types=1);

function dd(): void
{
  array_map(static function ($x): void {
    ob_start();
    var_dump($x);
    $buffer = ob_get_clean();

    if (false === $buffer) {
      throw new RuntimeException('Failed to dump variable');
    }

    echo '<pre style="background-color:#222222; color:#dddd; line-height:1.2em; font-weight:normal; font:12px monospace; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:100000">';
    echo htmlentities($buffer);
    echo '</pre>';
  }, func_get_args());
}
