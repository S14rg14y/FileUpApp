<?php

use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteCollectorProxy;


return function (App $app) {

    $container = $app->getContainer();

    $app->post('/', function (Request $request, Response $response) {

        $directory = $this->get('settings')['upload_directory'];
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['userFile'];
        $this->get('uploadController')->saveFileOnDisk($uploadedFile, $directory);
        return $response;
        
    });

    $app->group('', function (RouteCollectorProxy $group) {

        $group->get('/views/{name}', function ($request, $response, $args) {
            $view = 'example.twig';
            $name = $args['name'];
            return $this->get('view')->render($response, $view, compact('name'));
        });

        $group->get('/', function (Request $request, Response $response) {
            $view = 'index.twig';
            $files = $this->get('downloadController')->getRecentFiles();
            return $this->get('view')->render($response, $view, compact('files'));
        });

        $group->get('/upload', function (Request $request, Response $response) {
            $view = 'upload.twig';
            return $this->get('view')->render($response, $view);
        })->setName('upload');

    })->add($container->get('viewMiddleware'));


};
