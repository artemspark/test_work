<?php

namespace TestApi\Config;

use mysqli;

class DB
{
    private mysqli $connection;
    private string $host;
    private string $user;
    private string $pwd;
    private string $database;

    public function __construct()
    {
        $this->database = getenv('DB');
        $this->host = getenv('DB_HOST');
        $this->user = getenv('DB_USER');;
        $this->pwd = getenv('DB_PASS');

        $this->connection = new mysqli($this->host, $this->user, $this->pwd, $this->database);
        if (!$this->connection) {
            throw new RuntimeException('Can not connect to db');
        }
    }

    /**
     * @return mysqli
     */
    public function getConnection(): mysqli
    {
        return $this->connection;
    }

}