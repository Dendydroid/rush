<?php

namespace App\ServiceFactory;

use PDO;

final class PdoFactory
{
    public function create(): PDO
    {
        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_DATABASE'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $port = $_ENV['DB_PORT'];
        $dsn = "pgsql:host=$host;port=$port;dbname=$db;";
        return new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
}
