<?php

namespace TestApi\Config;

use mysqli;

class DB
{
    private mysqli $connection;
    private string $host = 'localhost';
    private string $user = 'root';
    private string $pwd = '146j2gcks4zxz';
    private string $database = 'test_work';

    public function __construct()
    {
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