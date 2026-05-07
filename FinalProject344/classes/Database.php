<?php
require_once __DIR__ . '/../config/config.php';

class Database {
public $conn = null;

    public function connect() {
        if ($this->conn == null) {
            try {
                $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                echo "Connected.";
            } catch (mysqli_sql_exception $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}