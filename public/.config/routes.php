<?php
declare(strict_types=1);

use BasicApp\Controller\DefaultController;
use BasicApp\Controller\PagesController;
use BasicApp\Routing\Route;

//$routes[] = Route::get('user/{id}', 'ShowProfile');
//$routes[] = new Route(Route::METHOD_GET, '/foo/([0-9]*)/bar', IndexController::class);
//$routes[] = new Route(Route::METHOD_GET, '/foo/([a-z0-9\-]*)/bar', DefaultController::class);
//$routes[] = new Route(Route::METHOD_GET, '/bulletpoints', BulletPointsController::class);
//$routes[] = new Route(Route::METHOD_GET, '/bullet-points', BulletPointsController::class);
$routes[] = new Route(Route::METHOD_GET, '/pages', PagesController::class);
$routes[] = new Route(Route::METHOD_GET, '/([a-z0-9\-]*)', DefaultController::class);
