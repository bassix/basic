<?php
declare(strict_types=1);

namespace BasicApp\Helper;

use ReflectionObject;

class ObjectHelper
{
  /**
   * Cast a given object to another class.
   *
   * Note:
   *
   * * Property like given from database can be snake case: book_title
   * * The target properties are expected to be always camelcase: bookTitle
   * * Setters to set a value are used if available: setBookTitle
   */
  public static function cast($source, $destination)
  {
    if (is_string($destination)) {
      $destination = new $destination();
    }

    $sourceReflection = new ReflectionObject($source);
    $destinationReflection = new ReflectionObject($destination);
    $sourceProperties = $sourceReflection->getProperties();

    foreach ($sourceProperties as $sourceProperty) {
      $name = $sourceProperty->getName();
      $value = $sourceProperty->getValue($source);

      $keyIsCamelcase = CamelCaseHelper::isCamelcase($name);

      if (true !== $keyIsCamelcase) {
        $name = CamelCaseHelper::camelize($name, true);
      }

      $method = 'set' . CamelCaseHelper::camelize($name);

      if (method_exists($destination, $method)) {
        $destinationProperty = $destinationReflection->getProperty($name);

        if ('DateTime' === $destinationProperty->getType()->getName()) {
          $value = new \DateTime($value);
        }

        $destination->$method($value);
      } else {
        $sourceProperty->setAccessible(true);

        if ($destinationReflection->hasProperty($name)) {
          $destinationProperty = $destinationReflection->getProperty($name);
          $destinationProperty->setAccessible(true);
          $destinationProperty->setValue($destination, $value);
        }
        // @todo What should happen if a property doesn't exist?
        //$destination->$name = $value;
      }
    }

    return $destination;
  }
}
