<?php

namespace core;

use core\db\db;

class Model
{

    protected $primary_key = "id";

    protected $table;

    protected function all()
    {
        return db::select($this->table);
    }

    protected function find($id)
    {
        $campos = ["*"];
        $where = $this->primary_key . " = :id";
        $params = [
            ":id" => $id
        ];

        return db::select($this->table, $campos, $where, $params);
    }

    protected function belongsToMany($t2, $tj, $pk_tJ1, $pk_tJ2, $pk, $pk_t2)
    {
        $sql = 'SELECT a.* FROM ' . $t2 . ' a ' .
            'JOIN ' . $tj . ' pa ON a.' . $pk_t2 . ' = pa.' . $pk_tJ2 . ' ' .
            'JOIN peliculas p ON p.' . $pk_t2 . '= pa.' . $pk_tJ1 . ' AND p.id = :id_pelicula';

        $params = [
            ":id_pelicula" => $pk
        ];

        return db::execute($sql, $params);
    }

    protected function hasMany($t2, $fk_t2, $pk) {
        $sql = "SELECT t2.* FROM $t2 t2
        JOIN $this->table t1 ON t1.$this->primary_key = t2.$fk_t2
        AND t1.$this->primary_key = :id";
        $params = [
        ":id" => $pk
        ];
        return db::execute($sql, $params);
    }

    protected function insert() {
        $result = db::insert($this->table, $_POST);
        return $result;
    }

    protected function edit($pk) {
        $result = db::edit($this->table, $_POST, $this->primary_key, $pk);
        return $result;
    }

    protected function delete($pk){
        $result = db::delete($this->table, $_POST, $this->primary_key, $pk);
        return $result;
    }

    public static function __callStatic($name, $arguments)
    {
        return (new static)->$name(...$arguments);
    }
}
