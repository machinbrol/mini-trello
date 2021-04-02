<?php

require_once "autoload.php";

abstract class BaseDao extends CachedGet {
    protected const PkName = "ID";

    public static function get_by(array $params) {
        $sql = new SqlGenerator(static::tableName);
        list($sql, $params) = $sql->select()->where($params)->get();

        return self::get_one($sql, $params);
    }

    public static function get_by_id(string $id) {
        return self::get_by([static::PkName => $id]);
    }

    public static function get_all(array $params=null) {
        $sql = new SqlGenerator(static::tableName);

        $sql = $sql->select();
        if (!is_null($params)) {
            $sql = $sql->where($params);
        }
        list($sql, $params) = $sql->get();

        return self::get_many($sql, $params);
    }

    public static function insert($object) {
        $map = static::get_object_map($object);
        $sql = new SqlGenerator(static::tableName);
        list($sql, $params) = $sql->insert($map)->get();
        self::execute($sql, $params);

        if (static::PkName != null) {
            $object->set_id(self::lastInsertId());
        }

        return $object;
    }

    public static function update($object) {
        $map = $object->get_object_map();
        $sql = new SqlGenerator(static::tableName);

        list($sql, $params) = $sql->update($map)->where([static::PkName => $object->get_id()])->get();

        self::execute($sql, $params);
    }

    public static function delete($object) {
        $sql = new SqlGenerator(static::tableName);
        list($sql, $params) = $sql->delete()->where([static::PkName => $object->get_id()])->get_preparable();
        self::execute($sql, $params);

    }

    public static function delete_all(array $params) {
        $sql = new SqlGenerator(static::tableName);
        list($sql, $params) = $sql->delete()->where($params)->get();
        self::execute($sql, $params);
    }


    protected static function get_one($sql, $params, $cache=true) {
        $key = self::get_key_for($params);

        if (!self::is_in_cache($key)) {
            $query = self::execute($sql, $params);
            $data = $query->fetch();

            $result = $query->rowCount() != 0 ? static::from_query($data) : null;

            // static::PkName == null dans les tables de jointure
            if (static::PkName == null) {
                return $result;
            }

            self::cache_result($result, $key);

            // au cas où requête sur user.Mail (ou autre chose ?)
            if (isset($result) && count($params) == 1 && !array_key_exists("ID", $params)) {
                $id_key = self::get_key_for([static::PkName => $result->get_id()]);
                self::cache_result($result, $id_key);
            }
        }
        return self::get_cached($key);
    }


    protected static function get_many($sql, $params, callable $constructor=null): array {
        $query = self::execute($sql, $params);
        $datas = $query->fetchAll();

        if (is_null($constructor)) {
            $constructor = function($data) {return static::from_query($data);};
        }

        $instances = [];

        foreach ($datas as $data) {
            $inst = $constructor($data);

            // static::PkName == null dans tables de jointure -> on met pas en cache
            if (static::PkName != null) {
                // mise en cache sous 'static::PkName' ("ID" en principe)
                $key = self::get_key_for([static::PkName => $inst->get_id()]);
                self::cache_result($inst, $key);
            }

            $instances[] = $inst;
        }
        return $instances;
    }

    protected static function count($sql, $params): int {
        return (int) self::execute($sql, $params)->fetch()["total"];
    }


    // -- dates --
    // TODO: dans "Utils" à nouveau ?

    public static function php_date($sqlDate): ?DateTime {
        return $sqlDate != null ? new DateTime($sqlDate) : null;
    }

    public static function sql_date(?DateTime $dateTime): ?string {
        return $dateTime != null ? $dateTime->format('Y-m-d H:i:s') : null;
    }

}