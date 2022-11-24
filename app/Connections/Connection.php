<?php

namespace App\Connections;

abstract class Connection
{

    protected $conn;

    public function __construct(protected string $address, protected string $username, protected string $password)
    {
        $this->connect();
    }

    protected abstract function connect();

    public function getConnection()
    {
        return $this->conn;
    }


}