<?php
declare(strict_types=1);

namespace BasicApp\Tests\Helper;

use BasicApp\Helper\CamelCaseHelper;
use PHPUnit\Framework\TestCase;

class CamelCaseHelperTest extends TestCase
{
  /**
   * Test if strings with underscore are transferred correct to uppercase letters.
   */
  public function testCamelization(): void
  {
    foreach ($this->getCamelizationTestCases() as $row => $testCase) {
      $this->assertEquals(
        $testCase['expected'],
        CamelCaseHelper::camelize($testCase['actual']['input'], $testCase['actual']['lcfirst']),
        sprintf(
          'The Test at row "%s" expects "%s" if "%s" is given!',
          $row,
          $testCase['expected'],
          $testCase['actual']['input']
        )
      );
    }
  }

  /**
   * Test if strings with uppercase letters is transferred correct to underscore.
   */
  public function testDecamelization(): void
  {
    foreach ($this->getDecamelizationTestCases() as $row => $testCase) {
      $this->assertEquals(
        $testCase['expected'],
        CamelCaseHelper::decamelize($testCase['actual']),
        sprintf(
          'The Test at row "%s" expects "%s" if "%s" is given!',
          $row,
          $testCase['expected'],
          $testCase['actual']
        )
      );
    }
  }

  // -- PRIVATE ------------------------------------------------------------------------------------------------------

  /**
   * getCamelizationTestCases
   *
   * @return array
   */
  private function getCamelizationTestCases()
  {
    $testCases = [
      0 => [
        'actual' => [
          'input'   => 'hallo_das_ist_ein_test',
          'lcfirst' => true,
        ],
        'expected' => 'halloDasIstEinTest',

      ],
      1 => [
        'actual' => [
          'input'   => 'hallo_das_ist_ein_test',
          'lcfirst' => false,
        ],
        'expected' => 'HalloDasIstEinTest',

      ],
      2 => [
        'actual' => [
          'input'   => 'ha_da_2_3_t',
          'lcfirst' => true,
        ],
        'expected' => 'haDa23T',
      ],
      3 => [
        'actual' => [
          'input'   => 'ha_da23t',
          'lcfirst' => false,
        ],
        'expected' => 'HaDa23t',
      ],
      4 => [
        'actual' => [
          'input'   => 'h_u_h_u',
          'lcfirst' => true,
        ],
        'expected' => 'hUHU',
      ],
      5 => [
        'actual' => [
          'input'   => 'h_u_h_u',
          'lcfirst' => false,
        ],
        'expected' => 'HUHU',
      ],
    ];

    return $testCases;
  }

  /**
   * getDecamelizationTestCases
   *
   * @return array
   */
  private function getDecamelizationTestCases()
  {
    $testCases = [
      0 => [
        'actual'   => 'halloDasIstEinTest',
        'expected' => 'hallo_das_ist_ein_test',
      ],
      1 => [
        'actual'   => 'HalloDasIstEinTest',
        'expected' => 'hallo_das_ist_ein_test',
      ],
      2 => [
        'actual'   => 'haDa23T',
        'expected' => 'ha_da23_t',
      ],
      3 => [
        'actual'   => 'HaDa23t',
        'expected' => 'ha_da23t',
      ],
      4 => [
        'actual'   => 'hUHU',
        'expected' => 'h_u_h_u',
      ],
      5 => [
        'actual'   => 'HUHU',
        'expected' => 'h_u_h_u',
      ],
    ];

    return $testCases;
  }
}
