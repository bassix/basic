<?php
declare(strict_types=1);

namespace BasicApp\Tests\Helper;

use BasicApp\Helper\ObjectHelper;
use BasicApp\Tests\TestModels\BookModel;
use PHPUnit\Framework\TestCase;

class ObjectHelperTest extends TestCase
{
    public function testObjectHelper()
    {
        $class = new \stdClass();
        $class->book_title = 'Test!';
        $class->date_time = '2022-06-30 18:59:59';

        /** @var BookModel $book */
        $book = ObjectHelper::cast($class, BookModel::class);

        $this->assertEquals($class->book_title, $book->getBookTitle());
        $this->assertEquals($class->date_time, $book->getDateTime()->format('Y-m-d H:i:s'));
    }
}
