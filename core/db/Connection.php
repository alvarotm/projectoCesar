<?php

namespace core\db;

class connection {

    protected static $instance;
    protected $pdo;

    protected function __construct()
    {
        try {
            $this->pdo = new \PDO($_ENV['DB_CONNECTION'].':host='.
                $_ENV['DB_HOST'].';dbname='.$_ENV['DB_DATABASE'],
                $_ENV['DB_USERNAME'],$_ENV['DB_PASSWORD']);            
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function getPDO(){
        return $this->pdo;
    }

    protected function getInstance() {

        if(self::$instance == null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public static function __callStatic($name, $arguments){
        return (new static)->$name(...$arguments);
    }
}