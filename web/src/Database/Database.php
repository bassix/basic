<?php
declare(strict_types=1);

namespace BasicApp\Database;

use BasicApp\Database\Dsn\DsnInterface;
use PDO;
use PDOException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Database
{
  protected PDO $db;
  private LoggerInterface $logger;

  public function __construct(DsnInterface $dsn, LoggerInterface $logger = null)
  {
    $this->logger = $logger ?? new NullLogger();
    $this->connect($dsn);
  }

  public function connect(DsnInterface $dsn): void
  {
    $this->logger->notice("Database connection with \"{$dsn->dsn()}\"");

    try {
      $this->db = new PDO($dsn->dsn());
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->logger->notice('Database connection established');
    } catch (PDOException $e) {
      $this->logger->warning('Database connection failed! Please check your configuration.');
    }
  }

  public function pdo(): PDO
  {
    return $this->db;
  }

  public function raw(string $sql): void
  {
    $this->db->query($sql);
  }

  public function run(string $sql, array $args = []): \PDOStatement
  {
    if (empty($args)) {
      return $this->db->query($sql);
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute($args);

    return $stmt;
  }

  public function rows(string $sql, $args = [], $fetchMode = PDO::FETCH_OBJ): bool|array
  {
    return $this->run($sql, $args)->fetchAll($fetchMode);
  }

  public function row(string $sql, array $args = [], int $fetchMode = PDO::FETCH_OBJ): mixed
  {
    return $this->run($sql, $args)->fetch($fetchMode);
  }

  public function getById(string $table, string|int $id, int $fetchMode = PDO::FETCH_OBJ): mixed
  {
    return $this->run("SELECT * FROM `$table` WHERE id = ?", [$id])->fetch($fetchMode);
  }

  public function count(string $sql, array $args = []): int
  {
    return $this->run($sql, $args)->rowCount();
  }

  /**
   * Get primary key of last inserted record
   */
  public function lastInsertId(): string
  {
    return $this->db->lastInsertId();
  }

  public function insert($table, $data): string
  {
    // Add columns into comma seperated string...
    // @todo This is not working correct ;)
    $columns = implode('`,`', array_keys($data));

    // Get the values from array...
    $values = array_values($data);

    $placeholders = array_map(static function ($value) {
      return '?';
    }, array_keys($data));

    // Convert the array keys into comma seperated string...
    $placeholders = implode(',', array_values($placeholders));

    $this->run("INSERT INTO `$table` ($columns) VALUES ($placeholders)", $values);

    return $this->lastInsertId();
  }

  public function update($table, $data, $where): int
  {
    // Merge the data and where...
    $collection = array_merge($data, $where);

    // Collect the values from collection...
    $values = array_values($collection);

    // Setup the fields...
    $fieldsString = null;

    foreach ($data as $key => $value) {
      $fieldsString .= "`$key` = ?,";
    }

    $fieldsString = rtrim($fieldsString, ',');

    // Create the where condition...
    $whereString = $this->getWhereString($where);

    $stmt = $this->run("UPDATE `$table` SET $fieldsString WHERE $whereString", $values);

    return $stmt->rowCount();
  }

  public function delete($table, $where, $limit = 1): int
  {
    // Collect the values from where condition...
    $values = array_values($where);

    // Create the where condition...
    $whereString = $this->getWhereString($where);

    $limitString = '';

    if (is_numeric($limit)) {
      $limitString = "LIMIT $limit";
    }

    return $this->run("DELETE FROM `$table` WHERE $whereString $limitString", $values)->rowCount();
  }

  public function deleteAll($table): int
  {
    return $this->run("DELETE FROM `$table`")->rowCount();
  }

  public function deleteById($table, $id): int
  {
    return $this->run("DELETE FROM `$table` WHERE id = ?", [$id])->rowCount();
  }

  public function deleteByIds(string $table, string $column, string $ids): int
  {
    return $this->run("DELETE FROM `$table` WHERE $column IN ($ids)")->rowCount();
  }

  public function truncate($table): int
  {
    return $this->run("TRUNCATE TABLE `$table`")->rowCount();
  }

  private function getWhereString($where): ?string
  {
    $whereString = null;
    $i = 0;

    foreach ($where as $key => $value) {
      $whereString .= 0 === $i ? "$key = ?" : " AND $key = ?";
      $i++;
    }

    return $whereString;
  }
}
