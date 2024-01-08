<?php
declare(strict_types=1);

namespace BasicApp\Controller;

use BasicApp\Exception\FileNotFoundException;
use BasicApp\Http\Response;
use BasicApp\Http\StatusCode;
use BasicApp\Service\PageService;

final class PagesController extends AbstractController
{
  public function __invoke(): Response
  {
    $pageService = new PageService($this->database);
    $pages = $pageService->readAll();

    try {
      return new Response(
        $this->template->render('page/pages.html.tpl', ['pages' => $pages]),
        StatusCode::HTTP_OK
      );
    } catch (FileNotFoundException $e) {
      $this->logger->error($e->getMessage());

      return new Response('Page not found!',StatusCode::HTTP_NOT_FOUND);
    }
  }
}
