<?php

class Database
{
    private $conn;
    private $error;

    public function connect()
    {
        try {
            $conn = new PDO("mysql:host=" . config('db.host') . ";port=". config('db.port') .";dbname=" . config('db.database'),
                config('db.user'),
                config('db.password'),
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
        } catch(PDOException $e) {
            $this->error = 'ERROR: ' . $e->getMessage();
        }
    }

    public function disconnect()
    {
        $this->conn = null;
    }

    public static function read($sql, $params = [])
    {
        $db = new Database();

        $db->connect();
        $stmt = $db->conn->prepare($sql);
        $stmt->execute($params);

        $data = [];

        while($row = $stmt->fetch()) {
            $data[] = $row;
        }

        $db->disconnect();

        return $data;
    }

    public static function insert($table, $variables)
    {
        $columns = [];
        $values = [];

        foreach($variables as $key=>$variable) {
            $columns[] = $key;
            $values[] = "'" . $variable . "'";
        }
        $sql = "INSERT INTO {$table} (" . implode(",", $columns) . ") VALUES (" . implode(",", $values) . ");";

        $db = new Database();
        $db->connect();
        $stmt = $db->conn->prepare($sql);
        $stmt->execute();

        $db->disconnect();
    }

    public static function update($table, $values, $id)
    {
        $updates = [];
        foreach($values as $key => $value) {
            $updates[] = $key . "= '{$value}'";
        }

        $db = new Database();
        $db->connect();

        $sql = "UPDATE {$table} SET " . implode(',', $updates) . " WHERE id = :id;";
        $stmt = $db->conn->prepare($sql);
        $execute = $stmt->execute(["id" => $id]);
        $db->disconnect();

        return $execute;
    }
}