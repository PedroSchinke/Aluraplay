<?php 

namespace Dbseller\Aluraplay\Infra\Persistence;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class ConnectionDB
{
    public static function createConnection(): PDO
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $port = $_ENV['DB_PORT']; 

        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'";
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
            return null;
        }
    }
}