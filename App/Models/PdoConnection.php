<?php

namespace App\Models;

class PdoConnection{

    private $PDO;
    private $settings;


    public function __construct(array $settings){

        $this->settings = $settings;
        $this->connect();
        
    }

    private function connect(): void{

        $options = array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8, sql_mode=STRICT_ALL_TABLES'
        );
        try{
            $this->PDO = new \PDO(
            $this->settings['dsn'], $this->settings['dbuser'], $this->settings['dbpass'], $options);
        }catch(\PDOException $e){
            echo "connection failed".$e;
        }

    }

    public function getConnection(): \PDO{
        
        return $this->PDO;

    }
}