<?php

declare(strict_types=1);

namespace BasicApp\Controller;

use BasicApp\Exception\FileNotFoundException;
use BasicApp\Http\Response;
use BasicApp\Http\StatusCode;

final class DefaultController extends AbstractController
{
  /**
   * @throws FileNotFoundException
   */
  public function __invoke(): Response
  {
    //$args = func_get_args();
    //dd(self::class, func_num_args(), func_get_args(), $args);
    //extract($args, EXTR_REFS);
    //dd($page, "page/{$page}.html.tpl");
    //dd($template);
    //dd($template->render("page/{$page}.html.tpl"));

    return new Response(
      $this->template->render("page/{$this->page}.html.tpl"),
      StatusCode::HTTP_OK
    );
  }
}
