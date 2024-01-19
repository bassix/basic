<?php
declare(strict_types=1);

namespace BasicApp\Tests\Database;

use BasicApp\Database\Database;
use BasicApp\Database\Dsn\SqliteDsn;
use BasicApp\Database\Query;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
  public function testEscape(): void
  {
    $data = [
      'col1' => '"§$§)=%ßß  +#\\ \\ \' "" ',
      'col2' => '\'ääö#.-,()§$=$/NXM$RU?U9j,0,  `\'',
    ];

    $query = Query::create()
      ->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->insert($data)
      ->into('the_table');

    $this->assertEquals(
      "INSERT INTO `the_table` (`col1`, `col2`) VALUES ('\"§\$§)=%ßß  +#\ \ '' \"\" ', '''ääö#.-,()§$=$/NXM\$RU?U9j,0,  `''')",
      (string)$query
    );
  }

  public function testSelect(): void
  {
    $query = Query::create()
      ->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->select(['*'])
      ->from('the_table')
      ->orderBy('name', Query::ORDER_DESC)
      ->limit(0, 100);

    $this->assertEquals(
      'SELECT * FROM `the_table` ORDER BY `name` DESC LIMIT 0,100',
      (string)$query
    );

    $query = Query::create()
      ->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->select(['test.foo', 'test.bar'])
      ->from('the_table')
      ->orderBy('name', Query::ORDER_DESC)
      ->limit(0, 100);

    $this->assertEquals(
      'SELECT `test`.`foo`, `test`.`bar` FROM `the_table` ORDER BY `name` DESC LIMIT 0,100',
      (string)$query
    );
  }

  public function testConditionsSimple(): void
  {
    $query = Query::create()
      ->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->select(['*'])
      ->from('the_table')
      ->where(
        [
          'name'      => 'Paul',
          'job_title' => ['Developer', 'Designer'],
        ]
      );

    $this->assertEquals(
      "SELECT * FROM `the_table` WHERE (`name` = 'Paul') AND (`job_title` IN ('Developer','Designer')) LIMIT 0,100",
      (string)$query
    );
  }

  public function testConditionsOperators(): void
  {
    $query = Query::create()
      ->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->select(['*'])
      ->from('the_table')
      ->where(
        [
          'name IS NOT' => null,
          'lastname !=' => 'NULL',
          'age >='      => 15,
          'quantity <'  => 99,
          'city'        => 'Quebec',
        ]
      );

    $this->assertEquals(
      "SELECT * FROM `the_table` WHERE (`name` IS NOT NULL) AND (`lastname` != NULL) AND (`age` >= 15) AND (`quantity` < 99) AND (`city` = 'Quebec') LIMIT 0,100",
      (string)$query
    );
  }

  public function testSanitization(): void
  {
    $query = Query::create()
        //->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->select(['*'])
      ->from('the_table')
      ->where(
        [
          'name IS NOT' => null,
          'lastname !=' => 'NULL',
          'age >='      => 15,
          'city'        => 'INSERT INTO Quebec',
        ]
      );

    $this->assertEquals(
      "SELECT * FROM `the_table` WHERE (`name` IS NOT NULL) AND (`lastname` != NULL) AND (`age` >= 15) AND (`city` = 'INSERT INTO Quebec') LIMIT 0,100",
      (string)$query
    );
  }

  public function testLeftJoin(): void
  {
    $query = Query::create()
      ->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->select(['*'])
      ->from('table1', 't1')
      ->leftJoin('table2', ['t1.id' => 't2.user_id'], 't2')
      ->leftJoin('table3', ['t2.id' => 't3.group_id'], 't3');

    $this->assertEquals(
      'SELECT * FROM `table1` `t1` LEFT JOIN `table2` `t2` ON ((`t1`.`id` = `t2`.`user_id`)) LEFT JOIN `table3` `t3` ON ((`t2`.`id` = `t3`.`group_id`)) LIMIT 0,100',
      (string)$query
    );

    $query = Query::create()
      ->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->select(['*'])
      ->from('table1', 't1')
      ->leftJoin('table2', ['id' => 'user_id'], 't2')
      ->leftJoin('table3', ['id_table3' => 'group_id'], 't3');

    $this->assertEquals(
      'SELECT * FROM `table1` `t1` LEFT JOIN `table2` `t2` ON ((`id` = `user_id`)) LEFT JOIN `table3` `t3` ON ((`id_table3` = `group_id`)) LIMIT 0,100',
      (string)$query
    );
  }

  public function testInsert(): void
  {
    $payload = [
      'the_table.name'  => 'Frank Drebin',
      'the_table.email' => 'frank@drebin.lan',
      'status'          => 2,
      'invoice'         => null,
    ];

    $query = Query::create()
      ->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->insert($payload)
      ->into('the_table');

    $this->assertEquals(
      "INSERT INTO `the_table` (`the_table`.`name`, `the_table`.`email`, `status`, `invoice`) VALUES ('Frank Drebin', 'frank@drebin.lan', 2, NULL)",
      (string)$query
    );
  }

  public function testUpdate(): void
  {
    $payload = [
      'the_table.name'  => 'Frank Drebin',
      'the_table.email' => 'frank@drebin.lan',
      'status'          => 2,
      'invoice'         => null,
    ];

    $query = Query::create()
      ->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->update($payload)
      ->into('the_table')
      ->where(['user_id' => 156]);

    $this->assertEquals(
      "UPDATE `the_table` SET `the_table`.`name` = 'Frank Drebin', `the_table`.`email` = 'frank@drebin.lan', `status` = 2, `invoice` = NULL WHERE (`user_id` = 156)",
      (string)$query
    );
  }

  public function testDelete(): void
  {
    $query = Query::create()
      ->setEscapeFunction([$this->getPDOInstance(), 'quote'])
      ->delete()
      ->from('the_table')
      ->where(['user_id' => 156]);

    $this->assertEquals('DELETE FROM `the_table` WHERE (`user_id` = 156)', (string)$query);
  }

  private function getPDOInstance(): \PDO
  {
    return (new Database(new SqliteDsn(':memory:')))->pdo();
  }
}
