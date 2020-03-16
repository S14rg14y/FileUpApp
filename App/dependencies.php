<?php

use App\Controllers\DownloadController;
use App\Controllers\UploadController;
use App\Models\PdoConnection;
use DI\Container;
use App\Models\FileMapper;


return function (Container $container){

    $container->set('PDO', function($c){
        return new PdoConnection($c->get('settings')['DBsettings']);
    });
    $container->set('fileMapper', function($c){
        return new FileMapper($c->get('PDO'));
    });
    $container->set('getId3', function(){
        return new \getID3;
    });
    $container->set('uploadController', function($c){
        return new UploadController($c->get('getId3'), $c->get('fileMapper'));
    });
    $container->set('downloadController', function($c){
        return new DownloadController($c->get('fileMapper'));
    });
      
};