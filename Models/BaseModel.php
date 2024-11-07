<?php

abstract class BaseModel
{
    public static function where(array $data)
    {
        $where = "WHERE ";
        foreach ($data as $key => $value) {
            $where .= $key . " = '" . $value . "' AND ";
        }

        $where = rtrim($where, "AND ");

        $sql = "SELECT * FROM {self::table} " . $where;

        die($sql);
    }
}