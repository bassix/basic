<?php
declare(strict_types=1);

namespace BasicApp\Controller;

use BasicApp\Http\Response;
use BasicApp\Http\StatusCode;

final class NotFoundController extends AbstractController
{
  public function __invoke(): Response
  {
    return new Response(
      $this->container['template']->render('page/404.html.tpl'),
      StatusCode::HTTP_NOT_FOUND
    );
  }
}
