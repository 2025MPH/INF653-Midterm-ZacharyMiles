<?php
class Database {
    private $conn;
    // Render credentials:
    private $host = 'dpg-cvfjpn52ng1s73d7glj0-a.ohio-postgres.render.com';
    private $port = '5432';
    private $dbname = 'quotesdb';
    private $username = 'zsmiles';
    private $password = 'Btab0uFR0RKNGjxKnZJyuRpOq4k8FvQI';

    public function connect() {
        if ($this->conn) {
            return $this->conn;
        }
        $dsn = 'pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname;
        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
            return null;
        }
    }
}
?>
