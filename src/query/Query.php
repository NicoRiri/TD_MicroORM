<?php

namespace iutnc\hellokant\query;

use PDO;

class Query
{

    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';
    public static function table( string $table) : Query {
        $query = new Query;
        $query->sqltable= $table;
        return $query;
    }
    public function select( array $fields) : Query {
        $this->fields = implode( ',', $fields);
        return $this;
    }

    public function where(string $col, string $op, mixed $val): Query
    {
        if (!is_null($this->where)) {
            $this->where .= ' and ' . $col . $op . '?';
        }
        else {
            $this->where = $col . $op . '?';
        }
        $this->args[] = $val;
        return $this;
    }
    public function get() : Array {
        $ini = parse_ini_file(__DIR__ . "/../db.ini");
        $pdo = new PDO($ini["driver"].":host=".$ini["host"].";dbname=".$ini["dbname"], $ini["user"], $ini["password"]);
        $this->sql = 'select '. $this->fields .
            ' from ' . $this->sqltable . " where " . $this->where;
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function insert([] $args):Array{
        $ini = parse_ini_file(__DIR__ . "/../db.ini");
        $pdo = new PDO($ini["driver"].":host=".$ini["host"].";dbname=".$ini["dbname"], $ini["user"], $ini["password"]);
        $this->sql = 'insert into ' . $this->sqltable . ' values (';
        $this->sql .= implode(',', array_fill(0, count($args), '?'));
        $this->sql .= ')';
        $this->args = $args;
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete():Query{
        $ini = parse_ini_file(__DIR__ . "/../db.ini");
        $pdo = new PDO($ini["driver"].":host=".$ini["host"].";dbname=".$ini["dbname"], $ini["user"], $ini["password"]);
        $this->sql = 'delete FROM ? where ?';
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute([$this->sqltable, $this->where]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }



}