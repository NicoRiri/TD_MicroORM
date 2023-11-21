<?php

namespace iutnc\hellokant\model;

class Article extends Model {
    protected static $table='article';
    protected static $idColumn='id';


    public function delete() {
        /* … */
        return Query::table(static::$table)
            ->where( static::$idColumn, '=',
                $this->atts[static::$idColumn] )
            ->delete();
}
}