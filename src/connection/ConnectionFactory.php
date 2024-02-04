<?php

namespace iutnc\hellokant\connection;

use PDO;

class ConnectionFactory
{

    private static $pdo;
    
    public static function makeConnection(array $config){
        self::$pdo = new PDO($config["driver"].":host=".$config["host"].";port=".$config["port"].";dbname=".$config["database"], $config["username"], $config["password"]);
    }

    public static function getConnection(){
        return self::$pdo;
    }

}