<?php

namespace App\Connections;

use App\Config;

class SQLiteConnection extends DbConnection
{
    public function __construct()
    {
        $dsn="sqlite:" . Config::SQLITE_PATH;
        parent::__construct($dsn,Config::SQLITE_GUEST_USERNAME,Config::SQLITE_GUEST_PASSWORD);
    }


}