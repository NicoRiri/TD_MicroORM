<?php

namespace iutnc\hellokant\connection;

use PDO;

class ConnectionFactory
{

    private static $pdo;
    
    public static function makeConnection(array $config){
        self::$pdo = new PDO($config["driver"].":host=".$config["host"].";dbname=".$config["dbname"], $config["user"], $config["password"]);
    }

    public static function getConnection(){
        return self::$pdo;
    }

}