<?php
namespace Config;

use PDO;
use PDOException;

class Database
{
    private string $host = 'localhost';
    private string $dbname = 'phppdobd';
    private string $username = 'root';
    private string $password = '';

    public function getConnection(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

            $connection = new PDO($dsn, $this->username, $this->password);

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $connection;
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }
}