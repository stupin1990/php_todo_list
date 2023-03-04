<?php

namespace Src\Core;

final class DB
{
    private \PDO $dbo;

    private static $instance;

    public function __construct()
    {
        try {
            $this->dbo = new \PDO('mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
            $this->dbo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $db = new self();
            self::$instance = $db->dbo;
        }

        return self::$instance;
    }

    public static function Disconnect()
    {
        self::$instance = null;
    }

    public static function getRow(string $query, array $params = [])
    {
        try {
            $res = self::getInstance()->prepare($query);
            $res->execute($params);
            return $res->fetch();
        } catch(\PDOException $e) {
            return false;
        }
    }

    public static function getRows(string $query, array $params = [])
    {
        try {
            $res = self::getInstance()->prepare($query);
            $res->execute($params);
            return $res->fetchAll();
        } catch(\PDOException $e) {
            return false;
        }
    }

    public static function insertRow(string $query, array $params)
    {
        try {
            $res = self::getInstance()->prepare($query);
            $res->execute($params);
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    public static function updateRow(string $query, array $params)
    {
        return self::insertRow($query, $params);
    }

    public static function deleteRow(string $query, array $params = [])
    {
        return self::insertRow($query, $params);
    }
}
