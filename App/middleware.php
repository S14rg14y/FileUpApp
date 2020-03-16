<?php

use Slim\App;
use App\Middleware\ExampleAfterMiddleware;
use App\Middleware\ExampleBeforeMiddleware;
use Slim\Middleware\ErrorMiddleware;

return function (App $app){

    $settings = $app->getContainer()->get('settings');
    $middleware = new ErrorMiddleware(
        $app->getCallableResolver(),
        $app->getResponseFactory(),
        $settings['displayErrorDitails'],
        $settings['logErrors'],
        $settings['logErrorDitails']
    );
    
    $app->add($middleware);
    $app->add(new ExampleAfterMiddleware());
    $app->add(new ExampleBeforeMiddleware());
};