<?php

namespace iutnc\hellokant\model;

abstract class Model
{
    protected static $table;
    protected static $idColumn = 'id';
    protected $atts = [];

    public function __construct(array $t = null)
    {
        if (!is_null($t)) $this->_atts = $t;
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->_atts)) {
            return $this->_atts[$name];
        }elseif (method_exists($this, $name)) {
            return $this->$name();
        }
    }

    public function __set(string $name, mixed $val): void
    {
        $this->atts[$name] = $val;
    }

    public function belongs_to(string $model, string $foreign_key = null): Model
    {
        if (is_null($foreign_key)) {
            $foreign_key = strtolower($model) . '_id';
        }
        $class = 'iutnc\\hellokant\\model\\' . ucfirst($model);
        $obj = new $class();
        $this->atts[$model] = $obj->find([[$obj::$idColumn, '=', $this->atts[$foreign_key]]]);
        return $this;
    }

    public function has_many(string $model, string $foreign_key = null): Model
    {
        if (is_null($foreign_key)) {
            $foreign_key = strtolower(get_class($this)) . '_id';
        }
        $class = 'iutnc\\hellokant\\model\\' . ucfirst($model);
        $obj = new $class();
        $this->atts[$model] = $obj->find([[$foreign_key, '=', $this->atts[$obj::$idColumn]]]);
        return $this;
    }
}
