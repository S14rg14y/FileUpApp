<?php


use DI\Container;


return function (Container $container){
    $container->set('settings', function(){
        return [
            'name'=>'UploadApp',
            'displayErrorDitails'=>true,
            'logErrorDitails'=>true,
            'logErrors'=>true,
            'upload_directory'=>__DIR__ . '/../uploads',
            'views'=>[
                'path'=>__DIR__.'/../template',
                'settings'=>[
                    'cache'=>false
                ]
                ],
            'DBsettings'=>[
                'dbuser'=>'students',
                'dbpass'=>'students',
                'dsn'=>'mysql:host=localhost;dbname=students'
            ]
            
        ];
    });
};