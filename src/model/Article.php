<?php

namespace iutnc\hellokant\model;

use iutnc\hellokant\query\Query;

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

    static function all()
    {
        return Query::table(static::$table)
            ->select(['*'])
            ->get();
    }

    static function find($criter = [], $columns = ['*'])
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

    static function first($criter = [], $columns = ['*'])
    {
        $results = Article::find($criter, $columns);
        return (!empty($results)) ? $results[0] : null;
    }

    public function categorie()
    {
        return $this->belongs_to('categorie', 'id_categ');
    }


}