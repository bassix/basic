<?php
declare(strict_types=1);

namespace BasicApp\Helper;

/**
 * Class to handle camel case and to camelize or decamelize strings.
 */
class CamelCaseHelper
{
  /**
   * Transforms an under_scored_string to a camelCasedOne
   */
  public static function camelize(string $input, bool $lcfirst = false): string
  {
    $return = implode(
      '',
      array_map(
        'ucfirst',
        array_map(
          'strtolower',
          explode(
            '_',
            $input
          )
        )
      )
    );

    if (true === $lcfirst) {
      return lcfirst($return);
    }

    return $return;
  }

  /**
   * Transforms a camelCasedString to an under_scored_one
   *
   */
  public static function decamelize(string $input): string
  {
    return implode(
      '_',
      array_map(
        'strtolower',
        preg_split('/([A-Z]{1}[^A-Z]*)/', $input, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY)
      )
    );
  }

  /**
   * Method to check if a given string is camelcase or not.
   *
   */
  public static function isCamelcase(string $key): bool
  {
    return CamelCaseHelper::decamelize($key) !== $key;
  }
}
