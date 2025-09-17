<?php
declare(strict_types=1);

namespace BasicApp\Controller;

use BasicApp\Exception\FileNotFoundException;
use BasicApp\Http\Response;
use BasicApp\Http\StatusCode;

final class NotFoundController extends AbstractController
{
    /**
     * @throws FileNotFoundException
     */
    public function __invoke(): Response
    {
        return new Response(
            $this->template->render('error/404.html.tpl'),
            StatusCode::HTTP_NOT_FOUND
        );
    }
}
