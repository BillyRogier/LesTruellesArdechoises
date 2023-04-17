<?php

namespace Core\Database;

use \PDO;

class Database
{
    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;

    public function __construct($db_name, $db_user = "root", $db_pass = "root", $db_host = "localhost")
    {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    private function getPDO()
    {
        if ($this->pdo === null) {
            $pdo = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . "", $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function query(string $request, $class_name = null, $arg = null, $one = false)
    {
        $stmt = $this->getPDO()->query($request);
        if ($class_name === null) {
            $stmt->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class_name, $arg);
        }
        if ($one) {
            return $stmt->fetch();
        } else {
            return $stmt->fetchAll();
        }
    }

    public function prepare(string $request, array $value, $class_name = null, $arg = null, $one = false)
    {
        $stmt = $this->getPDO()->prepare($request);
        $stmt->execute($value);
        if ($class_name === null) {
            $stmt->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class_name, [$arg]);
        }
        if ($one) {
            return $stmt->fetch();
        } else {
            return $stmt->fetchAll();
        }
    }

    public function lastInsertId()
    {
        return $this->getPDO()->lastInsertId();
    }
}
