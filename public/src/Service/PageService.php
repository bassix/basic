<?php
declare(strict_types=1);

namespace BasicApp\Service;

use BasicApp\Database\Database;
use BasicApp\Helper\ObjectHelper;
use BasicApp\Model\PageModel;

class PageService
{
  private Database $database;

  public function __construct(Database $database)
  {
    $this->database = $database;
  }

  /**
   * @return PageModel[]
   */
  public function readAll(): array
  {
    $pages = [];

    $page = new PageModel();
    $page->setTitel('TEST');

    $pagesData = $this->database->rows('SELECT * FROM `page` LIMIT 10');

    foreach ($pagesData as $pageData) {
      $pages[] = ObjectHelper::cast($pageData, PageModel::class);
    }

    return $pages;
  }
}
