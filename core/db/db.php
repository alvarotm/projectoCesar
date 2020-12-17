<?php
namespace core\db;

use core\db\Connection;

class db
{

    protected function execute($sql, $params)
    {
        $pdo = Connection::getInstance()::getPDO();
        $ps = $pdo->prepare($sql);
        $ps->execute($params);
        return $ps->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function select($nombreTabla, $campos = ["*"], $condiciones = null, $params = null){
        $sql = "SELECT ";
        foreach($campos as $campo){
            $sql .= "$campo, ";
        }
        $sql = substr($sql, 0, -2) . " FROM $nombreTabla";

        if (!empty($condiciones)){
            $sql .= " WHERE " . $condiciones;
        }
        return db::execute($sql, $params);
    }

    protected function insert($table, $insertValues) {
        $fields = '(';
        $values = '(';
        $params = array();
        foreach ($insertValues as $key => $value) {
            $fields .= $key . ',';
            $param = ':' . $key;
            $values .= $param . ',';
            $params[$param] = $value;
        }
        $fields = \substr($fields, 0, -1) . ')';
        $values = \substr($values, 0, -1) . ')';
        $sql = "INSERT INTO $table $fields VALUES $values";
        return db::execute($sql, $params);
    }

    private function edit($table, $editValues, $pkName, $pkValue) {
        $fields = '';
        $params = array();
        foreach ($editValues as $key => $value) {
            if ($key !== '_method') {
                $fields .= "$key = :$key,";
                $param = ':' . $key;
                $params[$param] = $value;
            }
        }
        $fields = \substr($fields, 0, -1);
        $where = "$pkName = :id";
        $params[":id"] = $pkValue;
        $sql = "UPDATE $table SET $fields WHERE $where";
        return db::execute($sql, $params);
    }

    protected function delete($table, $deleteValues, $pkName, $pkValue){
        $params = array();
        foreach($deleteValues as $key => $value){
            if($key !== '_method'){
                $param = ':' . $key;
                $params[$param] = $value;
            }
        }
        $where = "$pkName = :id";
        $params[":id"] = $pkValue;
        $sql = "DELETE FROM $table WHERE $where";
        return db::execute($sql, $params);
    }

    public static function __callStatic($name, $arguments)
    {
        return (new static)->$name(...$arguments);
    }
}