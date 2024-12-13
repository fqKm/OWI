<?php
class Database {
    private static ?Database $instance = null;
    private mysqli $connection;
    private function __construct() {
        $this->connection = new mysqli("localhost:3306", "root", "", "owi_database");
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    public static function getInstance(): ?Database
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}
