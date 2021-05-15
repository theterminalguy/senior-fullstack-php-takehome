<?php

namespace Application\config;

use PDO;

(new DotEnv())->load();

class MysqlDBAdapter implements IDatabaseAdapter
{
    private string $db_host;
    private string $db_name;
    private string $db_username;
    private string $db_password;

    public function __construct(
        string $host = null,
        string $database = null,
        string $username = null,
        string $password = null
    )
    {
        $this->db_host = $host ?? getenv('DB_HOST');
        $this->db_name = $database ?? getenv('DB_NAME');
        $this->db_username = $username ?? getenv('DB_USERNAME');
        $this->db_password = $password ?? getenv('DB_PASSWORD');
    }

    public function getConnection()
    {
        try {
            $conn = new PDO(
                'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name,
                $this->db_username,
                $this->db_password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (\PDOException $e) {
            echo 'Could not connect to database ' . $e->getMessage();
            exit;
        }
    }
}
