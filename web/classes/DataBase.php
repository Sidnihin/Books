<?php

class Database {
    private $conn;

    public function __construct($host, $port, $dbname, $user, $password) {
        try {
            $this->conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}