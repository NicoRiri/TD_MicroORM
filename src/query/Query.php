<?php

namespace iutnc\hellokant\query;

use iutnc\hellokant\connection\ConnectionFactory;

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
            $this->where .= ' and ' . $col .' ' . $op .' ?';
        }
        else {
            $this->where = $col.' ' . $op .' ?';
        }
        $this->args[] = $val;
        return $this;
    }
    public function get() : Array {
        if(is_null($this->where)){
        $this->sql = 'select '. $this->fields . ' from ' . $this->sqltable;
        }
        else {
            $this->sql = 'select ' . $this->fields .
                ' from ' . $this->sqltable . " where " . $this->where;
        }
        $stmt = ConnectionFactory::getConnection()->prepare($this->sql, $this->args);
        $stmt->execute($this->args);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        var_dump($this->sql);
    }
    public function insert(array $args){
        $this->sql = 'insert into ' . $this->sqltable . ' values (';
        $this->sql .= implode(',', array_fill(0, count($args), '?'));
        $this->sql .= ')';
        $this->args = $args;
        $stmt = ConnectionFactory::getConnection()->prepare($this->sql);
        $stmt->execute($this->args);
        return ConnectionFactory::getConnection()->lastInsertId();
    }

    public function delete(){
        $this->sql = ' delete FROM '.$this->sqltable.' where '.$this->where;
        $stmt = ConnectionFactory::getConnection()->prepare($this->sql);
        $stmt->execute($this->args);
    }



}