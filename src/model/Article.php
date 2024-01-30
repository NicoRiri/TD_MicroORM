<?php

namespace iutnc\hellokant\model;

class Article extends Model
{
    protected static $table = 'article';
    protected static $idColumn = 'id';


    public function delete()
    {
        return Query::table(static::$table)
            ->where(static::$idColumn, '=',
                $this->atts[static::$idColumn])
            ->delete();
    }

    public function all()
    {
        return Query::table(static::$table)
            ->select(['*'])
            ->get();

    }

    public function find($criter = [], $columns = ['*'])
    {
        $query = Query::table(static::$table)->select($columns);
        if (!empty($criter)) {
            foreach ($criter as $condition) {
                list($column, $operator, $value) = $condition;
                $query->where($column, $operator, $value);
            }
        }
        return $query->get();
    }

    public function first($criter = [], $columns = ['*'])
    {
        $results = $this->find($criter, $columns);
        return (!empty($results)) ? $results[0] : null;
    }


}