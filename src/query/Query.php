<?php

namespace iutnc\hellokant\query;

class Query
{

    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';

    public static function table(string $table): Query
    {
        $query = new Query;
        $query->sqltable = $table;
        return $query;
    }

    public function select(array $fields): Query
    {
        $this->fields = implode(',', $fields);
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

    public function get(): array
    {
        $this->sql = 'select ' . $this->fields .
            ' from ' . $this->sqltable;
        /* … */
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}