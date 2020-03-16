<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;
use DI\Container;
require __DIR__.'/../vendor/autoload.php';


$settings = require __DIR__.'/../App/settings.php';
$middleware = require __DIR__.'/../App/middleware.php';
$routers = require __DIR__.'/../App/routers.php';
$view = require __DIR__.'/../App/views.php';
$dependencies = require __DIR__.'/../App/dependencies.php';


$container = new Container();
$settings($container);
$dependencies($container);
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->setBasePath("/fileupload/public");
$view($app);
$middleware($app);
$routers($app);



$app->run();

