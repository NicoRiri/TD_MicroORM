<?php

require_once "../../vendor/autoload.php";

$conf = parse_ini_file("../db.ini");
\iutnc\hellokant\connection\ConnectionFactory::makeConnection($conf);

//$q = \iutnc\hellokant\query\Query::table("article")->select(["nom"])->get();
//var_dump($q);

//$q = \iutnc\hellokant\query\Query::table("article")->insert([10, "nezClement", "ilébo", 10.5, 1]);
//var_dump($q);

//$q = \iutnc\hellokant\query\Query::table("article")->where("nom", "=", "nezClement")->delete();
//var_dump($q);