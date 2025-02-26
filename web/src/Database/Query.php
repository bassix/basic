<?php
declare(strict_types=1);

namespace BasicApp\Database;

use Exception;

class Query
{
  public const ORDER_ASC = 'ASC';

  public const ORDER_DESC = 'DESC';

  /**
   * Reserved words that will not be escaped
   */
  protected array $reservedWords = ['NOW', 'TIMESTAMP', 'NULL'];

  private array $table = [];

  private array $fieldList = [];

  private array $joins = [];

  private array $order = [];

  private array $limits = [0, 100];

  private array $wheres = [];

  private string $baseCommand = '';

  private array $payload = [];

  private $escapeFunction;

  public function __toString(): string
  {
    return $this->generateSQL();
  }

  /**
   * Creates a new Query instance
   */
  public static function create(): self
  {
    return new self();
  }

  public function getEscapeFunction(): ?callable
  {
    return $this->escapeFunction;
  }

  public function setEscapeFunction(callable $escapeFunction): self
  {
    $this->escapeFunction = $escapeFunction;

    return $this;
  }

  /**
   * SELECT rows from a table
   */
  public function select($fieldList = '*'): self
  {
    if (!is_array($fieldList)) {
      $fieldList = [$fieldList];
    }

    $this->baseCommand = 'SELECT';
    $this->fieldList = $fieldList;

    return $this;
  }

  /**
   * DELETE rows from a table
   */
  public function delete(array $fieldList = []): self
  {
    $this->baseCommand = 'DELETE';
    $this->fieldList = $fieldList;

    return $this;
  }

  /**
   * COUNT the rows in a table stored the given field name in the result that holds the row count.
   */
  public function countRows(string $countFieldName = '_count'): self
  {
    $this->baseCommand = "SELECT COUNT(*) AS {$countFieldName}";

    return $this;
  }

  /**
   * Sets the target table
   */
  public function from(string $table, string $alias = ''): self
  {
    $this->table = [$table, $alias];

    return $this;
  }

  /**
   * Sets the target table
   */
  public function into(string $table, string $alias = ''): self
  {
    $this->table = [$table, $alias];

    return $this;
  }

  /**
   * LEFT JOINs a table
   */
  public function leftJoin(string $table, array $conditions, string $alias): self
  {
    $this->joins[] = [
      'table'      => $table,
      'conditions' => $conditions,
      'alias'      => $alias,
      'type'       => 'LEFT',
    ];

    return $this;
  }

  /**
   * RIGHT JOINs a table
   */
  public function rightJoin(string $table, array $conditions, string $alias): self
  {
    $this->joins[] = [
      'table'      => $table,
      'conditions' => $conditions,
      'alias'      => $alias,
      'type'       => 'RIGHT',
    ];

    return $this;
  }

  /**
   * INNER JOINs a table
   */
  public function innerJoin(string $table, array $conditions, string $alias): self
  {
    $this->joins[] = [
      'table'      => $table,
      'conditions' => $conditions,
      'alias'      => $alias,
      'type'       => 'INNER',
    ];

    return $this;
  }

  /**
   * FULL OUTER JOINs a table.
   */
  public function fullOuterJoin(string $table, array $conditions, string $alias): self
  {
    $this->joins[] = [
      'table'      => $table,
      'conditions' => $conditions,
      'alias'      => $alias,
      'type'       => 'FULL OUTER',
    ];

    return $this;
  }

  /**
   * Defines a number of conditions in a WHERE clause.
   */
  public function where(array $conditions): self
  {
    $this->wheres = $conditions;

    return $this;
  }

  public function orderBy(string $field, string $dir = self::ORDER_ASC): self
  {
    $this->order = [$field, $dir];

    return $this;
  }

  /**
   * LIMIT the number of returned rows
   */
  public function limit(string|int $start, string|int $offset): self
  {
    $this->limits = [$start, $offset];

    return $this;
  }

  public function insert(array $data, bool $multipleRows = false): self
  {
    $this->baseCommand = 'MULTI_INSERT';

    if (false === $multipleRows) {
      $this->baseCommand = 'INSERT';
    }

    $this->payload = $data;

    return $this;
  }

  public function update(array $data): self
  {
    $this->baseCommand = 'UPDATE';
    $this->payload = $data;

    return $this;
  }

  /**
   * Normalizes objects and arrays to strings
   */
  protected function normalizeValue($value)
  {
    if ($value instanceof \DateTime) {
      $value = $value->format('Y-m-d H:i:s');
    } elseif (is_array($value) || is_object($value)) {
      $value = json_encode($value);
    }

    return $value;
  }

  /**
   * Sanitizes a value depending on its type.
   */
  protected function sanitizeValue($value): string
  {
    if (null === $value) {
      return 'NULL';
    } elseif (empty($value)) {
      return '\'\'';
    } elseif (is_int($value) || is_float($value)) {
      return (string)$value;
    }

    $value = $this->normalizeValue($value);

    if (in_array(strtoupper($value), $this->reservedWords)) {
      return $value;
    }

    if (is_callable($this->getEscapeFunction())) {
      $value = call_user_func($this->getEscapeFunction(), $value);

      // check if the escape functions put quotes around the string
      if (!str_starts_with($value, '\'') || !str_ends_with($value, '\'')) {
        $value = "'{$value}'";
      }
    } else {
      $value = "'{$value}'";
    }

    return $value;
  }

  protected function buildSetList(): string
  {
    $sets = [];

    foreach ($this->payload as $key => $value) {
      $sets[] = $this->escapeField($key) . ' = ' . $this->sanitizeValue($value);
    }

    return implode(', ', $sets);
  }

  protected function buildInsertList(): string
  {
    $values = [];
    $fields = [];

    foreach ($this->payload as $key => $value) {
      $fields[] = $this->escapeField($key);
      $values[] = $this->sanitizeValue($value);
    }

    return '(' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
  }

  /**
   * This method builds the final sql query
   */
  protected function generateSQL(): string
  {
    $sql = '';

    switch ($this->baseCommand) {
      case 'INSERT':
        $sql .= "INSERT INTO `{$this->table[0]}` {$this->buildInsertList()}";

        break;
      case 'UPDATE':
        $sql .= "UPDATE `{$this->table[0]}` SET {$this->buildSetList()}";

        if (!empty($this->wheres)) {
          $sql .= " WHERE {$this->parseConditions($this->wheres)}";
        }

        break;
      default:
        $sql .= $this->baseCommand;

        if (
          false === strpos($this->baseCommand, 'COUNT(*) AS ')
          &&
          false === strpos($this->baseCommand, 'DELETE')
        ) {
          if (!empty($this->fieldList)) {
            $sql .= ' ' . $this->escapeFieldList($this->fieldList);
          } else {
            $sql .= ' *';
          }
        }

        $sql .= " FROM `{$this->table[0]}`";

        if ('' !== $this->table[1]) {
          $sql .= " `{$this->table[1]}`";
        }

        foreach ($this->joins as $join) {
          $sql .= " {$join['type']} JOIN `{$join['table']}`";

          if ('' !== $join['alias']) {
            $sql .= " `{$join['alias']}`";
          }

          $sql .= ' ON (' . $this->parseConditions($join['conditions'], 'AND', ['keysAreLikelyTableRef' => true]) . ')';
        }

        if (!empty($this->wheres)) {
          $sql .= " WHERE {$this->parseConditions($this->wheres)}";
        }

        if (!empty($this->order)) {
          $sql .= " ORDER BY {$this->escapeField($this->order[0])} {$this->order[1]}";
        }

        if (
          1 <= $this->limits[1]
          &&
          !in_array($this->baseCommand, ['DELETE', 'UPDATE', 'INSERT'])
        ) {
          $sql .= " LIMIT {$this->limits[0]},{$this->limits[1]}";
        }

        break;
    }

    return $sql;
  }

  /**
   * This method escapes a list of field names
   */
  protected function escapeFieldList(array $fields): string
  {
    foreach ($fields as $k => $v) {
      $v = trim($v);
      $fields[$k] = $this->escapeField($v);
    }

    return implode(', ', $fields);
  }

  /**
   * This method escapes a field name, paying attention to 'TABLE.FIELD' syntax
   */
  protected function escapeField($value): string
  {
    if (str_contains($value, '.')) {
      if (str_contains($value, '*')) {
        $value = '`' . str_replace('.', '`.', $value);
      } else {
        $value = '`' . str_replace('.', '`.`', $value) . '`';
      }
    } else {
      if (!str_contains($value, '*')) {
        $value = '`' . $value . '`';
      }
    }

    return $value;
  }

  /**
   * Parse a nested array of conditions.
   *
   * When building your condition array, you can use '_or' and '_and' to concatenate queries.
   *
   * The default operator is 'AND' For example:
   *
   * ```php
   * array(
   *  'name' => 'Bob'
   *  'job_title' => 'Developer',
   *  '_or' => array(
   *   'name' => 'Sally',
   *   'job' => 'Producer'
   *   ),
   *  '_like' => array(
   *   'name',
   *   'Sal%'
   *   )
   * )
   * ```
   *
   * ** Options**
   * keysAreLikelyTableRef: If this is set, the conditionParse will assume, that values matching FOO.BAR represent a table reference and thus need to be escaped as field names. This option is used e.g. when solving ON-Conditions in joins.
   *
   * This method will return the final SQL string.
   *
   * @throws Exception
   */
  private function parseConditions(array $conditions, string $concat = 'AND', array $options = []): string
  {
    // normalize options
    $options = array_merge(['keysAreLikelyTableRef' => false], $options);

    $parsedConditions = [];

    foreach ($conditions as $field => $value) {
      if ('_or' === strtolower($field)) {
        $subC = $this->parseConditions($value, 'OR');
        $parsedConditions[] = $subC;
      } elseif ('_and' === strtolower($field)) {
        $subC = $this->parseConditions($value, 'AND');
        $parsedConditions[] = $subC;
      } elseif ('_like' === strtolower($field) && is_array($value) && 2 === count($value)) {
        $parsedConditions[] = 'lower(' . $this->escapeField($value[0]) . ') like ' . "lower('" . $value[1] . "')";
      } else {
        $containsOperator = preg_match(
          '/(?P<field>[A-z ]*)\W* (?P<operator>\>=|\<=|!=|is not|is|=|\>|\<)/i',
          $field,
          $matches
        );

        if (is_array($value)) {
          foreach ($value as $k => $v) {
            $value[$k] = $this->sanitizeValue($v);
          }

          $parsedValue = '(' . implode(',', $value) . ')';
        } else {
          if (is_string($value) && (preg_match('/^\w+$/', $value) || preg_match('/^\w+\.\w+$/', $value))) {
            if (true === $options['keysAreLikelyTableRef']) {
              $parsedValue = $this->escapeField($value);
            } else {
              $parsedValue = $this->sanitizeValue($value);
            }
          } else {
            $parsedValue = $this->sanitizeValue($value);
          }
        }

        if (!$containsOperator) {
          if (is_array($value)) {
            $parsedConditions[] = $this->escapeField($field) . " IN $parsedValue";
          } else {
            $parsedConditions[] = $this->escapeField($field) . " = $parsedValue";
          }
        } else {
          if (empty($matches['field']) || empty($matches['operator'])) {
            throw new Exception('Could not parse query');
          }

          $matches['field'] = trim($matches['field']);
          $parsedConditions[] = $this->escapeField($matches['field']) . " $matches[operator] $parsedValue";
        }
      }
    }

    return '(' . implode(') ' . $concat . ' (', $parsedConditions) . ')';
  }
}
